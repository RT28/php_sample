<?php

namespace partner\modules\university\models;

use Yii;

/**
 * This is the model class for table "partner_notifications".
 *
 * @property integer $id
 * @property integer $partner_id
 * @property integer $from_id
 * @property integer $from_role
 * @property string $message
 * @property string $timestamp
 * @property integer $read
 * @property string $created_at
 * @property integer $created_by
 * @property string $updated_at
 * @property integer $updated_by
 */
class PartnerNotifications extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'partner_notifications';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['partner_id', 'from_id', 'from_role', 'message', 'timestamp'], 'required'],
            [['partner_id', 'from_id', 'from_role', 'read', 'created_by', 'updated_by'], 'integer'],
            [['message'], 'string'],
            [['timestamp', 'created_at', 'updated_at'], 'safe'],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'partner_id' => 'Partner ID',
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
}
