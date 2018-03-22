<?php

namespace common\models;

use Yii;
use yii\helpers\ArrayHelper;

/**
 * This is the model class for table "ranking_type".
 *
 * @property integer $id
 * @property string $category
 */
class RankingType extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'ranking_type';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['type','name'], 'required'],
            [['type','name'], 'string', 'max' => 255],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'type' => 'Type',
            'name' => 'Name',
        ];
    }
        public static function getRankingTypeType() {
        $models = RankingType::find()->orderBy('id')->all();
        return ArrayHelper::map($models, 'id', 'type','name');
    }
}
