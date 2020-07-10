<?php

use yii\helpers\Html;
use yii\widgets\DetailView;
?>

<!-- Content Header (Page header) -->
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
    <div class="row">
    <div class="col-12">  
        <div class="card card-primary card-outline">
        <div class="card-header">
            <h3 class="card-title">Informações de Utilizador: <b><?= $model->username?></h3>
        </div>        
        <!-- /.card-header -->
            <div class="card-body">
                <?= DetailView::widget([
                    'model' => $model,
                    'attributes' => [  
                        #'id',
                        'nome',                      
                        'username',                      
                        'email:email',
                        'telefone1',
                        'telefone2',
                         [
                            'label' => 'Status',
                            'format'=> 'raw',
                            'value' => function ($model) {
                                        return $model->status == 10?'Ativo':'Inativo';
                                    },
                        ],                      
                        [
                            'label' => 'Perfil',
                            'format'=> 'raw',
                            'value' =>  function ($model) {
                                        return $model->getProfiles();
                                    },
                        ]
                    ],
                ]) ?>
            </div>
            <div class="card-footer">          
                <?= Html::a('<i class="fa fa-plus"></i>'.' Novo Utilizador', ['create'], ['class' => 'btn btn-primary left']) ?>

                <?= Html::a('<i class="fa fa-edit"></i>'.' Editar', ['update', 'id' => $model->id], ['class' => 'btn btn-warning left']) ?>

                <?= Html::a('<i class="fa fa-trash"></i>'.' Eliminar', ['delete', 'id' => $model->id], [
                    'class' => 'btn btn-danger left',
                    'data' => [
                        'confirm' => 'Deseja realmente eliminar este item?',
                        'method' => 'post',
                    ],
                ]) ?>

                <?= Html::a('<i class="fa fa-list"></i>'.' Ir para lista de utilizadores', ['index'], ['class' => 'btn btn-default']) ?>
                </div> 
            </div>
        <!-- /.card -->
    </div>
    <!-- /.col -->
    </div>
    <!-- /.row -->
</section>
<!-- /.content -->