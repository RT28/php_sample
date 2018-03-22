<?php

namespace frontend\models;

use Yii;
use frontend\models\UserLogin;
use common\models\PackageSubtype;
use common\models\PackageType;

/**
 * This is the model class for table "student_package_details".
 *
 * @property integer $id
 * @property integer $student_id
 * @property integer $package_type_id
 * @property integer $package_subtype_id
 * @property string $package_offerings
 * @property integer $limit_type
 * @property integer $limit_pending
 * @property string $created_at
 * @property integer $created_by
 * @property string $updated_at
 * @property integer $updated_by
 *
 * @property UserLogin $student
 * @property PackageSubtype $packageSubtype
 * @property PackageType $packageType
 */
class StudentPackageDetails extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'student_package_details';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['student_id', 'package_type_id', 'package_subtype_id', 'package_offerings'], 'required'],
            [['student_id', 'package_type_id', 'package_subtype_id', 'limit_type', 'limit_pending', 'created_by', 'updated_by'], 'integer'],
            [['created_at', 'updated_at'], 'safe'],            
            [['student_id'], 'exist', 'skipOnError' => true, 'targetClass' => UserLogin::className(), 'targetAttribute' => ['student_id' => 'id']],
            [['package_subtype_id'], 'exist', 'skipOnError' => true, 'targetClass' => PackageSubtype::className(), 'targetAttribute' => ['package_subtype_id' => 'id']],
            [['package_type_id'], 'exist', 'skipOnError' => true, 'targetClass' => PackageType::className(), 'targetAttribute' => ['package_type_id' => 'id']],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'student_id' => 'Student',
            'package_type_id' => 'Package Type',
            'package_subtype_id' => 'Package Subtype',
            'package_offerings' => 'Package Offerings',
            'limit_type' => 'Limit Type',
            'limit_pending' => 'Limit Pending',
            'created_at' => 'Created At',
            'created_by' => 'Created By',
            'updated_at' => 'Updated At',
            'updated_by' => 'Updated By',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getStudent()
    {
        return $this->hasOne(UserLogin::className(), ['id' => 'student_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getPackageSubtype()
    {
        return $this->hasOne(PackageSubtype::className(), ['id' => 'package_subtype_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getPackageType()
    {
        return $this->hasOne(PackageType::className(), ['id' => 'package_type_id']);
    }
}
