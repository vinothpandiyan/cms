<?php

namespace caritor\cms\models;

use Yii;
use common\models\User;

/**
 * This is the model class for table "cms_menu".
 *
 * @property integer $menu_id
 * @property integer $page_id
 * @property integer $parent_menu_id
 * @property integer $area_id
 * @property integer $created_by
 * @property string $created_at
 * @property string $updated_at
 *
 * @property CmsMenuArea $area
 * @property User $createdBy
 * @property CmsPages $page
 * @property CmsMenu $parentMenu
 * @property CmsMenu[] $cmsMenus
 */
class CmsMenu extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'cms_menu';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['page_id', 'area_id', 'created_by'], 'required'],
            [['page_id', 'parent_menu_id', 'area_id', 'created_by', 'sort_order'], 'integer'],
            [['created_at', 'updated_at'], 'safe'],
            [['area_id'], 'exist', 'skipOnError' => true, 'targetClass' => CmsMenuArea::className(), 'targetAttribute' => ['area_id' => 'area_id']],
            [['created_by'], 'exist', 'skipOnError' => true, 'targetClass' => User::className(), 'targetAttribute' => ['created_by' => 'id']],
            [['page_id'], 'exist', 'skipOnError' => true, 'targetClass' => CmsPages::className(), 'targetAttribute' => ['page_id' => 'page_id']],
            [['parent_menu_id'], 'exist', 'skipOnError' => true, 'targetClass' => CmsMenu::className(), 'targetAttribute' => ['parent_menu_id' => 'menu_id']],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'menu_id' => 'Menu ID',
            'page_id' => 'Page ID',
            'parent_menu_id' => 'Parent Menu ID',
            'area_id' => 'Area ID',
            'created_by' => 'Created By',
            'created_at' => 'Created At',
            'updated_at' => 'Updated At',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getArea()
    {
        return $this->hasOne(CmsMenuArea::className(), ['area_id' => 'area_id']);
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
    public function getPage()
    {
        return $this->hasOne(CmsPages::className(), ['page_id' => 'page_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getParentMenu()
    {
        return $this->hasOne(CmsMenu::className(), ['menu_id' => 'parent_menu_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getCmsMenus()
    {
        return $this->hasMany(CmsMenu::className(), ['parent_menu_id' => 'menu_id']);
    }

}
