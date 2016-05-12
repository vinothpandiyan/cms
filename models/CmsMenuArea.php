<?php

namespace caritor\cms\models;

use Yii;
use common\models\User;

/**
 * This is the model class for table "cms_menu_area".
 *
 * @property integer $area_id
 * @property string $name
 * @property string $status
 * @property string $area_code
 * @property integer $created_by
 * @property string $created_at
 * @property string $updated_at
 *
 * @property CmsMenu[] $cmsMenus
 * @property User $createdBy
 */
class CmsMenuArea extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'cms_menu_area';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['name', 'area_code', 'created_by'], 'required'],
            [['status'], 'string'],
            [['created_by'], 'integer'],
            [['created_at', 'updated_at'], 'safe'],
            [['name', 'area_code'], 'string', 'max' => 32],
            [['area_code'], 'unique'],
            [['created_by'], 'exist', 'skipOnError' => true, 'targetClass' => User::className(), 'targetAttribute' => ['created_by' => 'id']],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'area_id' => 'Area ID',
            'name' => 'Name',
            'status' => 'Status',
            'area_code' => 'Area Code',
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
        return $this->hasMany(CmsMenu::className(), ['area_id' => 'area_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getCreatedBy()
    {
        return $this->hasOne(User::className(), ['id' => 'created_by']);
    }
}
