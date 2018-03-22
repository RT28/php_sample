<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "partner_assignedwork_history".
 *
 * @property integer $id
 * @property integer $consultant_id
 * @property integer $parent_employee_id
 * @property integer $assignedwork_id
 * @property integer $status
 * @property string $comments
 * @property string $created_at
 * @property string $created_by
 *
 * @property Consultant $consultant
 * @property StudentPartneremployeeRelation $assignedwork
 * @property PartnerEmployee $parentEmployee
 */
class PartnerAssignedworkHistory extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'partner_assignedwork_history';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['consultant_id', 'parent_employee_id', 'assignedwork_id', 'status', 'comments', 'created_at', 'created_by'], 'required'],
            [['consultant_id', 'parent_employee_id', 'assignedwork_id', 'status'], 'integer'],
            [['comments'], 'string'],
            [['created_at'], 'safe'],
            [['created_by'], 'string', 'max' => 50],
            [['consultant_id'], 'exist', 'skipOnError' => true, 'targetClass' => Consultant::className(), 'targetAttribute' => ['consultant_id' => 'consultant_id']],
            [['assignedwork_id'], 'exist', 'skipOnError' => true, 'targetClass' => StudentPartneremployeeRelation::className(), 'targetAttribute' => ['assignedwork_id' => 'id']],
            [['parent_employee_id'], 'exist', 'skipOnError' => true, 'targetClass' => PartnerEmployee::className(), 'targetAttribute' => ['parent_employee_id' => 'partner_login_id']],
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
            'parent_employee_id' => 'Parent Employee ID',
            'assignedwork_id' => 'Assignedwork ID',
            'status' => 'Status',
            'comments' => 'Comments',
            'created_at' => 'Created At',
            'created_by' => 'Created By',
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
    public function getAssignedwork()
    {
        return $this->hasOne(StudentPartneremployeeRelation::className(), ['id' => 'assignedwork_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getParentEmployee()
    {
        return $this->hasOne(PartnerEmployee::className(), ['partner_login_id' => 'parent_employee_id']);
    }
}
