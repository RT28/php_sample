<?php

namespace common\models;

use Yii;
use yii\helpers\ArrayHelper;

/**
 * This is the model class for table "faq_category".
 *
 * @property integer $id
 * @property string $category
 */
class ChatHistory extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'chat_history';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            //[['student_id'], 'required'],
            [['student_id','partner_login_id','sender_id','message','created_at'], 'safe'],
            [['message'], 'string'],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
        ];
    }
        public static function getChatHistory() {
        $models = ChatHistory::find()->orderBy('id')->all();
        return ArrayHelper::map($models, 'id', 'message');
    }
}
