<?php

namespace common\models;
use partner\models\PartnerLogin;

use Yii;

/**
 * This is the model class for table "associate_consultants".
 *
 * @property integer $id
 * @property integer $consultant_id
 * @property integer $parent_consultant_id
 * @property string $created_at
 * @property integer $created_by
 * @property string $updated_at
 * @property integer $updated_by
 *
 * @property PartnerLogin $consultant
 * @property PartnerLogin $parentConsultant
 */
class AssociateConsultants extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'associate_consultants';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['consultant_id', 'parent_consultant_id'], 'required'],
            [['consultant_id', 'parent_consultant_id', 'created_by', 'updated_by'], 'integer'],
            [['created_at', 'updated_at'], 'safe'],
            [['consultant_id'], 'exist', 'skipOnError' => true, 'targetClass' => PartnerLogin::className(), 'targetAttribute' => ['consultant_id' => 'id']],
            [['parent_consultant_id'], 'exist', 'skipOnError' => true, 'targetClass' => PartnerLogin::className(), 'targetAttribute' => ['parent_consultant_id' => 'id']],
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
            'parent_consultant_id' => 'Parent Consultant ID',
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

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getParentConsultant()
    {
        return $this->hasOne(PartnerLogin::className(), ['id' => 'parent_consultant_id']);
    }
}
