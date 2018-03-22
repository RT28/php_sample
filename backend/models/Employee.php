<?php

namespace backend\models;

use Yii;
use common\models\Country;
use common\models\State;
use backend\models\EmployeeLogin;
/**
 * This is the model class for table "employee".
 *
 * @property integer $id
 * @property string $first_name
 * @property string $last_name
 * @property string $date_of_birth
 * @property string $gender
 * @property string $address
 * @property string $street
 * @property string  $city
 * @property integer $state
 * @property integer $country
 * @property integer $created_by 
 * @property string $created_at 
 * @property integer $updated_by 
 * @property string $updated_at 
 * 
 * @property Country $country0 
 * @property State $state0 
 * @property EmployeeLogin[] $employeeLogins
 */
class Employee extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'employee';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['first_name', 'last_name', 'date_of_birth', 'gender', 'address', 'city', 'state', 'country'], 'required'],
            [['date_of_birth','street'], 'safe'],
            [['state', 'country'], 'integer'],
            [['first_name', 'last_name', 'address', 'street'], 'string', 'max' => 255],
            [['city', 'gender'], 'string', 'max' => 50],
            [['country'], 'exist', 'skipOnError' => true, 'targetClass' => Country::className(), 'targetAttribute' => ['country' => 'id']],
            [['state'], 'exist', 'skipOnError' => true, 'targetClass' => State::className(), 'targetAttribute' => ['state' => 'id']],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'first_name' => 'First Name',
            'last_name' => 'Last Name',
            'date_of_birth' => 'Date Of Birth',
            'gender' => 'Gender',
            'address' => 'Address',
            'street' => 'Street',
            'city' => 'City',
            'state' => 'State',
            'country' => 'Country',
            'created_by' => 'Created By', 
            'created_at' => 'Created At', 
            'updated_by' => 'Updated By', 
            'updated_at' => 'Updated At',
        ];
    }

    /** 
    * @return \yii\db\ActiveQuery 
    */ 
    public function getCountry0() 
    { 
           return $this->hasOne(Country::className(), ['id' => 'country']); 
    } 
 
    /** 
    * @return \yii\db\ActiveQuery 
    */ 
    public function getState0() 
    { 
           return $this->hasOne(State::className(), ['id' => 'state']); 
    } 
 
    /** 
    * @return \yii\db\ActiveQuery 
    */ 
   /* public function getEmployeeLogins() 
    { 
           return $this->hasMany(EmployeeLogin::className(), ['employee_id' => 'id']); 
    }*/
    public function getEmployeeLogins() 
    { 
           return $this->hasOne(EmployeeLogin::className(), ['id' => 'employee_id']); 
    }
}
