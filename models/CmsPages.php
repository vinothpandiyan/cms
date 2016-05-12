<?php

namespace caritor\cms\models;

use Yii;
use common\models\User;

/**
 * This is the model class for table "cms_pages".
 *
 * @property integer $page_id
 * @property string $title
 * @property string $description
 * @property string $status
 * @property string $menu_title
 * @property integer $created_by
 * @property string $created_at
 * @property string $updated_at
 *
 * @property CmsMenu[] $cmsMenus
 * @property User $createdBy
 */
class CmsPages extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'cms_pages';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['title', 'menu_title', 'created_by'], 'required'],
            [['description', 'status'], 'string'],
            [['created_by'], 'integer'],
            [['created_at', 'updated_at'], 'safe'],
            [['title'], 'string', 'max' => 255],
            [['menu_title'], 'string', 'max' => 45],
            [['created_by'], 'exist', 'skipOnError' => true, 'targetClass' => User::className(), 'targetAttribute' => ['created_by' => 'id']],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'page_id' => 'Page ID',
            'title' => 'Title',
            'description' => 'Description',
            'status' => 'Status',
            'menu_title' => 'Menu Title',
            'created_by' => 'Created By',
            'created_at' => 'Created At',
            'updated_at' => 'Updated At',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getCmsMenus()
    {
        return $this->hasMany(CmsMenu::className(), ['page_id' => 'page_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getCreatedBy()
    {
        return $this->hasOne(User::className(), ['id' => 'created_by']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getUser()
    {
        return $this->hasOne(User::className(), ['id' => 'created_by']);
    }
}
