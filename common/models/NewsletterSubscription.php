<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "newsletter_subscription".
 *
 * @property integer $id
 * @property string $email
 * @property string $source
 * @property string $created_at
 */
class NewsletterSubscription extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'newsletter_subscription';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['email', 'source'], 'required'],
            [['created_at'], 'safe'],
            [['email', 'source'], 'string', 'max' => 50],
            [['email'], 'unique'],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'email' => 'Email',
            'source' => 'Source',
            'created_at' => 'Created At',
        ];
    }
}
