<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "universityinfo".
 *
 * @property integer $id
 * @property integer $consultant_id
 * @property integer $university_id
 * @property string $question
 * @property string $answer
 * @property integer $created_by
 * @property string $created_at
 * @property integer $updated_by
 * @property string $updated_at
 *
 * @property Consultant $consultant
 * @property University $university
 */
class Universityinfo extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'universityinfo';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['consultant_id', 'university_id', 'category', 'question', 'answer', 'created_by', 'created_at', 'updated_by', 'updated_at'], 'required'],
            [['consultant_id', 'university_id', 'category', 'created_by', 'updated_by'], 'integer'],
            ['custom_category', 'required', 'when' => function ($model) {
                    return $model->category == '0';
                }, 'whenClient' => "function (attribute, value) {
                        return $('#category').val() == '0';
                    }"],
            [['created_at', 'updated_at'], 'safe'],
            [['question', 'answer'], 'string', 'max' => 255],
            [['consultant_id'], 'exist', 'skipOnError' => true, 'targetClass' => Consultant::className(), 'targetAttribute' => ['consultant_id' => 'consultant_id']],
            [['university_id'], 'exist', 'skipOnError' => true, 'targetClass' => University::className(), 'targetAttribute' => ['university_id' => 'id']],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'consultant_id' => 'Consultant ID',
            'university_id' => 'University ID',
            'category' => 'Category',
            'question' => 'Question',
            'answer' => 'Answer',
            'created_by' => 'Created By',
            'created_at' => 'Created At',
            'updated_by' => 'Updated By',
            'updated_at' => 'Updated At',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getConsultant()
    {
        return $this->hasOne(Consultant::className(), ['consultant_id' => 'consultant_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getUniversity()
    {
        return $this->hasOne(University::className(), ['id' => 'university_id']);
    }
}