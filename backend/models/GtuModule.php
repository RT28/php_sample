<?php

namespace backend\models;

use Yii;

/**
 * This is the model class for table "gtu_module".
 *
 * @property integer $gt_id
 * @property integer $gt_envid
 * @property string $gt_name
 *
 * @property GtuEnvironment $gtEnv
 */
class GtuModule extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'gtu_module';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['gt_envid', 'gt_name'], 'required'],
            [['gt_envid'], 'integer'],
            [['gt_name'], 'string', 'max' => 30],
            [['gt_envid'], 'exist', 'skipOnError' => true, 'targetClass' => GtuEnvironment::className(), 'targetAttribute' => ['gt_envid' => 'gt_id']],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'gt_id' => 'Gt ID',
            'gt_envid' => 'Gt Envid',
            'gt_name' => 'Gt Name',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getGtEnv()
    {
        return $this->hasOne(GtuEnvironment::className(), ['gt_id' => 'gt_envid']);
    }
}
