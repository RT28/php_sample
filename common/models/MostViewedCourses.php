<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "most_viewed_courses".
 *
 * @property integer $id
 * @property integer $course_id
 * @property integer $university_id
 * @property integer $view
 */
class MostViewedCourses extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'most_viewed_courses';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['course_id', 'university_id', 'view'], 'required'],
            [['course_id', 'university_id', 'view'], 'integer'], 
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'course_id' => 'Course ID',
            'university_id' => 'University ID',
            'view' => 'View',
        ];
    }
}
