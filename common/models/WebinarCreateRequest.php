<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "webinar_create_request".
 *
 * @property integer $id
 * @property string $topic
 * @property string $date_time
 * @property string $author_name
 * @property string $email
 * @property string $phone
 * @property string $logo_image
 * @property string $duration
 * @property string $country
 * @property string $disciplines
 * @property string $degreelevels
 * @property string $university_admission
 * @property string $test_preperation
 * @property integer $status
 * @property integer $created_by
 * @property string $created_at
 * @property integer $updated_by
 * @property string $updated_at
 *
 * @property WebinarRegisteredStudents[] $webinarRegisteredStudents
 * @property WebinarStudentsQuestions[] $webinarStudentsQuestions
 */
class WebinarCreateRequest extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'webinar_create_request';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['topic',  'author_name','webinar_description','speaker_description', 'institution_name', 'date_time', 'email', 'code', 'phone','country', 'degreelevels', 'university_admission', 'test_preperation', 'disciplines', 'logo_image'], 'required'],
            [[ 'created_at', 'updated_at','logo_image', 'duration', 'country', 'disciplines', 'degreelevels', 'university_admission', 'test_preperation'], 'safe'],
            [['status'], 'integer'],
            [['topic'], 'string', 'max' => 255],
            [['author_name', 'institution_name', 'email', 'code', 'phone', 'logo_image', 'duration'], 'string', 'max' => 50],
            [[ 'webinar_description', 'speaker_description'], 'string'],
            [['university_admission'], 'string', 'max' => 100],
            [['phone'], 'match', 'pattern'=>"/^(\d{6})|(\d{7})|(\d{8})|(\d{9})|(\d{10})$/", 'message'=>'Please enter valid phone number'],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'topic' => 'Topic',
            'date_time' => 'Date Time',
            'author_name' => 'Speaker Name',
            'webinar_description' => 'Description about topic',
            'speaker_description' => 'Description about speaker',
            'institution_name' => 'University/Institution',
            'email' => 'Email',
            'code' => 'Code',
            'phone' => 'Phone',
            'logo_image' => 'Logo Image',
            'duration' => 'Duration',
            'country' => 'Country',
            'disciplines' => 'Disciplines',
            'degreelevels' => 'Degreelevels',
            'university_admission' => 'University Admission',
            'test_preperation' => 'Test Preperation',
            'status' => 'Status',
            'created_by' => 'Created By',
            'created_at' => 'Created At',
            'updated_by' => 'Updated By',
            'updated_at' => 'Updated At',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getWebinarRegisteredStudents()
    {
        return $this->hasMany(WebinarRegisteredStudents::className(), ['webinar_id' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getWebinarStudentsQuestions()
    {
        return $this->hasMany(WebinarStudentsQuestions::className(), ['webinar_id' => 'id']);
    }
}
