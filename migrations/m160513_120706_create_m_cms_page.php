<?php

use yii\db\Migration;

/**
 * Handles the creation for table `m_cms_page`.
 */
class m160513_120706_create_m_cms_page extends Migration
{
    /**
     * @inheritdoc
     */
    public function up()
    {
        $this->createTable('m_cms_page', [
            'page_id' => $this->primaryKey(),
            'title' => $this->string(255)->notNull()->unique(),
            'description' => $this->text(),
            'status' => $this->boolean()->notNull()->defaultValue(1),
            'menu_title' => $this->string(45)->notNull()->unique(),
            'created_by' => $this->integer(),
            'created_at' => $this->timestamp()->notNull(),
            'updated_at' => $this->timestamp()->notNull(),
        ]);
    }

    /**
     * @inheritdoc
     */
    public function down()
    {
        $this->dropTable('m_cms_page');
    }
}
