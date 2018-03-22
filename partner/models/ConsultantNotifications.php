<?php

namespace partner\models;

use Yii;

/**
 * This is the model class for table "consultant_notifications".
 *
 * @property integer $id
 * @property integer $consultant_id
 * @property integer $from_id
 * @property integer $from_role
 * @property string $message
 * @property string $timestamp
 * @property integer $read
 * @property string $created_at
 * @property integer $created_by
 * @property string $updated_at
 * @property integer $updated_by
 *
 * @property PartnerLogin $consultant
 */
class ConsultantNotifications extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'consultant_notifications';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id', 'consultant_id', 'from_id', 'from_role', 'message', 'timestamp'], 'required'],
            [['id', 'consultant_id', 'from_id', 'from_role', 'read', 'created_by', 'updated_by'], 'integer'],
            [['message'], 'string'],
            [['timestamp', 'created_at', 'updated_at'], 'safe'],
            [['consultant_id'], 'exist', 'skipOnError' => true, 'targetClass' => PartnerLogin::className(), 'targetAttribute' => ['consultant_id' => 'id']],
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
            'from_id' => 'From ID',
            'from_role' => 'From Role',
            'message' => 'Message',
            'timestamp' => 'Timestamp',
            'read' => 'Read',
            'created_at' => 'Created At',
            'created_by' => 'Created By',
            'updated_at' => 'Updated At',
            'updated_by' => 'Updated By',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getConsultant()
    {
        return $this->hasOne(PartnerLogin::className(), ['id' => 'consultant_id']);
    }
}
