<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model common\models\User */

$this->title = 'Utilizadores';
$this->params['breadcrumbs'][] = ['label' => 'Utilizador', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="box box-primary">
    <div class="box-header with-border"><h3 class="box-title">Informações de utilizador: <b><?= $model->id?></b></h3></div>
    <div class="box-body">
        <div class="user-view">

<?= DetailView::widget([
    'model' => $model,
    'attributes' => [
            'id',
            'nome',
            'email:email',
            'username',
    ],
]) ?>
                <p>
                    <?= Html::a('<i class="fa fa-plus"></i>'.' Novo Registo', ['create'], ['class' => 'btn btn-default left']) ?>

                    <?= Html::a('<i class="fa fa-pencil"></i>'.' Editar', ['update', 'id' => $model->id], ['class' => 'btn btn-default left']) ?>

                    <?= Html::a('<i class="fa fa-trash"></i>'.' Eliminar', ['delete', 'id' => $model->id], [
                        'class' => 'btn btn-default left',
                        'data' => [
                            'confirm' => 'Deseja realmente eliminar este item?',
                            'method' => 'post',
                        ],
                    ]) ?>
                </p>
            </div>
        </div>
</div>	  

<div class="box box-primary">
    <div class="box-header with-border">
      <h3 class="box-title">Perfil de acesso</h3>
    </div>
    <div class="box-body">
	
		<?php \yii\widgets\Pjax::begin([
			'timeout'=>5000,
		]);?>
		
		<!-- Lista de Perfil a adicionar -->
		<div class="col-lg-6">
			<div class="alert alert-info">Perfil de Utilizador</div>
			<?php if($dataProvider2->getCount()){?>
			<?php
				echo Html::beginForm('','POST',['data-pjax'=>1,]);
				echo Html::hiddenInput('flag', '2');
				 echo yii\grid\GridView::widget([
						'dataProvider' => $dataProvider2,
						'filterModel' => $searchModel2,
						'summaryOptions'=>['class'=>'col-lg-12','style'=>'padding-bottom:20px;'],
						'columns' => [
							[
							'class' => 'yii\grid\CheckboxColumn',
							'headerOptions'=>['width'=>20,],
							],
							[
								'attribute'=>'name',
								'headerOptions'=>['width'=>180,],
							],
							'description:ntext',
						],
					]); 
				echo '<p>'.Html::submitButton('Adicionar', ['class'=>'btn btn-default']).'</p>';
				echo Html::endForm();
				?>
		   <?php }else{
				echo '<div class="col-lg-6">Nenhum resultado encontrado.</div>';
		   }?>
		</div>

		<!-- Lista de perfil que ja foram adicionados -->
	    <div class="col-lg-6">
			<div class="alert alert-info">Remover perfil</div>
			<?php if($dataProvider1->getCount()){?>
			<?php
			 echo Html::beginForm('','POST',['data-pjax'=>1,]);
			 echo Html::hiddenInput('flag', '1');
			 echo yii\grid\GridView::widget([
					'dataProvider' => $dataProvider1,
					'filterModel' => $searchModel1,
					'summaryOptions'=>['class'=>'col-lg-12','style'=>'padding-bottom:20px;'],
					'columns' => [
						[
						'class' => 'yii\grid\CheckboxColumn',
						'headerOptions'=>['width'=>20,],
						],
						[
							'attribute'=>'name',
							'headerOptions'=>['width'=>180,],
						],
						'description:ntext',
					],
				]); 
				
			echo '<p>'.Html::submitButton('Remover', ['class'=>'btn btn-default']).'</p>';
			echo Html::endForm();
			?>
		   <?php }else{
				echo '<div class="col-lg-6">Nenhum resultado encontrado.</div>';
		   }?>

		</div>
   
	</div><!-- /.box-body -->

<?php \yii\widgets\Pjax::end();?>
</div>