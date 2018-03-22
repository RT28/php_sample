<?php

namespace common\models;

use Yii;
use yii\helpers\ArrayHelper;

/**
 * This is the model class for table "package_offerings".
 *
 * @property integer $id
 * @property string $name
 * @property string $description
 * @property integer $time
 * @property string $status
 * @property string $created_at
 * @property string $updated_at
 * @property integer $created_by
 * @property integer $updated_by
 */
class PackageOfferings extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'package_offerings';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['name', 'time'], 'required'],
            [['time', 'status', 'created_by', 'updated_by'], 'integer'],
            [['created_at', 'updated_at'], 'safe'],
            [['name'], 'string', 'max' => 50],
            [['description'], 'string', 'max' => 500],
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
            'time' => 'Time',
            'status' => 'Status',
            'created_at' => 'Created At',
            'updated_at' => 'Updated At',
            'created_by' => 'Created By',
            'updated_by' => 'Updated By',
        ];
    }

    public static function getPackageOfferings() {
        $models = PackageOfferings::find()->all();
        return ArrayHelper::map($models, 'id', 'name');
    }
}
