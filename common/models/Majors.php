<?php

namespace common\models;
use yii\helpers\ArrayHelper;

use Yii;

/**
 * This is the model class for table "majors".
 *
 * @property integer $id
 * @property string $name
 * @property integer $created_by
 * @property string $created_at
 * @property integer $updated_by
 * @property string $updated_at
 */
class Majors extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'majors';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['name', 'degree_id', 'created_by', 'created_at', 'updated_by', 'updated_at'], 'required'],
            [['created_by', 'updated_by'], 'safe'],
            [['created_at', 'updated_at'], 'safe'],
            [['name'], 'string', 'max' => 255],
			[['name','degree_id'], 'unique', 'targetAttribute' => ['name','degree_id'], 'message' => 'The combination of Discipline, Sub-Discipline Name has already been taken.'],
            
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
            'degree_id' => 'Discipline',
            'created_by' => 'Created By',
            'created_at' => 'Created At',
            'updated_by' => 'Updated By',
            'updated_at' => 'Updated At',
        ];
    }

    public static function getAllMajors() {
        $majors = Majors::find()->orderBy('name','ASC')->orderBy('name','ASC')->all();
        return ArrayHelper::map($majors, 'id', 'name');
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getDegree()
    {
        return $this->hasOne(Degree::className(), ['id' => 'degree_id']);
    }
}
