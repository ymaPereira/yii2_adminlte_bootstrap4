<?php

use yii\db\Migration;

class m130524_201442_init extends Migration
{
    public function up()
    {
        $tableOptions = null;
        if ($this->db->driverName === 'mysql') {
            // http://stackoverflow.com/questions/766809/whats-the-difference-between-utf8-general-ci-and-utf8-unicode-ci
            $tableOptions = 'CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE=InnoDB';
        }

        $this->createTable('{{%user}}', [
            'id' => $this->string(36)->notNull(),
            'username' => $this->string(100)->notNull()->unique(),
            'auth_key' => $this->string(32)->notNull(),
            'password_hash' => $this->string()->notNull(),
            'password_reset_token' => $this->string()->unique(),
            'email' => $this->string()->notNull()->unique(),
            'status' => $this->smallInteger()->notNull()->defaultValue(10),
            'created_at' => $this->integer()->notNull()->defaultValue(date('Y')),
            'updated_at' => $this->integer(),
            'nome' => $this->string(250)->notNull(),
            'telefone1' => $this->integer(),
            'telefone2' => $this->integer()
        ], $tableOptions);
        $this->addPrimaryKey('user_pk', '{{%user}}', ['id']);


        $this->createTable('{{%auth_rule}}', [
            'name' => $this->string(64)->notNull(),
            'data' => $this->binary(),
            'created_at' => $this->integer(),
            'updated_at' => $this->integer(),
            'PRIMARY KEY ([[name]])',
        ], $tableOptions);

        $this->createTable('{{%auth_item}}', [
            'name' => $this->string(64)->notNull(),
            'type' => $this->smallInteger()->notNull(),
            'description' => $this->text(),
            'rule_name' => $this->string(64),
            'data' => $this->binary(),
            'created_at' => $this->integer(),
            'updated_at' => $this->integer(),
            'PRIMARY KEY ([[name]])',
            'FOREIGN KEY ([[rule_name]]) REFERENCES ' . '{{%auth_rule}}' . ' ([[name]])' .
                $this->buildFkClause('ON DELETE SET NULL', 'ON UPDATE CASCADE'),
        ], $tableOptions);
        $this->createIndex('idx-auth_item-type', '{{%auth_item}}', 'type');

        $this->createTable('{{%auth_item_child}}', [
            'parent' => $this->string(64)->notNull(),
            'child' => $this->string(64)->notNull(),
            'PRIMARY KEY ([[parent]], [[child]])',
            'FOREIGN KEY ([[parent]]) REFERENCES ' . '{{%auth_item}}' . ' ([[name]])' .
                $this->buildFkClause('ON DELETE CASCADE', 'ON UPDATE CASCADE'),
            'FOREIGN KEY ([[child]]) REFERENCES ' . '{{%auth_item}}' . ' ([[name]])' .
                $this->buildFkClause('ON DELETE CASCADE', 'ON UPDATE CASCADE'),
        ], $tableOptions);

        $this->createTable('{{%auth_assignment}}', [
            'item_name' => $this->string(64)->notNull(),
            'user_id' => $this->string(36)->notNull(),
            'created_at' => $this->integer(),
            'PRIMARY KEY ([[item_name]], [[user_id]])',
            'FOREIGN KEY ([[item_name]]) REFERENCES ' . '{{%auth_item}}' . ' ([[name]])' .
                $this->buildFkClause('ON DELETE CASCADE', 'ON UPDATE CASCADE'),
        ], $tableOptions);

        $this->createTable('{{%menu}}', [
            'id' => $this->string(36)->notNull(),
            'name' => $this->string()->notNull()->unique(),
            'parent' => $this->string(36),
            'route' => $this->string(64),
            'order' => $this->smallInteger(6)->notNull(),
            'status' => $this->smallInteger()->notNull()->defaultValue(10),
            'created_at' => $this->integer()->notNull()->defaultValue(date('Y')),
            'updated_at' => $this->integer(),
        ], $tableOptions);
        $this->addPrimaryKey('menu_pk', '{{%menu}}', ['id']);


        if ($this->isMSSQL()) {
            $this->execute("CREATE TRIGGER {$schema}.trigger_auth_item_child
            ON {$schema}.{'{{%auth_item}}'}
            INSTEAD OF DELETE, UPDATE
            AS
            DECLARE @old_name VARCHAR (64) = (SELECT name FROM deleted)
            DECLARE @new_name VARCHAR (64) = (SELECT name FROM inserted)
            BEGIN
            IF COLUMNS_UPDATED() > 0
                BEGIN
                    IF @old_name <> @new_name
                    BEGIN
                        ALTER TABLE {'{{%auth_item_child}}'} NOCHECK CONSTRAINT FK__auth_item__child;
                        UPDATE {'{{%auth_item_child}}'} SET child = @new_name WHERE child = @old_name;
                    END
                UPDATE {'{{%auth_item}}'}
                SET name = (SELECT name FROM inserted),
                type = (SELECT type FROM inserted),
                description = (SELECT description FROM inserted),
                rule_name = (SELECT rule_name FROM inserted),
                data = (SELECT data FROM inserted),
                created_at = (SELECT created_at FROM inserted),
                updated_at = (SELECT updated_at FROM inserted)
                WHERE name IN (SELECT name FROM deleted)
                IF @old_name <> @new_name
                    BEGIN
                        ALTER TABLE {'{{%auth_item_child}}'} CHECK CONSTRAINT FK__auth_item__child;
                    END
                END
                ELSE
                    BEGIN
                        DELETE FROM {$schema}.{'{{%auth_item_child}}'} WHERE parent IN (SELECT name FROM deleted) OR child IN (SELECT name FROM deleted);
                        DELETE FROM {$schema}.{'{{%auth_item}}'} WHERE name IN (SELECT name FROM deleted);
                    END
            END;");
        }

        $this->createIndex('auth_assignment_user_id_idx', '{{%auth_assignment}}', 'user_id');
        $this->dropIndex('auth_assignment_user_id_idx', '{{%auth_assignment}}');
        $this->createIndex('{{%idx-auth_assignment-user_id}}', '{{%auth_assignment}}', 'user_id');

        $this->dropIndex('idx-auth_item-type', '{{%auth_item}}');
        $this->createIndex('{{%idx-auth_item-type}}', '{{%auth_item}}', 'type');
    }

    public function down()
    {
        if ($this->isMSSQL()) {
            $this->execute('DROP TRIGGER {$schema}.trigger_auth_item_child;');
        }
        $this->dropIndex('auth_assignment_user_id_idx','{{%auth_assignment}}');
        $this->dropIndex('{{%idx-auth_assignment-user_id}}', '{{%auth_assignment}}');
        $this->createIndex('auth_assignment_user_id_idx', '{{%auth_assignment}}', 'user_id');
        $this->dropIndex('{{%idx-auth_item-type}}', '{{%auth_item}}');
        $this->createIndex('idx-auth_item-type', '{{%auth_item}}', 'type');

        $this->dropTable('{{%user}}');
        $this->dropTable('{{%auth_rule}}');
        $this->dropTable('{{%auth_item}}');
        $this->dropTable('{{%auth_assignment}}');
        $this->dropTable('{{%auth_item_child}}');
        $this->dropTable('{{%menu}}');
    }

    private function isMSSQL()
    {
        return $this->db->driverName === 'mssql' || $this->db->driverName === 'sqlsrv' || $this->db->driverName === 'dblib';
    }

    private function isOracle()
    {
        return $this->db->driverName === 'oci';
    }

    protected function buildFkClause($delete = '', $update = '')
    {
        if ($this->isMSSQL()) {
            return '';
        }

        if ($this->isOracle()) {
            return ' ' . $delete;
        }

        return implode(' ', ['', $delete, $update]);
    }
}
