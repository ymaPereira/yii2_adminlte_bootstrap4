<?php

use yii\helpers\Html;
use yii\grid\GridView;
use yii\widgets\Pjax;
use yii\helpers\Url;

?>
<!-- Content Header (Page header) -->
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
    <div class="row">
    <div class="col-12">  
        <div class="card card-primary card-outline">
        <div class="card-header">
           <?= Html::a('<i class="fa fa-plus"></i>'.' Novo Menu', ['create'], ['class' => 'btn btn-primary']) ?>
        </div>        
        <!-- /.card-header -->
        <div class="card-body">
                <?php Pjax::begin(); ?>                                   
                         <?= GridView::widget([
                        'dataProvider' => $dataProvider,
                        'filterModel' => $searchModel,
                        'columns' => [
                            //['class' => 'yii\grid\SerialColumn'],

                            //'id',
                            'name',
                            [
                                'attribute' => 'route',
                                'label' => 'Pagina',
                                'value' => function($model){
                                    return isset($model->route)?$model->route:'---';
                                }
                            ],
                            [
                                'attribute' => 'parent',
                                'label' => 'Parent',
                                'value' => function($model){
                                    return isset($model->parent0)?$model->parent0->name:'---';
                                }
                            ],'order',                            [
                                'class' => 'yii\grid\ActionColumn',
                                'options'=>['width'=>'100px'],
                                'buttons' => [
                                    'template' => '{view} {update}',
                                    'view' => function ($url, $model) {
                                        $url = Url::to(['menu/view', 'id' => $model->id]);
                                        return Html::a('<span class="fa fa-eye"></span>', $url, ['title' => 'view']);
                                    },
                                    'update' => function ($url, $model) {
                                        $url = Url::to(['menu/update', 'id' => $model->id]);
                                        return Html::a('<span class="fas fa-pencil-alt"></span>', $url, ['title' => 'update']);
                                    },
                                ],     
                            ],
                        ],
                    ]); ?>
                <?php Pjax::end(); ?>   
                </div>
        <!-- /.card-body -->
        </div>
        <!-- /.card -->
    </div>
    <!-- /.col -->
    </div>
    <!-- /.row -->
</section>
<!-- /.content -->
