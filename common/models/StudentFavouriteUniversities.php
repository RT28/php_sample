<?php

namespace common\models;
use frontend\models\UserLogin;

use Yii;

/**
 * This is the model class for table "student_favourite_universities".
 *
 * @property integer $id
 * @property integer $student_id
 * @property integer $university_id
 * @property integer $favourite
 * @property integer $created_by
 * @property string $created_at
 * @property integer $updated_by
 * @property string $updated_at
 *
 * @property UserLogin $student
 * @property University $university
 */
class StudentFavouriteUniversities extends \yii\db\ActiveRecord
{
	
	public $universities;
	
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'student_favourite_universities';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['student_id', 'university_id', 'created_by', 'created_at', 'updated_by', 'updated_at'], 'required'],
            [['student_id', 'university_id', 'favourite', ], 'integer'],
            [['created_at', 'updated_at','created_by', 'updated_by'], 'safe'],
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
