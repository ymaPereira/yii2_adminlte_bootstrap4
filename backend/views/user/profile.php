<?php
  use yii\helpers\Html;
  use yii\helpers\Url;
  use yii\web\View;
  use yii\widgets\ActiveForm;
  $asset = backend\assets\AppAsset::register($this);
$baseUrl = $asset->baseUrl;

 $this->registerJs(
    "
    function changeProfile(obj){
      $.get('index.php?r=user/change-profile&role='+obj.value, function(data, status){
         if(data.status == 1){
          location.reload();
         }
      });
    }

    function changePW(){
        $('#change_pw').css('display','block');
        $('#submit_btn_change_pw').css('display','block');
        $('#btn_change_pw').css('display','none');
     }
    ",
    View::POS_HEAD,
    'change_pw_js'
);
?>
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1>Profile</h1>
          </div>
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="#">Home</a></li>
              <li class="breadcrumb-item active">User Profile</li>
            </ol>
          </div>
        </div>
      </div><!-- /.container-fluid -->
    </section>

    <!-- Main content -->
    <section class="content">
      <div class="container-fluid">
        <div class="row">
          <div class="col-md-12">
          <?php \Yii::$app->message->printMessage(); ?> 
        </div>
          <div class="col-md-5">

            <!-- Profile Image -->
            <div class="card card-primary card-outline">
              <div class="card-body box-profile">
                <div class="text-center">
                  <img class="profile-user-img img-fluid img-circle"
                       src="<?= $baseUrl ?>/dist/img/avatar5.png"
                       alt="User profile picture">
                </div>

                <h3 class="profile-username text-center"><?= $model->username ?></h3>

                <p class="text-muted text-center"><?= $model->nome ?></p>

                <ul class="list-group list-group-unbordered mb-3">
                  <li class="list-group-item">
                    <b>Email:</b> <a class="float-right"><?= $model->email ?></a>
                  </li>
                  <li class="list-group-item">
                    <b>Telefone 1:</b> <a class="float-right"><?= $model->telefone1 ?></a>
                  </li>
                  <li class="list-group-item">
                    <b>Telefone 2:</b> <a class="float-right"><?= $model->telefone2 ?></a>
                  </li>
                  <li class="list-group-item">
                    <b>Perfil atual:</b> <a class="float-right"><?= backend\models\AuthItem::getDescriptionRole(Yii::$app->session->get('role')) ?></a>
                  </li>
                </ul>

                <a href="<?= Url::to(['user/update-data', 'id' => $model->id])?>" class="btn btn-primary btn-block"><b>Alterar Dados do Perfil</b></a>

              </div>
              <!-- /.card-body -->
            </div>
            <!-- /.card -->            
          </div>
          <!-- /.col -->
          <div class="col-md-7">
            <!-- About Me Box -->
            <div class="card card-primary">
              <div class="card-header">
                <h3 class="card-title">Perfil</h3>
              </div>
              <?php 
              if(\Yii::$app->session->hasFlash('message')){
                  echo "<br/>".\Yii::$app->session->getFlash('message');
              }
              ?>
              <!-- /.card-header -->
              <div class="card-body">
              
                <?php
                $role = \common\models\User::getMyProfiles(\Yii::$app->user->identity->id);
                if(sizeof($role) <= 1){
                  foreach ($role as $key => $value) {?>
                      <p class="text-muted"><?= $value ?></p>

                      <hr> 
                      <br/>
                      <?php
                  }
                }else{
                 $role = array_merge(['name'=>null,'description'=>'--- Selecionar pefil ---'],$role);
                 echo \kartik\select2\Select2::widget([
                            'name' => 'profile',
                            'data' => $role,
                            'class'=>'form-control col-md-7 col-xs-12',
                            'maintainOrder' => true,
                            'toggleAllSettings' => [
                                'selectOptions' => ['class' => 'text-success'],
                                'unselectOptions' => ['class' => 'text-danger'],
                            ],
                            'options' => ['placeholder' => 'Alterar perfil', 'multiple' => false,'onchange' => 'changeProfile(this)'],
                            'pluginOptions' => [
                                'tags' => true,
                                'maximumInputLength' => 100
                            ]
                        ]); 
                }
                ?>
                <hr> 
                <br/>
                 <?php $form = ActiveForm::begin([
                            'options' => [
                                'class' => 'form-horizontal'
                                ]
                        ]); ?>
                     <?= Html::button('<b>Alterar Password</b>', ['class' => 'btn btn-default','id' => 'btn_change_pw','onclick'=>'changePW()','type'=>'button']) ?>
                     
                     <?= Html::submitButton('<b>Alterar Password</b>', ['class' => 'btn btn-danger','id' => 'submit_btn_change_pw','onclick'=>'changePW()','style'=>'display:none']) ?>
                     <div id="change_pw" style="display: none"> 
                           
                        <div class="card-body">
                            
                            <div class="form-group row">
                                <label for="current_password" class="col-sm-4 col-form-label">Password Atual <span class="required">*</span></label>
                                    <div class="col-sm-6">
                                        <?= $form->field($model, 'current_password')->textInput(['maxlength' => true,'class'=>'form-control','type'=>'password','required'=>'required'])->label(false) ?>
                                    </div>
                            </div>
                            <div class="form-group row">
                                <label for="new_password" class="col-sm-4 col-form-label">Nova Password <span class="required">*</span></label>
                                    <div class="col-sm-6">
                                        <?= $form->field($model, 'new_password')->textInput(['maxlength' => true,'class'=>'form-control','type'=>'password','required'=>'required'])->label(false) ?>
                                    </div>
                            </div>
                            <div class="form-group row">
                                <label for="confirm_password" class="col-sm-4 col-form-label">Confirmar Password<span class="required">*</span></label>
                                    <div class="col-sm-6">
                                        <?= $form->field($model, 'confirm_password')->textInput(['maxlength' => true,'class'=>'form-control','type'=>'password','required'=>'required'])->label(false) ?>
                                    </div>
                            </div>
                        </div>        
                        <!-- /.card-body -->
              
                        <!-- /.card-footer -->
                     </div>
                        <?php ActiveForm::end(); ?> 
              </div>
              <!-- /.card-body -->
            </div>
            <!-- /.card -->
            <!-- /.nav-tabs-custom -->
          </div>
          <!-- /.col -->
        </div>
        <!-- /.row -->
      </div><!-- /.container-fluid -->
    </section>
    <!-- /.content -->
  