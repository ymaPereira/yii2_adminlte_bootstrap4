<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use kartik\select2\Select2;

/* @var $this yii\web\View */
/* @var $model app\modules\core\models\Menu */
/* @var $form yii\widgets\ActiveForm */
?>

<section class="content-header">
    <div class="container-fluid">
    <div class="row mb-2">
        <div class="col-sm-6">
        <h1>Gestão de Menu</h1>
        </div>
        <div class="col-sm-6">
        <ol class="breadcrumb float-sm-right">
            <li class="breadcrumb-item"><a href="#">Home</a></li>
            <li class="breadcrumb-item active">gestao-menu</li>
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
            <h3 class="card-title"><?= ($model->isNewRecord ? 'Registar' : 'Atualizar')?> Menu</h3>
        </div>
        <!-- /.card-header -->
        <?php $form = ActiveForm::begin([
            'options' => [
                'class' => 'form-horizontal'
                ]
        ]); ?>    
        <div class="card-body">
            <div class="form-group row">
            <label for="name" class="col-sm-2 col-form-label">Descrição Menu <span class="required">*</span></label>
            <div class="col-sm-10">
                <?= $form->field($model, 'name')->textInput(['maxlength' => true,'class'=>'form-control'])->label(false) ?>
            </div>
            </div>
            <div class="form-group row">
            <label for="parent" class="col-sm-2 col-form-label">Menu Pai<span class="required">*</span> </label>
                <div class="col-sm-10">
                    <?=    $form->field($model,'parent')->widget(Select2::classname(),[
                                    'data' => $parent,
                                    'class'=>'form-control col-md-7 col-xs-12',
                                    'maintainOrder' => true,
                                    'toggleAllSettings' => [
                                        'selectOptions' => ['class' => 'text-success'],
                                        'unselectOptions' => ['class' => 'text-danger'],
                                    ],
                                    'options' => ['placeholder' => 'Selecionar Menu Pai', 'multiple' => false],
                                    'pluginOptions' => [
                                        'tags' => true,
                                        'maximumInputLength' => 100
                                    ]
                                ])->label(false); 
                            ?> 
                </div>
            </div> 
            <div class="form-group row">
                <label for="order" class="col-sm-2 col-form-label">Ordem <span class="required">*</span></label>
                    <div class="col-sm-10">
                        <?= $form->field($model, 'order')->textInput(['maxlength' => true,'class'=>'form-control'])->label(false) ?>
                    </div>
            </div> 
            <div class="form-group row">
            <label for="route" class="col-sm-2 col-form-label">Pagina <span class="required">*</span></label>
                <div class="col-sm-10">
                    <?= $form->field($model,'route')->widget(Select2::classname(),[
                                'data' => $permission,
                                'class'=>'form-control col-md-7 col-xs-12',
                                'maintainOrder' => true,
                                'toggleAllSettings' => [
                                    'selectOptions' => ['class' => 'text-success'],
                                    'unselectOptions' => ['class' => 'text-danger'],
                                ],
                                'options' => ['placeholder' => 'Selecionar Página', 'multiple' => false],
                                'pluginOptions' => [
                                    'allowClear' => true,
                                    'tags' => true,
                                    'maximumInputLength' => 100
                                ]
                            ])->label(false); 
                    ?>
                </div>
            </div>       
        </div>
        <!-- /.card-body -->
        <div class="card-footer">
            <?= Html::submitButton('<i class="fa fa-save"></i> '.($model->isNewRecord ? 'Registar' : 'Atualizar'), ['class' => 'btn btn-info']) ?>              
            <?= Html::a('<i class="fa fa-list"></i>'.' Ir para lista de menu', ['index'], ['class' => 'btn btn-default float-right']) ?>        
        </div>
        <!-- /.card-footer -->
        <?php ActiveForm::end(); ?>  
                
        </div>
    <!-- /.card -->
    </div>
</section>
<!-- /.content -->








