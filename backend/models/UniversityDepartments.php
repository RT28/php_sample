<?php

namespace backend\models;

use Yii;
use common\models\University;
use common\models\UniversityCourseList;

/**
 * This is the model class for table "university_departments".
 *
 * @property integer $id
 * @property integer $university_id
 * @property string $name
 * @property string $email
 * @property integer $no_of_faculty
 * @property string $website_link
 * @property string $description
 * @property integer $created_by
 * @property string $created_at
 * @property integer $updated_by
 * @property string $updated_at
 *
 * @property UniversityAdmission[] $universityAdmissions
 * @property UniversityCourseList[] $universityCourseLists
 * @property University $university
 */
class UniversityDepartments extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'university_departments';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['university_id', 'name'], 'required'],
            [['university_id', 'no_of_faculty', 'created_by', 'updated_by'], 'integer'],
            [['website_link', 'description'], 'string'],
            [['created_at', 'updated_at'], 'safe'],
            [['name'], 'string', 'max' => 255],
            [['email'], 'string', 'max' => 100],
            [['email'], 'email'],
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
            'university_id' => 'University ID',
            'name' => 'Title',
            'email' => 'Email',
            'no_of_faculty' => 'No Of Faculty',
            'website_link' => 'Website Link',
            'description' => 'Description',
            'created_by' => 'Created By',
            'created_at' => 'Created At',
            'updated_by' => 'Updated By',
            'updated_at' => 'Updated At',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getUniversityAdmissions()
    {
        return $this->hasMany(UniversityAdmission::className(), ['department_id' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getUniversityCourseLists()
    {
        return $this->hasMany(UniversityCourseList::className(), ['department_id' => 'id']);
    }
    
        /**
     * @return \yii\db\ActiveQuery
     */
    public function getUniversity()
    {
        return $this->hasOne(University::className(), ['id' => 'university_id']);
    }
}
