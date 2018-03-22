<?php

namespace common\models;
use frontend\models\UserLogin;

use Yii;

/**
 * This is the model class for table "university_reviews_ratings".
 *
 * @property integer $id
 * @property integer $student_id
 * @property integer $university_id
 * @property string $review
 * @property double $rating
 * @property integer $created_by
 * @property string $created_at
 * @property integer $updated_by
 * @property string $updated_at
 *
 * @property UserLogin $student
 * @property University $university
 */
class UniversityReviewsRatings extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'university_reviews_ratings';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['student_id', 'university_id', 'rating'], 'required'],
            [['student_id', 'university_id', 'favourite', 'created_by', 'updated_by'], 'integer'],
            [['rating'], 'number'],
            [['created_at', 'updated_at'], 'safe'],
            [['review'], 'string', 'max' => 500],
            [['student_id', 'university_id'], 'unique', 'targetAttribute' => ['student_id', 'university_id'], 'message' => 'The combination of Student ID and University ID has already been taken.'],
            [['student_id'], 'exist', 'skipOnError' => true, 'targetClass' => UserLogin::className(), 'targetAttribute' => ['student_id' => 'id']],
            [['university_id'], 'exist', 'skipOnError' => true, 'targetClass' => University::className(), 'targetAttribute' => ['university_id' => 'id']],
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
            'university_id' => 'University ID',
            'review' => 'Review',
            'rating' => 'Rating',
            'favourite' => 'Favourite',
            'created_by' => 'Created By',
            'created_at' => 'Created At',
            'updated_by' => 'Updated By',
            'updated_at' => 'Updated At',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getStudent()
    {
        return $this->hasOne(UserLogin::className(), ['id' => 'student_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getUniversity()
    {
        return $this->hasOne(University::className(), ['id' => 'university_id']);
    }
}
