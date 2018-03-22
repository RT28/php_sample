<?php

namespace backend\models;

use Yii;

/**
 * This is the model class for table "continent".
 *
 * @property integer $id
 * @property string $name
 * @property string $countries
 */
class Continent extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'continent';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['name', 'countries'], 'required'],
            [['name'], 'string', 'max' => 100], 
            [['name'], 'unique'],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'name' => 'Name',
            'countries' => 'Countries',
        ];
    }
}
