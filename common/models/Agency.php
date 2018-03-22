<?php
 
namespace common\models;

use Yii;
use partner\models\PartnerLogin;
use yii\helpers\ArrayHelper;
/**
 * This is the model class for table "agency".
 *
 * @property integer $id
 * @property integer $partner_login_id
 * @property string $name
 * @property string $establishment_year
 * @property string $email
 * @property integer $code
 * @property integer $mobile
 * @property integer $country_id
 * @property integer $state_id
 * @property integer $city_id
 * @property integer $pincode
 * @property string $address
 * @property string $speciality
 * @property string $description
 * @property integer $status
 * @property string $created_at
 * @property integer $created_by
 * @property string $updated_at
 * @property integer $updated_by
 *
 * @property PartnerLogin $partnerLogin
 * @property Country $country
 */
class Agency extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'agency';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['partner_login_id', 'name', 'establishment_year', 'email', 'code', 'mobile', 'country_id', 'state_id', 'city_id', 'pincode', 'address', 'description', 'status', 'created_at', 'created_by', 'updated_at', 'updated_by'], 'required'],
            [['partner_login_id', 'code', 'mobile', 'country_id', 'state_id', 'city_id', 'pincode', 'status'], 'integer'],
            [['establishment_year', 'speciality', 'created_at', 'updated_at', 'created_by', 'updated_by'], 'safe'],
            [[ 'description'], 'string'],
            [['name', 'address'], 'string', 'max' => 255],
            [['email'], 'string', 'max' => 50],
			['email', 'unique'],
            [['partner_login_id'], 'exist', 'skipOnError' => true, 'targetClass' => PartnerLogin::className(), 'targetAttribute' => ['partner_login_id' => 'id']],
            [['country_id'], 'exist', 'skipOnError' => true, 'targetClass' => Country::className(), 'targetAttribute' => ['country_id' => 'id']],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'partner_login_id' => 'Partner Login ID',
            'name' => 'Name',
            'establishment_year' => 'Establishment Year',
            'email' => 'Email',
            'code' => 'Code',
            'mobile' => 'Mobile',
            'country_id' => 'Country',
            'state_id' => 'State',
            'city_id' => 'City',
            'pincode' => 'Zip Code',
            'address' => 'Address',
            'speciality' => 'Speciality',
            'description' => 'Description',
            'status' => 'Status',
            'created_at' => 'Created At',
            'created_by' => 'Created By',
            'updated_at' => 'Updated At',
            'updated_by' => 'Updated By',
        ];
    }

	public function getAllAgencies()
    {
       $Agencies = Agency::find() 
                    ->orderBy('name')
                    ->all();
		return ArrayHelper::map($Agencies, 'partner_login_id', 'name');
     
    }
	
    /**
     * @return \yii\db\ActiveQuery
     */
    public function getPartnerLogin()
    {
        return $this->hasOne(PartnerLogin::className(), ['id' => 'partner_login_id']);
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
	
	  /** 
     * @return \yii\db\ActiveQuery
     */
    public function getCity()
    {
        return $this->hasOne(City::className(), ['id' => 'city_id']);
    } 

	public function getConsultants()
    {
       $Consultants = Consultant::find() 
	     ->select(['consultant_id','CONCAT(first_name, " ", last_name) as first_name']) 
             
                    ->orderBy('first_name')
                    ->all();
		return ArrayHelper::map($Consultants, 'consultant_id', 'first_name');
     
    }	
}
