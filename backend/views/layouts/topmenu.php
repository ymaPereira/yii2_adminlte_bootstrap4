<?php
use yii\helpers\Url;

?>
<!-- Navbar -->
<nav class="main-header navbar navbar-expand navbar-dark navbar-primary" style="background-color: #386097;">
  <!-- Left navbar links -->
  <ul class="navbar-nav">
    <li class="nav-item">
      <a class="nav-link" data-widget="pushmenu" href="#"><i class="fas fa-bars"></i></a>
    </li>
    <li class="nav-item d-none d-sm-inline-block">
      <a href="index.php" class="nav-link"><i class="fas fa-home"></i> Home</a>
    </li>
  </ul>
  <!-- Right navbar links -->
  <ul class="navbar-nav ml-auto">
    
    
    <!-- Settings -->
    <li class="nav-item d-none d-sm-inline-block">
      <a href="<?= \yii\helpers\Url::to('index.php?r=user/profile')?>" class="nav-link"><i class="fas fa-cogs"></i> settings</a>
    </li>

    <!-- Notifications Dropdown Menu -->
    <li class="nav-item dropdown">
      <a class="nav-link" data-toggle="dropdown" href="#">
        <i class="far fa-bell"></i>
        <span class="badge badge-warning navbar-badge"></span>
      </a>
      <div class="dropdown-menu dropdown-menu-lg dropdown-menu-right">
        <span class="dropdown-header"> </span>
       
      </div>
    </li>

    <!-- Logout -->
    <li class="nav-item d-none d-sm-inline-block">
      <a href="<?= \yii\helpers\Url::to('index.php?r=site/logout')?>" class="nav-link"><i class="fas fa-sign-out-alt"></i></a>
    </li>
 
  </ul>
</nav>
<!-- /.navbar -->