<?php

namespace common\models;

use Yii;
use yii\helpers\ArrayHelper;

/**
 * This is the model class for table "package_type".
 *
 * @property integer $id
 * @property string $name
 * @property string $description
 * @property integer $status
 * @property integer $rank
 * @property integer $created_by
 * @property string $created_at
 * @property integer $updated_by
 * @property string $updated_at
 *
 * @property PackageSubtype[] $packageSubtypes
 * @property StudentPackageDetails[] $studentPackageDetails
 */
class PackageType extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'package_type';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['name', 'rank'], 'required'],
            [['status', 'rank'], 'integer'],
            [['created_at', 'updated_at','created_by', 'updated_by','name_fa','description_fa'], 'safe'],
            [['name'], 'string', 'max' => 50],
            [['description','tnc'], 'string', 'max' => 5000],
			[['name'], 'unique', 'targetAttribute' => ['name'], 'message' => 'The Name has already been taken.'],
            
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
            'description' => 'Description',
            'name_fa' => 'Name in Farsi',
            'description_fa' => 'Description in Farsi',
			'tnc' => 'Terms and Conditions',
            'status' => 'Status',
            'rank' => 'Rank',
            'created_by' => 'Created By',
            'created_at' => 'Created At',
            'updated_by' => 'Updated By',
            'updated_at' => 'Updated At',
        ];
    }

    public static function getPackageType() {
        $models = PackageType::find()->where(['AND','status','1'])->orderBy('rank')->all();
        return ArrayHelper::map($models, 'id', 'name');
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getPackageSubtypes()
    {
        return $this->hasMany(PackageSubtype::className(), ['package_type_id' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getStudentPackageDetails()
    {
        return $this->hasMany(StudentPackageDetails::className(), ['package_type_id' => 'id']);
    }
}