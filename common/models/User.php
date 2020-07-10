<?php
namespace common\models;

use Yii;
use yii\base\NotSupportedException;
use yii\behaviors\TimestampBehavior;
use yii\db\ActiveRecord;
use yii\web\IdentityInterface;
use backend\models\AuthAssignment;
use yii\helpers\Html;

/**
 * User model
 *
 * @property string $id
 * @property string $username
 * @property string $nome
 * @property string $telefone1
 * @property string $telefone2
 * @property string $password_hash
 * @property string $password_reset_token
 * @property string $email
 * @property string $auth_key
 * @property integer $status
 * @property integer $created_at
 * @property integer $updated_at
 * @property string $password write-only password
 */
class User extends ActiveRecord implements IdentityInterface
{
    const STATUS_DELETED = 0;
    const STATUS_ACTIVE = 10;
    public $profile;
    public $current_password;
    public $new_password;
    public $confirm_password;

    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return '{{%user}}';
    }

    /**
     * {@inheritdoc}
     */
    public function behaviors()
    {
        return [
            TimestampBehavior::className(),
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['username','password_hash', 'email', 'profile','nome'], 'required', 'on' => 'user'],
            [['telefone1','id','nome'], 'required', 'on' => 'update_data'],
            [['id','current_password','new_password','confirm_password'], 'required', 'on' => 'update_pw'],
            [['current_password'],'validateCurrentPassword'],
            [['confirm_password'],'compare','compareAttribute' => 'new_password','message' => 'Password nao correspondentes'],
            [['status','telefone1','telefone2'], 'integer'],            
	        [['created_at', 'updated_at'], 'safe'],
	    [['username'],'unique'],
	    [['email'],'unique'],
            [['username', 'auth_key'], 'string', 'max' => 32],
            [['password_hash', 'password_reset_token', 'email','id','nome'], 'string', 'max' => 255],
            ['status', 'default', 'value' => self::STATUS_ACTIVE],
            ['status', 'in', 'range' => [self::STATUS_ACTIVE, self::STATUS_DELETED]],
        ];
    }

    public function validateCurrentPassword(){
        if(!$this->verifyPassword($this->current_password)){
            $this->addError("current_password","Password incorreto");
        }
    }

    public function verifyPassword($password){
        $pw = static::findOne(['id' => \Yii::$app->user->identity->id,'status' => self::STATUS_ACTIVE])->password_hash;
        return \Yii::$app->security->validatePassword($password,$pw);
    }

    public function scenarios() {
        $scenarios = parent::scenarios();
        $scenarios['update_data'] = ['email', 'telefone1','telefone2','nome','id'];  
        $scenarios['update_pw'] = ['id','current_password','new_password','confirm_password']; 
        $scenarios['user'] = ['username','password_hash', 'email', 'profile','nome','telefone1','telefone2','created_at','status'];

	return $scenarios;
    }

    public function getProfiles(){
        $auth = new AuthAssignment();
        $result = "";
        foreach ($auth->getProfilesByUser($this->id) as $value) {
           $result .= Html::a($value->item_name, $value->itemName->description).'<br/>';
        }
        return $result;
    }

    public static function getMyProfiles($id){
        return \yii\helpers\ArrayHelper::map(\Yii::$app->authManager->getRolesByUser($id),'name','description');
    }

    public function beforeSave($insert){
        if(parent::beforeSave($insert)){
            if(empty($this->id)){
                $this->id = \backend\components\UUID::v4();
                $this->created_at = date('Y-m-d');
                $this->generateAuthKey();
         		$this->updated_at = null;
            }else{
                $this->updated_at = date('Y-m-d');
            }
            $this->setPassword($this->password_hash);
            return true;
        }
        return false;
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'username' => 'Username',
            'auth_key' => 'Auth Key',
            'password_hash' => 'Password',
            'password_reset_token' => 'Password Reset Token',
            'email' => 'Email',
            'status' => 'Status',
            'created_at' => 'Data de criação',
            'updated_at' => 'Data de atualização',
            'profile' => 'Perfil',
    	    'nome' => 'Nome',
    	    'telefone1' => 'Telefone 1',
    	    'telefone2' => 'Telefone 2',
        ];
    }
    /**
     * {@inheritdoc}
     */
    public static function findIdentity($id)
    {
        return static::findOne(['id' => $id, 'status' => self::STATUS_ACTIVE]);
    }

    /**
     * {@inheritdoc}
     */
    public static function findIdentityByAccessToken($token, $type = null)
    {
        throw new NotSupportedException('"findIdentityByAccessToken" is not implemented.');
    }

    /**
     * Finds user by username
     *
     * @param string $username
     * @return static|null
     */
    public static function findByUsername($username)
    {
        return static::findOne(['username' => $username, 'status' => self::STATUS_ACTIVE]);
    }

    /**
     * Finds user by password reset token
     *
     * @param string $token password reset token
     * @return static|null
     */
    public static function findByPasswordResetToken($token)
    {
        if (!static::isPasswordResetTokenValid($token)) {
            return null;
        }

        return static::findOne([
            'password_reset_token' => $token,
            'status' => self::STATUS_ACTIVE,
        ]);
    }

    /**
     * Finds out if password reset token is valid
     *
     * @param string $token password reset token
     * @return bool
     */
    public static function isPasswordResetTokenValid($token)
    {
        if (empty($token)) {
            return false;
        }

        $timestamp = (int) substr($token, strrpos($token, '_') + 1);
        $expire = Yii::$app->params['user.passwordResetTokenExpire'];
        return $timestamp + $expire >= time();
    }

    /**
     * {@inheritdoc}
     */
    public function getId()
    {
        return $this->getPrimaryKey();
    }

    /**
     * {@inheritdoc}
     */
    public function getAuthKey()
    {
        return $this->auth_key;
    }

    /**
     * {@inheritdoc}
     */
    public function validateAuthKey($authKey)
    {
        return $this->getAuthKey() === $authKey;
    }

    /**
     * Validates password
     *
     * @param string $password password to validate
     * @return bool if password provided is valid for current user
     */
    public function validatePassword($password)
    {
        return Yii::$app->security->validatePassword($password, $this->password_hash);
    }

    /**
     * Generates password hash from password and sets it to the model
     *
     * @param string $password
     */
    public function setPassword($password)
    {
        $this->password_hash = Yii::$app->security->generatePasswordHash($password);
    }

    /**
     * Generates "remember me" authentication key
     */
    public function generateAuthKey()
    {
        $this->auth_key = Yii::$app->security->generateRandomString();
    }

    /**
     * Generates new password reset token
     */
    public function generatePasswordResetToken()
    {
        $this->password_reset_token = Yii::$app->security->generateRandomString() . '_' . time();
    }

    /**
     * Removes password reset token
     */
    public function removePasswordResetToken()
    {
        $this->password_reset_token = null;
    }
}