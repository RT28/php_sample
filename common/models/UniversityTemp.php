<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "university_temp".
 *
 * @property integer $id
 * @property integer $university_id
 * @property string $name
 * @property integer $is_partner
 * @property integer $establishment_date
 * @property string $address
 * @property integer $city_id
 * @property integer $state_id
 * @property integer $country_id
 * @property string $pincode
 * @property string $email
 * @property string $website
 * @property string $description
 * @property string $fax
 * @property string $phone_1
 * @property string $phone_2
 * @property string $contact_person
 * @property string $contact_person_designation
 * @property string $contact_mobile
 * @property string $contact_email
 * @property string $location
 * @property integer $institution_type
 * @property integer $establishment
 * @property integer $no_of_students
 * @property integer $no_of_undergraduate_students
 * @property integer $no_of_post_graduate_students
 * @property integer $no_of_international_students
 * @property integer $no_faculties
 * @property integer $no_of_international_faculty
 * @property integer $cost_of_living
 * @property integer $undergarduate_fees
 * @property integer $undergraduate_fees_international_students
 * @property integer $post_graduate_fees
 * @property integer $post_graduate_fees_international_students
 * @property boolean $accomodation_available
 * @property integer $hostel_strength
 * @property string $institution_ranking
 * @property string $video
 * @property string $virtual_tour
 * @property integer $avg_rating
 * @property boolean $standard_tests_required
 * @property string $standard_test_list
 * @property string $achievements
 * @property string $comments
 * @property integer $currency_id
 * @property integer $currency_international_id
 * @property integer $status
 * @property string $created_by
 * @property string $created_at
 * @property string $updated_by
 * @property string $updated_at
 * @property string $reviewed_by
 * @property string $reviewed_at
 */
class UniversityTemp extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'university_temp';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['university_id', 'is_partner', 'establishment_date', 'city_id', 'state_id', 'country_id', 'institution_type', 'establishment', 'no_of_students', 'no_of_undergraduate_students', 'no_of_post_graduate_students', 'no_of_international_students', 'no_faculties', 'no_of_international_faculty', 'cost_of_living', 'undergarduate_fees', 'undergraduate_fees_international_students', 'post_graduate_fees', 'post_graduate_fees_international_students', 'hostel_strength', 'avg_rating', 'currency_id', 'currency_international_id', 'status'], 'integer'],
            [['name', 'address', 'city_id', 'state_id', 'country_id', 'pincode', 'email', 'website', 'description', 'phone_1', 'currency_id', 'created_by', 'created_at', 'updated_by', 'updated_at'], 'required'],
            [['description', 'location', 'institution_ranking', 'achievements', 'comments'], 'string'],
            [['accomodation_available', 'standard_tests_required'], 'boolean'],
            [['created_at', 'updated_at', 'reviewed_at'], 'safe'],
            [['name', 'address', 'email', 'website', 'contact_person', 'contact_email'], 'string', 'max' => 255],
            [['pincode'], 'string', 'max' => 11],
            [['fax', 'phone_1', 'phone_2'], 'string', 'max' => 20],
            [['contact_person_designation'], 'string', 'max' => 50],
            [['contact_mobile'], 'string', 'max' => 15],
            [['video', 'virtual_tour', 'standard_test_list'], 'string', 'max' => 500],
            [['created_by', 'updated_by', 'reviewed_by'], 'string', 'max' => 100],
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
            'name' => 'Name',
            'is_partner' => 'Is Partner',
            'establishment_date' => 'Establishment Date',
            'address' => 'Address',
            'city_id' => 'City ID',
            'state_id' => 'State ID',
            'country_id' => 'Country ID',
            'pincode' => 'Zip Code',
            'email' => 'Email',
            'website' => 'Website',
            'description' => 'Description',
            'fax' => 'Fax',
            'phone_1' => 'Phone 1',
            'phone_2' => 'Phone 2',
            'contact_person' => 'Contact Person',
            'contact_person_designation' => 'Contact Person Designation',
            'contact_mobile' => 'Contact Mobile',
            'contact_email' => 'Contact Email',
            'location' => 'Location',
            'institution_type' => 'Institution Type',
            'establishment' => 'Establishment',
            'no_of_students' => 'No Of Students',
            'no_of_undergraduate_students' => 'No Of Undergraduate Students',
            'no_of_post_graduate_students' => 'No Of Post Graduate Students',
            'no_of_international_students' => 'No Of International Students',
            'no_faculties' => 'No Faculties',
            'no_of_international_faculty' => 'No Of International Faculty',
            'cost_of_living' => 'Cost Of Living',
            'undergarduate_fees' => 'Undergarduate Fees',
            'undergraduate_fees_international_students' => 'Undergraduate Fees International Students',
            'post_graduate_fees' => 'Post Graduate Fees',
            'post_graduate_fees_international_students' => 'Post Graduate Fees International Students',
            'accomodation_available' => 'Accomodation Available',
            'hostel_strength' => 'Hostel Strength',
            'institution_ranking' => 'Institution Ranking',
            'video' => 'Video',
            'virtual_tour' => 'Virtual Tour',
            'avg_rating' => 'Avg Rating',
            'standard_tests_required' => 'Standard Tests Required',
            'standard_test_list' => 'Standard Test List',
            'achievements' => 'Achievements',
            'comments' => 'Comments',
            'currency_id' => 'Currency ID',
            'currency_international_id' => 'Currency International ID',
			'application_requirement' => 'Application Requirements',
			'fees' => 'Fees',
			'deadlines' => 'Deadlines',
			'cost_of_living_text' => 'Cost of Living',
			'accommodation' => 'Accommodation',
            'status' => 'Status',
            'created_by' => 'Created By',
            'created_at' => 'Created At',
            'updated_by' => 'Updated By',
            'updated_at' => 'Updated At',
            'reviewed_by' => 'Reviewed By',
            'reviewed_at' => 'Reviewed At',
        ];
    }
	
	 /** 
     * @return \yii\db\ActiveQuery
     */
    public function getCity()
    {
        return $this->hasOne(City::className(), ['id' => 'city_id']);
    }    

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getCurrency()
    {
        return $this->hasOne(Currency::className(), ['id' => 'currency_id']);
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
