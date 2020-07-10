<?php
  //use backend\assets\AppAsset;
  use yii\helpers\Html;
  use yii\bootstrap\ActiveForm;
?>
<div class="login-box">
  <div class="login-logo">
    <a href="#"><b>Gestão de Trafego</b></a>
  </div>
  <!-- /.login-logo -->
  <div class="card">
    <div class="card-body login-card-body">
      <p class="login-box-msg">Faça o seu login</p>  
      <?php $form = ActiveForm::begin(['id' => 'login-form', 'enableClientScript' => false]); ?>
          <?php 
            echo $form->field($model, 'username', [
              'inputTemplate' => '<div class="input-group mb-3">{input}<div class="input-group-append"><div class="input-group-text"><span class="fas fa-envelope"></span></div></div></div>',
              'inputOptions' => [
                'placeholder' => 'Username',
              ],
          ])->label(false);
          ?>
           <?php 
            echo $form->field($model, 'password', [
              'inputTemplate' => '<div class="input-group mb-3">{input}<div class="input-group-append"><div class="input-group-text"><span class="fas fa-lock"></span></div></div></div>',
              'inputOptions' => [
                'placeholder' => 'Password',
                'type' => 'password',
                'class' => 'form-control'
              ],
          ])->label(false);
          ?>        
        <div class="row">
          <div class="col-8">
            <div class="icheck-primary">
              <input type="checkbox" id="remember">
              <label for="remember">
                Remember Me
              </label>
            </div>
          </div>
          <!-- /.col -->
          <div class="col-4">
            <?= Html::submitButton('Login', ['class' => 'btn btn-primary btn-block btn-flat']) ?>            
          </div>
          <!-- /.col -->
        </div>
        <?php ActiveForm::end(); ?>
<!--
      <div class="social-auth-links text-center mb-3">
        <p>- OR -</p>
        <a href="#" class="btn btn-block btn-primary">
          <i class="fab fa-facebook mr-2"></i> Sign in using Facebook
        </a>
        <a href="#" class="btn btn-block btn-danger">
          <i class="fab fa-google-plus mr-2"></i> Sign in using Google+
        </a>
      </div>
-->
      <!-- /.social-auth-links -->

      <p class="mb-1">
        <a href="#">I forgot my password</a>
      </p>
      <!--
      <p class="mb-0">
        <a href="register.html" class="text-center">Register a new membership</a>
      </p>
-->
    </div>
    <!-- /.login-card-body -->
  </div>
</div>
