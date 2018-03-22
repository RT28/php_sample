<?php

namespace common\models;
use yii\helpers\ArrayHelper;
use backend\models\EmployeeLogin;

use Yii;

/**
 * This is the model class for table "degree".
 *
 * @property integer $id
 * @property string $name
 * @property integer $created_by
 * @property string $created_at
 * @property integer $updated_by
 * @property string $updated_at
 *
 * @property Majors[] $majors
 * @property UniversityCourseList[] $universityCourseLists
 */
class Degree extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'degree';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['name', 'created_by', 'created_at', 'updated_by', 'updated_at'], 'required'],
            [['created_at', 'updated_at','created_by', 'updated_by'], 'safe'],
            [['name'], 'string', 'max' => 255],
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
            'created_by' => 'Created By',
            'created_at' => 'Created At',
            'updated_by' => 'Updated By',
            'updated_at' => 'Updated At',
        ];
    }

    public static function getAllDegrees() {
        $degrees = Degree::find()->orderBy('name','ASC')->all();
        return ArrayHelper::map($degrees, 'id', 'name');
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getMajors() 
    {
        return $this->hasMany(Majors::className(), ['degree_id' => 'id']);
    }
    /**
     * @return \yii\db\ActiveQuery
     */
     public function getUniversityCourseLists()
     {
         return $this->hasMany(UniversityCourseList::className(), ['degree_id' => 'id']);
     }
}
