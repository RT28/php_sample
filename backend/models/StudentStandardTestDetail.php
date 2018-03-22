<?php

namespace backend\models;

use Yii;

/**
 * This is the model class for table "student_standard_test_detail".
 *
 * @property integer $id
 * @property integer $student_id
 * @property string $test_name
 * @property string $test_authority
 * @property string $test_date
 * @property string $test_marks
 * @property string $created_by
 * @property string $updated_by
 * @property string $created_at
 * @property string $updated_at
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
            [['student_id', 'test_name', 'test_date', 'created_by', 'updated_by', 'created_at', 'updated_at'], 'required'],
            [['student_id','test_id'], 'integer'],
            [['test_date', 'created_at', 'updated_at'], 'safe'],
            [['test_name', 'test_authority'], 'string', 'max' => 255],
            [['test_marks'], 'string', 'max' => 600],
            [['created_by', 'updated_by'], 'string', 'max' => 50],
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
}
