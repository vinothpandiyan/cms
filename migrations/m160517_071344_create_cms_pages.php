<?php

use yii\db\Migration;

/**
 * Handles the creation for table `cms_pages`.
 * Has foreign keys to the tables:
 *
 * - `user`
 */
class m160517_071344_create_cms_pages extends Migration
{
    /**
     * @inheritdoc
     */
    public function up()
    {
        $this->createTable('cms_pages', [
            'page_id' => $this->primaryKey(),
            'title' => $this->string(255)->notNull(),
            'description' => $this->text(),
            'status' => $this->boolean()->notNull()->defaultValue(1),
            'menu_title' => $this->string(45),
            'created_by' => $this->integer()->notNull(),
            'created_at' => $this->timestamp()->notNull(),
            'updated_at' => $this->timestamp()->notNull(),
        ]);

        // creates index for column `created_by`
        $this->createIndex(
            'idx-cms_pages-created_by',
            'cms_pages',
            'created_by'
        );

        // add foreign key for table `user`
        $this->addForeignKey(
            'fk-cms_pages-created_by',
            'cms_pages',
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
            'fk-cms_pages-created_by',
            'cms_pages'
        );

        // drops index for column `created_by`
        $this->dropIndex(
            'idx-cms_pages-created_by',
            'cms_pages'
        );

        $this->dropTable('cms_pages');
    }
}
