<?php

namespace backend\models;

use Yii;

/**
 * This is the model class for table "gtu_environment".
 *
 * @property integer $gt_id
 * @property string $gt_name
 *
 * @property GtuModule[] $gtuModules
 */
class GtuEnvironment extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'gtu_environment';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['gt_name'], 'required'],
            [['gt_name'], 'string', 'max' => 30],
            [['gt_name'], 'unique'],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'gt_id' => 'Gt ID',
            'gt_name' => 'Gt Name',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getGtuModules()
    {
        return $this->hasMany(GtuModule::className(), ['gt_envid' => 'gt_id']);
    }
}
