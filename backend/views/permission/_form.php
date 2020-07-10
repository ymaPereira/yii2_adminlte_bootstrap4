<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model backend\models\AuthItem */
/* @var $form yii\widgets\ActiveForm */
?>
<section class="content-header">
    <div class="container-fluid">
    <div class="row mb-2">
        <div class="col-sm-6">
        <h1>Gestão de Permissão</h1>
        </div>
        <div class="col-sm-6">
        <ol class="breadcrumb float-sm-right">
            <li class="breadcrumb-item"><a href="#">Home</a></li>
            <li class="breadcrumb-item active">gestao-permissao</li>
        </ol>
        </div>
    </div>
    </div><!-- /.container-fluid -->
</section>

<!-- Main content -->
<section class="content">
    <div class="container-fluid">
    <!-- Horizontal Form -->
    <div class="card card-primary card-outline">
        <div class="card-header">
        <h3 class="card-title">Adicionar Nova Permissão</h3>
        </div>
        <!-- /.card-header -->
        <!-- form start -->
        <?php $form = ActiveForm::begin([
            'options' => [
                'class' => 'form-horizontal'
                ]
        ]); ?>    
        <div class="card-body">
            <div class="form-group row">
            <label for="inputEmail3" class="col-sm-2 col-form-label">Código</label>
            <div class="col-sm-10">
                <?= $form->field($model, 'name')->textInput(['maxlength' => true,'class'=>'form-control', 'placeholder'=>"codigo do perfil (Ex: menu/create, menu/view...)"])->label(false) ?>
            </div>
            </div>
            <div class="form-group row">
            <label for="inputPassword3" class="col-sm-2 col-form-label">Descrição do Permissão</label>
            <div class="col-sm-10">
                <?= $form->field($model, 'description')->textInput(['class'=>'form-control', 'placeholder'=>'descrição da permissão'])->label(false) ?>
            </div>
            </div>        
        </div>
        <!-- /.card-body -->
        <div class="card-footer">
            <?= Html::submitButton('<i class="fa fa-save"></i> '.($model->isNewRecord ? 'Registar' : 'Atualizar'), ['class' => 'btn btn-info']) ?>              
            <?= Html::a('<i class="fa fa-list"></i>'.' Ir para lista de permissões', ['index'], ['class' => 'btn btn-default float-right']) ?>        
        </div>
        <!-- /.card-footer -->
        <?php ActiveForm::end(); ?> 
    </div>
    <!-- /.card -->
    </div>
</section>
<!-- /.content -->
