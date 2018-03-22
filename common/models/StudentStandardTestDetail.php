<?php

namespace common\models;
use frontend\models\UserLogin;

use Yii;

/**
 * This is the model class for table "student_standard_test_detail".
 *
 * @property integer $id
 * @property integer $student_id
 * @property string $test_name
 * @property integer $verbal_score
 * @property integer $quantitative_score
 * @property integer $integrated_reasoning_score
 * @property integer $data_interpretation_score
 * @property integer $created_by
 * @property integer $updated_by
 * @property string $created_at
 * @property string $updated_at
 *
 * @property UserLogin $student
 */
class StudentStandardTestDetail extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public $other_test;
    public static function tableName()
    {
        return 'student_standard_test_detail';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['student_id', 'test_name','test_date', 'created_by', 'updated_by', 'created_at', 'updated_at'], 'required'],
            [['student_id', 'test_id'], 'integer'],
            [['created_at', 'updated_at','created_by', 'updated_by'], 'safe'],
            [['test_name','test_authority'], 'string', 'max' => 255],
            [['student_id'], 'exist', 'skipOnError' => true, 'targetClass' => UserLogin::className(), 'targetAttribute' => ['student_id' => 'id']],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'student_id' => 'Student ID',
            'test_name' => 'Standard Test',
            'test_authority' => 'Test Authority',
            'test_date' => 'Test Date',
            'test_marks' => 'Test Marks',
            'created_by' => 'Created By',
            'updated_by' => 'Updated By',
            'created_at' => 'Created At',
            'updated_at' => 'Updated At',
            'other_test' => 'Test Name',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getStudent()
    {
        return $this->hasOne(UserLogin::className(), ['id' => 'student_id']);
    }
}
