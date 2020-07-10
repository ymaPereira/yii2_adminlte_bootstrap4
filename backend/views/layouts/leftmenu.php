<?php 
use backend\models\Menu;
use backend\models\AuthItem;
use backend\models\AuthAssignment;
use backend\models\AuthItemChild;
    $query = new \yii\db\Query;
    $query = $query->select('m1.*,m2.name as Menu_Pai')
            ->from(Menu::tableName().' AS m1,'
            .Menu::tableName().' AS m2,'
            .AuthItem::tableName().' AS a,'
            .AuthAssignment::tableName().' AS p,'
            .AuthItemChild::tableName().' AS c')
            ->where('m1.parent=m2.id and m1.route = a.name')
            ->andWhere('p.item_name=:role',[':role'=>Yii::$app->session->get('role')])
            ->andWhere('p.user_id=:id',[':id'=>\Yii::$app->user->identity->id])
            ->andWhere('c.child = m1.route')
            ->andWhere('c.parent = p.item_name')
            ->all();
    $menus = null;
    if(!empty($query)){
        foreach ($query as $key => $menu) {
            $menus[$menu['Menu_Pai']][] = $menu;
        }
    }
?>
<!-- Main Sidebar Container -->
<aside class="main-sidebar elevation-4 sidebar-light-danger">
  <!-- Brand Logo -->
  <a href="index.php" class="brand-link">
    <img src="<?= $baseUrl ?>/dist/img/AdminLTELogo.png" alt="AdminLTE Logo" class="brand-image img-circle elevation-3"
         style="opacity: .8; border-radius: 8%">
    <span class="brand-text font-weight-light">Gestão Trafego</span>
  </a>

  <!-- Sidebar -->
  <div class="sidebar">
    <!-- Sidebar user panel (optional) -->
    <div class="user-panel mt-3 pb-3 mb-3 d-flex">
      <div class="image">
        <img src="<?= $baseUrl ?>/dist/img/avatar.png" class="img-circle elevation-2" alt="User Image">
      </div>
      <div class="info">
        <a href="index.php?r=user/profile" class="d-block"><?= \backend\models\AuthItem::getDescriptionRole(Yii::$app->session->get('role'))?><br/>&nbsp;&nbsp;&nbsp;<?= Yii::$app->user->identity->username ?></a>
      </div>
    </div>

    <!-- Sidebar Menu -->
    <nav class="mt-2">
      <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false">
       
        <?php 
            if(!empty($menus) && $menus !=null){              
                foreach ($menus as $key => $menu){                                
        ?>
        <li class="nav-item has-treeview">
            <a href="#" class="nav-link">
              <i class="nav-icon fas fa-edit"></i>
              <p>
                <?= $key ?>
                <i class="fas fa-angle-left right"></i>
              </p>
            </a>            
              <ul class="nav nav-treeview">                
                <?php foreach ($menu as $key => $main) : ?>

                  <li class="nav-item">
                    <a href="<?= \yii\helpers\Url::to('index.php?r='.$main['route'])?>" class="nav-link">                     
                       <i class="fas fa-circle nav-icon"></i>                     
                      <p><?= $main['name']?></p>
                    </a>
                  </li>
                <?php endforeach; ?>                
              </ul>            
          </li>
          <?php 
              }
              }
            ?>
      </ul>
    </nav>
    <!-- /.sidebar-menu -->
  </div>
  <!-- /.sidebar -->
</aside>