<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "institute".
 *
 * @property integer $id
 * @property string $name
 * @property string $email
 * @property string $adress
 * @property integer $country_id
 * @property integer $state_id
 * @property string $city_id
 * @property string $tests_offered
 * @property string $video_url
 * @property string $course_offered
 * @property string $contact_details
 * @property string $contact_person
 * @property string $contact_person_designation
 * @property string $fees_structure
 * @property string $branches
 * @property string $website
 * @property string $description
 * @property string $created_at
 * @property string $created_by
 * @property string $updated_at
 * @property string $updated_by
 *
 * @property Country $country
 * @property State $state
 */
class Institute extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'institute';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['name', 'email', 'adress', 'country_id', 'state_id', 'city_id', 'tests_offered', 'video_url',  'contact_details', 'contact_person', 'contact_person_designation', 'fees_structure', 'branches', 'website', 'description', 'created_at', 'created_by', 'updated_at', 'updated_by'], 'required'],
            [['adress', 'fees_structure', 'branches', 'description'], 'string'],
            [['country_id', 'state_id'], 'integer'],
            [['created_at', 'updated_at'], 'safe'],
            [['name'], 'string', 'max' => 100],
            [['email'],'email'],
            [['email', 'video_url'], 'string', 'max' => 30],
            [['city_id', 'contact_details'], 'string', 'max' => 20],
            [['contact_person'], 'string', 'max' => 255],
            [['contact_person_designation', 'website', 'created_by', 'updated_by'], 'string', 'max' => 50],
            [['country_id'], 'exist', 'skipOnError' => true, 'targetClass' => Country::className(), 'targetAttribute' => ['country_id' => 'id']],
            [['state_id'], 'exist', 'skipOnError' => true, 'targetClass' => State::className(), 'targetAttribute' => ['state_id' => 'id']],
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
            'email' => 'Email',
            'adress' => 'Adress',
            'country_id' => 'Country ',
            'state_id' => 'State ',
            'city_id' => 'City ',
            'tests_offered' => 'Tests Offered',
            'video_url' => 'Video Url',
            'contact_details' => 'Contact Number',
            'contact_person' => 'Contact Person',
            'contact_person_designation' => 'Contact Person Designation',
            'fees_structure' => 'Fees Structure',
            'branches' => 'Branches',
            'website' => 'Website',
            'description' => 'Description',
            'created_at' => 'Created At',
            'created_by' => 'Created By',
            'updated_at' => 'Updated At',
            'updated_by' => 'Updated By',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getCountry()
    {
        return $this->hasOne(Country::className(), ['id' => 'country_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getState()
    {
        return $this->hasOne(State::className(), ['id' => 'state_id']);
    }
}
