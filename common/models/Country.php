<?php

namespace common\models;

use yii\helpers\ArrayHelper;
use Yii;

/**
 * This is the model class for table "country".
 *
 * @property integer $id
 * @property string $name
 *
 * @property City[] $cities
 * @property State[] $states
 */
class Country extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'country';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['name','iso_code','phone_code','status'], 'required'],
            [['name'], 'string', 'max' => 255],
			[['iso_code'], 'string', 'max' => 5],
			[['phone_code'], 'string', 'max' => 10],
			  [['name','iso_code'], 'unique'],
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
			'iso_code' => 'ISO Code',
			'phone_code' => 'International Calling Code (+)',
			 'status' => 'Status',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getCities()
    {
        return $this->hasMany(City::className(), ['country_id' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getStates()
    {
        return $this->hasMany(State::className(), ['country_id' => 'id']);
    }

    public static function getAllCountries() {
        $countries = Country::find() 
                    ->orderBy('name')
                    ->all();
        return $countries;
    }
	
	public static function getAllCountriesPhoneCode() {
        $countries = Country::find()
					->select(['phone_code','CONCAT(name, " ","(+",phone_code,")") as name']) 
            
                    ->orderBy('name')
                    ->all(); 
		return ArrayHelper::map($countries, 'phone_code', 'name');
    }
}
