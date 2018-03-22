<?php

namespace partner\models;
use partner\models\PartnerLogin;

use Yii;

/**
 * This is the model class for table "partner".
 *
 * @property integer $id
 * @property integer $partner_id
 * @property integer $university_id
 * @property string $first_name
 * @property string $last_name
 * @property string $date_of_birth
 * @property string $gender
 * @property string $address
 * @property string $street
 * @property integer $city
 * @property integer $state
 * @property integer $country
 * 
 * @property PartnerLogin $partner
 */
class Partner extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'partner';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['partner_id', 'first_name', 'last_name', 'date_of_birth', 'gender', 'address', 'street', 'city', 'state', 'country'], 'required'],
            [['partner_id', 'university_id', 'city', 'state', 'country'], 'integer'],
            [['date_of_birth'], 'safe'],
            [['first_name', 'last_name', 'address', 'street'], 'string', 'max' => 255],
            [['gender'], 'string', 'max' => 50],
            [['partner_id'], 'exist', 'skipOnError' => true, 'targetClass' => PartnerLogin::className(), 'targetAttribute' => ['partner_id' => 'id']], 
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'partner_id' => 'Partner',
            'first_name' => 'First Name',
            'last_name' => 'Last Name',
            'date_of_birth' => 'Date Of Birth',
            'gender' => 'Gender',
            'address' => 'Address',
            'street' => 'Street',
            'city' => 'City',
            'state' => 'State',
            'country' => 'Country',
        ];
    }

    /**
    * @return \yii\db\ActiveQuery
    */
    public function getPartner()
    {
        return $this->hasOne(PartnerLogin::className(), ['id' => 'partner_id']);
    }
}
