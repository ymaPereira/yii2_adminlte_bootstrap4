<?php

namespace backend\controllers;

use Yii;
use common\models\User;
use backend\models\UserSearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use backend\models\AuthItem;
use backend\models\AuthAssignment;
use yii\filters\AccessControl;
/**
 * UserController implements the CRUD actions for User model.
 */
class UserController extends Controller
{
    /**
     * {@inheritdoc}
     */
    public function behaviors()
    {
        return [
            'access' => [
                'class' => AccessControl::className(),
                'rules' => [
                    [
                        'actions' => ['profile'],
                        'allow' => true,
                        'roles' => ['@'],
                    ],
                    [
                        'actions' => ['update-data'],
                        'allow' => true,
                        'roles' => ['@'],
                    ],
                    [
                        'allow' => true,
                        'actions' => ['index'],
                        'roles' => ['user/index'],
                    ],
                    [
                        'allow' => true,
                        'actions' => ['create'],
                        'roles' => ['user/create'],
                    ],
                    [
                        'allow' => true,
                        'actions' => ['update'],
                        'roles' => ['user/update'],
                    ],
                    [
                        'allow' => true,
                        'actions' => ['delete'],
                        'roles' => ['user/delete'],
                    ],
                    [
                        'allow' => true,
                        'actions' => ['view'],
                        'roles' => ['user/view'],
                    ],
                    [
                        'allow' => true,
                        'actions' => ['change-profile'],
                    ],
                ]
            ],
            'verbs' => [
                'class' => VerbFilter::className(),
                'actions' => [
                    'delete' => ['POST'],
                ],
            ],
        ];
    }

    /**
     * Lists all User models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new UserSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single User model.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionView($id)
    {
        return $this->render('view', [
            'model' => $this->findModel($id),
        ]);
    }

    /**
     * Creates a new User model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new User();
        $modelAuth = new AuthItem();
        $profile = $modelAuth->getProfiles(); 
        $model->scenario = 'user';

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            foreach ($model->profile as $value) {
               if(AuthItem::findOne($value)!=null){
                    $role=\Yii::$app->authManager->getRole($value);
                    \Yii::$app->authManager->assign($role,$model->id);
                }
            }
            return $this->redirect(['view', 'id' => $model->id]);
        }

        return $this->render('create', [
            'model' => $model,'profile'=>$profile,'value'=>[]
        ]);
    }

    /**
     * Updates an existing User model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);
        $modelAuth = new AuthItem();
        $profile = $modelAuth->getProfiles();
        $model->scenario = 'user';

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            \Yii::$app->authManager->revokeAll($id);
            foreach ($model->profile  as $key => $value) {
                $role=\Yii::$app->authManager->getRole($value);
                if($role!=null){
                    \Yii::$app->authManager->assign($role,$model->id);    
                }
            }
            return $this->redirect(['view', 'id' => $model->id]);
        }
        $model->password_hash='';
        $model->profile = User::getMyProfiles($id);
        return $this->render('update', [
            'model' => $model,'profile'=>$profile
        ]);
    }

    /**
     * Deletes an existing User model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionDelete($id)
    {
        $this->findModel($id)->delete();

        return $this->redirect(['index']);
    }

    public function actionProfile(){
        $model = $this->findModel(\Yii::$app->user->identity->id);
        $model->scenario = 'update_pw';
        if($model->load(Yii::$app->request->post())){
            $model->password_hash = $model->new_password;
            if($model->save()){
                Yii::$app->session->setFlash('message', '<div class="alert alert-success">Password alterada com sucesso!</div>');
            }else{
                foreach ($model->getErrors() as $key => $value) {
                  Yii::$app->session->setFlash('message', '<div class="alert alert-danger">'.$value[0].'</div>');
                }
            }           
        }
        $model->password_hash = '';
        return $this->render('profile',[
            'model' => $model
        ]);
    }

    public function actionChangeProfile($role){
        $myRoles = array_keys(\Yii::$app->authManager->getRolesByUser(\Yii::$app->user->identity->id));
        $search = in_array($role, $myRoles);
        \Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;
        if(!empty($search) && $search == 1){
            $session = new \yii\web\Session;
            $session->open();
            $session->set('role',$role);
            $session->close();
            Yii::$app->message->setSuccess('Perfil alterado com sucesso!');
            return ['status' => 1];
        }
            Yii::$app->message->setError('Não foi possivel alterar perfil!');
        return ['status' => 0];
    }

    public function actionUpdateData($id){
        $model = $this->findModel($id);
        $model2 = clone $model;
        $model->scenario = 'update_data';
        if ($model->load(Yii::$app->request->post())) {
            if($model->save())
                return $this->redirect(['profile']);
        }
        $model->password_hash = '';
        return $this->render('altera_dados', [
            'model' => $model
        ]);
    }
    /**
     * Finds the User model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return User the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = User::findOne($id)) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }
}