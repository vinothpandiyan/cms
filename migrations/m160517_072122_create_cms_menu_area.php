<?php

use yii\db\Migration;

/**
 * Handles the creation for table `cms_menu_area`.
 * Has foreign keys to the tables:
 *
 * - `user`
 */
class m160517_072122_create_cms_menu_area extends Migration
{
    /**
     * @inheritdoc
     */
    public function up()
    {
        $this->createTable('cms_menu_area', [
            'area_id' => $this->primaryKey(),
            'name' => $this->string(32)->notNull(),
            'status' => $this->boolean()->notNull()->defaultValue(1),
            'area_code' => $this->string(32)->notNull()->unique(),
            'created_by' => $this->integer()->notNull(),
            'created_at' => $this->timestamp()->notNull(),
            'updated_at' => $this->timestamp()->notNull(),
        ]);

        // creates index for column `created_by`
        $this->createIndex(
            'idx-cms_menu_area-created_by',
            'cms_menu_area',
            'created_by'
        );

        // add foreign key for table `user`
        $this->addForeignKey(
            'fk-cms_menu_area-created_by',
            'cms_menu_area',
            'created_by',
            'user',
            'id',
            'CASCADE'
        );
    }

    /**
     * @inheritdoc
     */
    public function down()
    {
        // drops foreign key for table `user`
        $this->dropForeignKey(
            'fk-cms_menu_area-created_by',
            'cms_menu_area'
        );

        // drops index for column `created_by`
        $this->dropIndex(
            'idx-cms_menu_area-created_by',
            'cms_menu_area'
        );

        $this->dropTable('cms_menu_area');
    }
}
