<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "university_gallery".
 *
 * @property integer $id
 * @property integer $university_id
 * @property string $photo_type
 * @property string $filename
 * @property integer $status
 */
class UniversityGallery extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'university_gallery';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['university_id', 'photo_type', 'filename', 'status'], 'required'],
            [['university_id', 'status'], 'integer'],
            [['photo_type', 'filename'], 'string', 'max' => 255],
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
            'photo_type' => 'Photo Type',
            'filename' => 'Filename',
            'status' => 'Status',
        ];
    }
}
