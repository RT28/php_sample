<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "terms_policy".
 *
 * @property integer $id
 * @property string $terms
 * @property string $policy
 */
class TermsPolicy extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'terms_policy';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['terms', 'policy'], 'required'],
            [['terms', 'policy'], 'string'],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'terms' => 'Terms',
            'policy' => 'Policy',
        ];
    }
}
