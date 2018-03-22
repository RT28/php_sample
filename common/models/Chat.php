<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "chat".
 *
 * @property integer $id
 * @property integer $form_id
 * @property string $from_type
 * @property string $to_ids
 * @property string $message
 * @property string $time_stamp
 */
class Chat extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'chat';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['form_id', 'from_type', 'to_ids', 'message'], 'required'],
            [['form_id'], 'integer'],
            [['message'], 'string'],
            [['time_stamp'], 'safe'],
            [['from_type'], 'string', 'max' => 20],
            [['to_ids'], 'string', 'max' => 100],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'form_id' => 'Form ID',
            'from_type' => 'From Type',
            'to_ids' => 'To Ids',
            'message' => 'Message',
            'time_stamp' => 'Time Stamp',
        ];
    }
}
