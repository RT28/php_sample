<?php

namespace common\models;

use Yii;
use yii\helpers\ArrayHelper;

/**
 * This is the model class for table "currency".
 *
 * @property integer $id
 * @property string $name
 * @property string $iso_code
 * @property integer $country_id
 * @property string $symbol
 * @property string $created_at
 * @property integer $created_by
 * @property string $updated_at
 * @property integer $updated_by
 *
 * @property Country $country
 */
class Currency extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'currency';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['name', 'iso_code', 'country_id'], 'required'],
            [['country_id',], 'integer'],
            [['created_at', 'updated_at','created_by', 'updated_by'], 'safe'],
            [['name'], 'string', 'max' => 50],
            [['iso_code'], 'string', 'max' => 5],
            [['symbol'], 'string', 'max' => 20],
            [['country_id'], 'exist', 'skipOnError' => true, 'targetClass' => Country::className(), 'targetAttribute' => ['country_id' => 'id']],
			[['name','country_id', 'iso_code',], 'unique', 'targetAttribute' => ['name','country_id', 'iso_code'], 'message' => 'The combination of Country, ISO code and Currency Name has already been taken.'],

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
            'country_id' => 'Country',
            'symbol' => 'Symbol',
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

    public static function getCurrency() {
        $models = Currency::find()->all();
        return ArrayHelper::map($models, 'id', 'name', 'iso_code');
    }


	 public static function getCurrencyData($id) { 
		 return  Currency::find()->where(['AND',['=', 'id',$id]])->one();
    }
}
