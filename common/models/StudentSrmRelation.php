<?php

namespace common\models;
use backend\models\EmployeeLogin;
use frontend\models\UserLogin;
use partner\models\PartnerLogin;

use Yii;

/**
 * This is the model class for table "student_srm_relation".
 *
 * @property integer $id
 * @property integer $student_id
 * @property integer $srm_id
 * @property integer $created_by
 * @property string $created_at
 * @property integer $updated_by
 * @property string $updated_at
 *
 * @property EmployeeLogin $srm
 * @property UserLogin $student
 */
class StudentSrmRelation extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'student_srm_relation';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['student_id', 'srm_id',  'comments', 'created_by', 'created_at', 'updated_by', 'updated_at'], 'required'],
            [['student_id', 'srm_id', 'created_by', 'updated_by'], 'integer'],
            [['created_at', 'updated_at'], 'safe'],
            [['srm_id'], 'exist', 'skipOnError' => true, 'targetClass' => EmployeeLogin::className(), 'targetAttribute' => ['srm_id' => 'id']],
            [['student_id'], 'exist', 'skipOnError' => true, 'targetClass' => UserLogin::className(), 'targetAttribute' => ['student_id' => 'id']],
            //[['university_id'], 'exist', 'skipOnError' => true, 'targetClass' => PartnerLogin::className(), 'targetAttribute' => ['university_id' => 'id']],
            //[['consultant_id'], 'exist', 'skipOnError' => true, 'targetClass' => PartnerLogin::className(), 'targetAttribute' => ['consultant_id' => 'id']],
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
            'srm_id' => 'Srm ID',
			'status' => 'Status',
			'comments' => 'Comments',
            'created_by' => 'Created By',
            'created_at' => 'Created At',
            'updated_by' => 'Updated By',
            'updated_at' => 'Updated At',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getEmployee()
    {
        return $this->hasOne(EmployeeLogin::className(), ['id' => 'srm_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getStudent()
    {
        return $this->hasOne(UserLogin::className(), ['id' => 'student_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
   /* public function getUniversity()
    {
        return $this->hasOne(PartnerLogin::className(), ['id' => 'university_id']);
    }*/

    /**
     * @return \yii\db\ActiveQuery
     */
   /* public function getConsultant()
    {
        return $this->hasOne(PartnerLogin::className(), ['id' => 'consultant_id']);
    }*/
}
