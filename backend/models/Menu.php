<?php

namespace backend\models;

use Yii;

/**
 * This is the model class for table "menu".
 *
 * @property int $id
 * @property string $name
 * @property int $parent
 * @property string $route
 * @property int $order
 * @property resource $data
 *
 * @property Menu $parent0
 * @property Menu[] $menus
 */
class Menu extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'menu';
    }
    public function beforeSave($insert){
        if(parent::beforeSave($insert)){
            if(empty($this->id)){
                $this->id = \backend\components\UUID::v4();
            }
            $this->order = empty($this->order)?0:$this->order;
            return true;
        }
        return false;
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['name'], 'required'],
            [['order'], 'integer'],
            /*[['data'], 'string'],*/
            [['parent','name'], 'string', 'max' => 128],
            [['route'], 'string', 'max' => 255],
            [['parent'], 'exist', 'skipOnError' => true, 'targetClass' => Menu::className(), 'targetAttribute' => ['parent' => 'id']],
        ];
    }

    public function validatePermission($attribute,$params){
        if(empty($this->route) && $this->parent==0){
            $this->addError($attribute,'A Página não pode ficar em branco');
        }
    }


    public function getMenuPai(){
        $query = self::find()->where('route is null')->orWhere('route =\'\'')->all();
        return \yii\helpers\ArrayHelper::map($query,'id','name');
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'name' => 'Descricao',
            'parent' => 'Menu Pai',
            'route' => 'Pagina',
            'order' => 'Ordem',
            'data' => 'Data',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getParent0()
    {
        return $this->hasOne(Menu::className(), ['id' => 'parent']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getMenus()
    {
        return $this->hasMany(Menu::className(), ['parent' => 'id']);
    }
}
