<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use \kartik\select2\Select2;
?>

<section class="content-header">
    <div class="container-fluid">
    <div class="row mb-2">
        <div class="col-sm-6">
        <h1>Gestão de Utilizador</h1>
        </div>
        <div class="col-sm-6">
        <ol class="breadcrumb float-sm-right">
            <li class="breadcrumb-item"><a href="#">Home</a></li>
            <li class="breadcrumb-item active">gestao-utilizador</li>
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
            <h3 class="card-title"><?= ($model->isNewRecord ? 'Registar' : 'Atualizar')?> Utilizador</h3>
        </div>
        <!-- /.card-header -->
        <?php $form = ActiveForm::begin([
            'options' => [
                'class' => 'form-horizontal'
                ]
        ]); ?>    
        <div class="card-body">
            <div class="form-group row">
                <label for="nome" class="col-sm-2 col-form-label">Nome <span class="required">*</span></label>
                    <div class="col-sm-8">
                        <?= $form->field($model, 'nome')->textInput(['maxlength' => true,'class'=>'form-control'])->label(false) ?>
                    </div>
            </div>
            
            <div class="form-group row">
                <label for="email" class="col-sm-2 col-form-label">Email <span class="required">*</span></label>
                    <div class="col-sm-4">
                        <?= $form->field($model, 'email')->textInput(['maxlength' => true,'class'=>'form-control','type'=>'email'])->label(false) ?>
                    </div>
            </div>
            <div class="form-group row">
                <label for="telefone1" class="col-sm-2 col-form-label">Telefone 1 </label>
                    <div class="col-sm-4">
                        <?= $form->field($model, 'telefone1')->textInput(['maxlength' => true,'class'=>'form-control','type'=>'number'])->label(false) ?>
                    </div>
            </div>
            <div class="form-group row">
                <label for="telefone2" class="col-sm-2 col-form-label">Telefone 2 </label>
                    <div class="col-sm-4">
                        <?= $form->field($model, 'telefone2')->textInput(['maxlength' => true,'class'=>'form-control','type'=>'number'])->label(false) ?>
                    </div>
            </div> 
        </div>        
        <!-- /.card-body -->
        <div class="card-footer">
            <?= Html::submitButton('<i class="fa fa-save"></i> Atualizar', ['class' => 'btn btn-info']) ?>        
        </div>
        <!-- /.card-footer -->
        <?php ActiveForm::end(); ?>  
                
        </div>
    <!-- /.card -->
    </div>
</section>
<!-- /.content -->

