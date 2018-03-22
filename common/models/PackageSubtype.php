<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "package_subtype".
 *
 * @property integer $id
 * @property integer $package_type_id
 * @property string $name
 * @property integer $limit_count
 * @property integer $fees
 * @property string $description
 * @property integer $currency
 * @property integer $limit_type
 * @property integer $status
 * @property integer $rank
 * @property string $package_offerings
 * @property integer $created_by
 * @property integer $updated_by
 * @property string $created_at
 * @property string $updated_at
 *
 * @property Currency $currency0
 * @property PackageType $packageType
 */
class PackageSubtype extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'package_subtype';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['package_type_id', 'name', 'limit_count', 'fees', 'currency', 'limit_type', 'rank'], 'required'],
            [['package_type_id', 'limit_count', 'fees', 'currency', 'limit_type', 'status', 'rank', ], 'integer'],
            [['created_at', 'updated_at','created_by', 'updated_by'], 'safe'],
            [['name'], 'string', 'max' => 50],
            [['description'], 'string', 'max' => 200],
            ['package_offerings', 'each', 'rule' => ['string']],
            [['currency'], 'exist', 'skipOnError' => true, 'targetClass' => Currency::className(), 'targetAttribute' => ['currency' => 'id']],
            [['package_type_id'], 'exist', 'skipOnError' => true, 'targetClass' => PackageType::className(), 'targetAttribute' => ['package_type_id' => 'id']],
			[['name','package_type_id'], 'unique', 'targetAttribute' => ['name','package_type_id'], 'message' => 'The combination of Package Type and Package Type Name has already been taken.'],
            
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'package_type_id' => 'Package Type',
            'name' => 'Name',
            'limit_count' => 'Limit Count',
            'fees' => 'Fees',
            'description' => 'Description',
            'currency' => 'Currency',
            'limit_type' => 'Limit Type',
            'status' => 'Status',
            'rank' => 'Rank',
            'package_offerings' => 'Package Offerings',
            'created_by' => 'Created By',
            'updated_by' => 'Updated By',
            'created_at' => 'Created At',
            'updated_at' => 'Updated At',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getCurrency0()
    {
        return $this->hasOne(Currency::className(), ['id' => 'currency']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getPackageType()
    {
        return $this->hasOne(PackageType::className(), ['id' => 'package_type_id']);
    }
}