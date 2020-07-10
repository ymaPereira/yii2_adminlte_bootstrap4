<?php
/* @var $this \yii\web\View */
/* @var $content string */

use backend\assets\AppAsset;
use yii\helpers\Html;
$asset = backend\assets\AppAsset::register($this);
$baseUrl = $asset->baseUrl;
use kartik\icons\FontAwesomeAsset;

?>
<?php $this->beginPage() ?>
<!DOCTYPE html>
<html lang="<?= Yii::$app->language ?>">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <meta http-equiv="x-ua-compatible" content="ie=edge"> 
  <?php FontAwesomeAsset::register($this); ?>  
  <?php $this->registerCsrfMetaTags() ?>    
  <title><?= Html::encode($this->title) ?></title>
  <?php $this->head() ?>
  <style type="text/css">    
    .required{
      color: red;
    }
  </style>
</head>
<body class="hold-transition sidebar-mini">
<?php $this->beginBody() ?>
<div class="wrapper">
  <?php if(!Yii::$app->user->isGuest) { ?>

      <?= $this->render('topmenu.php',['baseUrl'=>$baseUrl]); ?>  
      <!-- sidebar menu -->
      <?= $this->render('leftmenu.php',['baseUrl'=>$baseUrl]); ?>
      <!-- /sidebar menu -->

      <!-- Content Wrapper. Contains page content -->
      <div class="content-wrapper">
      <!-- Content Header (Page header) -->
  <?php } ?>

    <?= $content ?>

  <?php if(!Yii::$app->user->isGuest){?>
      <!-- /.content -->
      </div>
      <!-- /.content-wrapper -->
      <?= $this->render('rigthmenu.php', ['baseUrl'=>$baseUrl]); ?>
      <!-- Main Footer -->
      <?= $this->render('footer.php', ['baseUrl'=>$baseUrl]); ?>
  <?php }?>

</div>

<?php $this->endBody() ?>
</body>
</html>
<?php $this->endPage() ?>
