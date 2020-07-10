<?php

use yii\helpers\Html;
use yii\widgets\DetailView;
?>
<!-- Content Wrapper. Contains page content -->

<!-- Content Header (Page header) -->
<section class="content-header">
    <div class="container-fluid">
    <div class="row mb-2">
        <div class="col-sm-6">
        <h1>Detalhe do Perfil</h1>
        </div>
        <div class="col-sm-6">
        <ol class="breadcrumb float-sm-right">
            <li class="breadcrumb-item"><a href="#">Home</a></li>
            <li class="breadcrumb-item active">gestao-perfil</li>
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
            <h3 class="card-title">Informações do Perfil: <b><?= $model->name?></h3>
        </div>        
        <!-- /.card-header -->
        <div class="card-body">
                <?= DetailView::widget([
                    'model' => $model,
                    'attributes' => [
                        'name',
                        'description:ntext',
                        'created_at',
                        'updated_at',
                    ],
                ]) ?>  
        </div><!-- /.card-body -->
        <div class="card-footer">
            <?= Html::a('<i class="fa fa-plus"></i>'.' Novo Registo', ['create'], ['class' => 'btn btn-primary left']) ?>

            <?= Html::a('<i class="fa fa-edit"></i>'.' Editar', ['update', 'id' => $model->name], ['class' => 'btn btn-warning left']) ?>

            <?= Html::a('<i class="fa fa-trash"></i>'.' Eliminar', ['delete', 'id' => $model->name], [
                'class' => 'btn btn-danger left',
                'data' => [
                    'confirm' => 'Deseja realmente eliminar este item?',
                    'method' => 'post',
                ],
            ]) ?>
            <?= Html::a('<i class="fa fa-list"></i>'.' Ir para lista de perfil', ['index'], ['class' => 'btn btn-default']) ?>
        </div> 
        </div>
        <!-- /.card -->
    </div>
    <!-- /.col -->
    </div>
    <!-- /.row -->
</section>
<!-- /.content -->

<section class="content-header">
    <div class="container-fluid">
    <div class="row mb-2">
        <div class="col-sm-6">
        <h1>Informações sobre as permissões</h1>
        </div>          
    </div>
    </div><!-- /.container-fluid -->
</section>

<section class="content">
      <div class="container-fluid">
        <?php 
            \yii\widgets\Pjax::begin(['timeout'=>5000,]);
        ?> 
        <div class="row"> 
            <div class="col-md-6">
                <div class="card">
                    <div class="card-header">
                        <h3 class="card-title">Adicionar Novas Permissões</h3>
                    </div>
                    <!-- /.card-header -->
                    <div class="card-body">    
                    <?php if($dataProvider2->getCount()){?>
                    <?php   
                        echo Html::beginForm('','POST',['data-pjax'=>0,]);
                        echo Html::hiddenInput('flag', '2');
                         echo yii\grid\GridView::widget([
                                'dataProvider' => $dataProvider2,
                                'filterModel' => $searchModel,
                                'summaryOptions'=>['class'=>'col-lg-12','style'=>'padding-bottom:20px;'],
                                'columns' => [
                                    [
                                    'class' => \yii\grid\CheckboxColumn::className(),
                                    'headerOptions'=>['width'=>20,],
                                    ],
                                    [
                                        'attribute'=>'name',
                                        'headerOptions'=>['width'=>100,],
                                    ],
                                    [
                                        'attribute'=>'description',
                                        'headerOptions'=>['width'=>100,],
                                    ]
                                ],
                            ]); 
                        echo '<p>'.Html::submitButton('Adicionar', ['class'=>'btn btn-success']).'</p>';
                        echo Html::endForm();
                        ?>
                   <?php }else{
                        echo '<div class="col-lg-6">Nenhum resultado encontrado.</div>';
                   }?>
                </div>
            </div>
            </div>
                
            <div class="col-md-6">
            <div class="card">
              <div class="card-header">
                <h3 class="card-title">Revogar Permissões</h3>               
              </div>
              <!-- /.card-header -->
              <div class="card-body">
                    <?php if($dataProvider1->getCount()){?>
                    <?php
                     echo Html::beginForm('','POST',['data-pjax'=>0,]);
                     echo Html::hiddenInput('flag', '1');
                     echo yii\grid\GridView::widget([
                            'dataProvider' => $dataProvider1,
                            'filterModel' => $searchModel,
                            'summaryOptions'=>['class'=>'col-lg-12','style'=>'padding-bottom:20px;'],
                            'columns' => [
                                [
                                'class' => \yii\grid\CheckboxColumn::className(),
                                'headerOptions'=>['width'=>20,],
                                ],
                                [
                                    'attribute'=>'name',
                                    'headerOptions'=>['width'=>100,],
                                ],
                                [
                                    'attribute'=>'description',
                                    'headerOptions'=>['width'=>100,],
                                ]
                            ],
                        ]); 
                        
                    echo '<p>'.Html::submitButton('Remover', ['class'=>'btn btn-danger']).'</p>';
                    echo Html::endForm();
                    ?>
                   <?php }else{
                        echo '<div class="col-lg-6">Nenhum resultado encontrado.</div>';
                   }?>  
                   </div>
                </div>
                </div> 
                </div>  <!-- /.row end -->                 
        <?php \yii\widgets\Pjax::end();?> 
    </div>
</section>