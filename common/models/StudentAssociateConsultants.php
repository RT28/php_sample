<?php

namespace common\models;
use frontend\models\UserLogin;
use partner\models\PartnerLogin;

use Yii;

/**
 * This is the model class for table "student_associate_consultants".
 *
 * @property integer $id
 * @property integer $student_id
 * @property integer $parent_consultant_id
 * @property integer $associate_consultant_id
 * @property integer $created_by
 * @property string $created_at
 * @property integer $updated_by
 * @property string $updated_at
 *
 * @property PartnerLogin $parentConsultant
 * @property PartnerLogin $associateConsultant
 * @property UserLogin $student
 */
class StudentAssociateConsultants extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'student_associate_consultants';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['student_id', 'parent_consultant_id', 'associate_consultant_id'], 'required'],
            [['student_id', 'parent_consultant_id', 'associate_consultant_id', 'created_by', 'updated_by'], 'integer'],
            [['created_at', 'updated_at'], 'safe'],
            [['parent_consultant_id'], 'exist', 'skipOnError' => true, 'targetClass' => PartnerLogin::className(), 'targetAttribute' => ['parent_consultant_id' => 'id']],
            [['associate_consultant_id'], 'exist', 'skipOnError' => true, 'targetClass' => PartnerLogin::className(), 'targetAttribute' => ['associate_consultant_id' => 'id']],
            [['student_id'], 'exist', 'skipOnError' => true, 'targetClass' => UserLogin::className(), 'targetAttribute' => ['student_id' => 'id']],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'student_id' => 'Student ID',
            'parent_consultant_id' => 'Parent Consultant ID',
            'associate_consultant_id' => 'Associate Consultant ID',
            'created_by' => 'Created By',
            'created_at' => 'Created At',
            'updated_by' => 'Updated By',
            'updated_at' => 'Updated At',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getParentConsultant()
    {
        return $this->hasOne(PartnerLogin::className(), ['id' => 'parent_consultant_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getAssociateConsultant()
    {
        return $this->hasOne(PartnerLogin::className(), ['id' => 'associate_consultant_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getStudent()
    {
        return $this->hasOne(UserLogin::className(), ['id' => 'student_id']);
    }
}
