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
class ChatvideoNotificarion extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'chat_call_notification';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['student_id','partner_login_id','chat_student','chat_partner','role_id','call_student','call_partner'], 'safe'],
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
        public static function getNotification() {
        $models = ChatvideoNotificarion::find()->orderBy('id')->all();
        return ArrayHelper::map($models, 'id');
    }
}
