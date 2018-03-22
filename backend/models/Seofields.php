<?php

namespace backend\models;

use Yii;

/**
 * This is the model class for table "gt_seofields".
 *
 * @property integer $gt_id
 * @property string $gt_title
 * @property string $gt_desccontent
 * @property string $gt_keycontent
 * @property string $gt_linkurl
 */
class Seofields extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'seofields';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['gt_title', 'gt_desccontent', 'gt_keycontent', 'gt_linkurl'], 'required'],
            [['gt_id'], 'integer'],
            [['gt_title'], 'string', 'max' => 100],
            [['gt_desccontent', 'gt_keycontent'], 'string', 'max' => 200],
            [['gt_linkurl'], 'string', 'max' => 250],
            [['gt_linkurl'], 'unique'],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'gt_id' => 'ID',
            'gt_title' => 'Title',
            'gt_desccontent' => 'Description',
            'gt_keycontent' => 'Keywords',
            'gt_linkurl' => 'Linkurl',
        ];
    }
}
