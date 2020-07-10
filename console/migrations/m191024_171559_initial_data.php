<?php

use yii\db\Migration;

/**
 * Class m191024_171559_initial_data
 */
class m191024_171559_initial_data extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        
        $this->insertAuthItem();
        $this->insertAuthItemChild();
        $this->insertMenu();
        $user_id = \backend\components\UUID::v4();
        $this->insert('{{%user}}',[
                'id'=>$user_id, 'username'=>'admin', 'auth_key'=>'aVeQxCxiyI9lCTbg_J9i13LV1tGc6X8R', 
                'password_hash'=>'$2y$13$5qgMnZRqOXR5klpeX0zh2OJJ6/tnzmgQswPmFjp9g/bPpEABK/Cza', 
                'password_reset_token'=>NULL, 'email'=>'admin@gmail.com', 'status'=>10, 'created_at'=>1551142509, 'updated_at'=>1551142509,'nome' => 'Administrador de Sistema'
        ]);

        $this->insert('{{%auth_assignment}}',[
                'item_name'=>'Admin', 'user_id'=>$user_id,'created_at'=>1551142509
        ]);
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        echo "m191024_171559_initial_data cannot be reverted.\n";

        return false;
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m191024_171559_initial_data cannot be reverted.\n";

        return false;
    }
    */

    private function insertAuthItem(){
        $this->insert('{{%auth_item}}',[
                'name'=>'Admin', 'type'=>1, 'description'=>'Administrador','created_at'=>1551142509
        ]);
        $this->insert('{{%auth_item}}',[
                'name'=>'menu/create', 'type'=>2, 'description'=>'Create Menu','created_at'=>1551142509
        ]);
        $this->insert('{{%auth_item}}',[
                'name'=>'menu/delete', 'type'=>2, 'description'=>'Detelete Menu','created_at'=>1551142509
        ]); 
        $this->insert('{{%auth_item}}',[
                'name'=>'menu/index', 'type'=>2, 'description'=>'List of Menu','created_at'=>1551142509
        ]);
        $this->insert('{{%auth_item}}',[
                'name'=>'menu/update', 'type'=>2, 'description'=>'Update Menu','created_at'=>1551142509
        ]);
        $this->insert('{{%auth_item}}',[
                'name'=>'menu/view', 'type'=>2, 'description'=>'View Menu','created_at'=>1551142509
        ]);

        $this->insert('{{%auth_item}}',[
                'name'=>'permission/create', 'type'=>2, 'description'=>'Create Permission','created_at'=>1551142509
        ]);
        $this->insert('{{%auth_item}}',[
                'name'=>'permission/delete', 'type'=>2, 'description'=>'Detelete Permission','created_at'=>1551142509
        ]); 
        $this->insert('{{%auth_item}}',[
                'name'=>'permission/index', 'type'=>2, 'description'=>'List of Permission','created_at'=>1551142509
        ]);
        $this->insert('{{%auth_item}}',[
                'name'=>'permission/update', 'type'=>2, 'description'=>'Update Permission','created_at'=>1551142509
        ]);
        $this->insert('{{%auth_item}}',[
                'name'=>'permission/view', 'type'=>2, 'description'=>'View Permission','created_at'=>1551142509
        ]);

        $this->insert('{{%auth_item}}',[
                'name'=>'profile/create', 'type'=>2, 'description'=>'Create Profile','created_at'=>1551142509
        ]);
        $this->insert('{{%auth_item}}',[
                'name'=>'profile/delete', 'type'=>2, 'description'=>'Detelete Profile','created_at'=>1551142509
        ]); 
        $this->insert('{{%auth_item}}',[
                'name'=>'profile/index', 'type'=>2, 'description'=>'List of Profile','created_at'=>1551142509
        ]);
        $this->insert('{{%auth_item}}',[
                'name'=>'profile/update', 'type'=>2, 'description'=>'Update Profile','created_at'=>1551142509
        ]);
        $this->insert('{{%auth_item}}',[
                'name'=>'profile/view', 'type'=>2, 'description'=>'View Profile','created_at'=>1551142509
        ]);
        $this->insert('{{%auth_item}}',[
                'name'=>'user/create', 'type'=>2, 'description'=>'Create User','created_at'=>1551142509
        ]);
        $this->insert('{{%auth_item}}',[
                'name'=>'user/delete', 'type'=>2, 'description'=>'Detelete User','created_at'=>1551142509
        ]); 
        $this->insert('{{%auth_item}}',[
                'name'=>'user/index', 'type'=>2, 'description'=>'List of User','created_at'=>1551142509
        ]);
        $this->insert('{{%auth_item}}',[
                'name'=>'user/update', 'type'=>2, 'description'=>'Update User','created_at'=>1551142509
        ]);
        $this->insert('{{%auth_item}}',[
                'name'=>'user/view', 'type'=>2, 'description'=>'View User','created_at'=>1551142509
        ]);
    }

    private function insertAuthItemChild(){
        $this->insert('{{%auth_item_child}}',[
                'parent'=>'Admin', 'child'=>'menu/create'
        ]);
        $this->insert('{{%auth_item_child}}',[
                'parent'=>'Admin', 'child'=>'menu/delete'
        ]);
        $this->insert('{{%auth_item_child}}',[
                'parent'=>'Admin', 'child'=>'menu/index'
        ]);
        $this->insert('{{%auth_item_child}}',[
                'parent'=>'Admin', 'child'=>'menu/update'
        ]);
        $this->insert('{{%auth_item_child}}',[
                'parent'=>'Admin', 'child'=>'menu/view'
        ]);

        $this->insert('{{%auth_item_child}}',[
                'parent'=>'Admin', 'child'=>'permission/create'
        ]);
        $this->insert('{{%auth_item_child}}',[
                'parent'=>'Admin', 'child'=>'permission/delete'
        ]);
        $this->insert('{{%auth_item_child}}',[
                'parent'=>'Admin', 'child'=>'permission/index'
        ]);
        $this->insert('{{%auth_item_child}}',[
                'parent'=>'Admin', 'child'=>'permission/update'
        ]);
        $this->insert('{{%auth_item_child}}',[
                'parent'=>'Admin', 'child'=>'permission/view'
        ]);

        $this->insert('{{%auth_item_child}}',[
                'parent'=>'Admin', 'child'=>'profile/create'
        ]);
        $this->insert('{{%auth_item_child}}',[
                'parent'=>'Admin', 'child'=>'profile/delete'
        ]);
        $this->insert('{{%auth_item_child}}',[
                'parent'=>'Admin', 'child'=>'profile/index'
        ]);
        $this->insert('{{%auth_item_child}}',[
                'parent'=>'Admin', 'child'=>'profile/update'
        ]);
        $this->insert('{{%auth_item_child}}',[
                'parent'=>'Admin', 'child'=>'profile/view'
        ]);

        $this->insert('{{%auth_item_child}}',[
                'parent'=>'Admin', 'child'=>'user/create'
        ]);
        $this->insert('{{%auth_item_child}}',[
                'parent'=>'Admin', 'child'=>'user/delete'
        ]);
        $this->insert('{{%auth_item_child}}',[
                'parent'=>'Admin', 'child'=>'user/index'
        ]);
        $this->insert('{{%auth_item_child}}',[
                'parent'=>'Admin', 'child'=>'user/update'
        ]);
        $this->insert('{{%auth_item_child}}',[
                'parent'=>'Admin', 'child'=>'user/view'
        ]);
    }

    private function insertMenu(){

        $m1 = \backend\components\UUID::v4();
        $this->insert('{{%menu}}',[
                'id'=>$m1, 'name'=>'Gestão de Acesso','parent'=>NULL,'route'=>NULL,'order'=>0
        ]);
        $this->insert('{{%menu}}',[
                'id'=>\backend\components\UUID::v4(), 'name'=>'Gestão de Perfil','parent'=>$m1,'route'=>'profile/index','order'=>1
        ]);
        $this->insert('{{%menu}}',[
                'id'=>\backend\components\UUID::v4(), 'name'=>'Gestão de Permissão','parent'=>$m1,'route'=>'permission/index','order'=>2
        ]);
        $this->insert('{{%menu}}',[
                'id'=>\backend\components\UUID::v4(), 'name'=>'Gestão de Menu','parent'=>$m1,'route'=>'menu/index','order'=>3
        ]);
        $this->insert('{{%menu}}',[
                'id'=>\backend\components\UUID::v4(), 'name'=>'Gestão de Utilizadores','parent'=>$m1,'route'=>'user/index','order'=>4
        ]);
    }
}
