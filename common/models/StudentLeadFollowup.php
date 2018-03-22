<?php

namespace common\models;
use frontend\models\UserLogin;

use Yii;

/**
 * This is the model class for table "student_favourite_universities".
 *
 * @property integer $id
 * @property integer $student_id
 * @property integer $university_id
 * @property integer $favourite
 * @property integer $created_by
 * @property string $created_at
 * @property integer $updated_by
 * @property string $updated_at
 *
 * @property UserLogin $student
 * @property University $university
 */
class StudentLeadFollowup extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'lead_followup';
    }

    /**
     * @inheritdoc
     */
   /* public function rules()
    {
        return [
            [['student_id', 'university_id', 'created_by', 'created_at', 'updated_by', 'updated_at'], 'required'],
            [['student_id', 'university_id', 'favourite', ], 'integer'],
            [['created_at', 'updated_at','created_by', 'updated_by'], 'safe'],
            [['student_id'], 'exist', 'skipOnError' => true, 'targetClass' => UserLogin::className(), 'targetAttribute' => ['student_id' => 'id']],
            [['university_id'], 'exist', 'skipOnError' => true, 'targetClass' => University::className(), 'targetAttribute' => ['university_id' => 'id']],
        ];
    }*/

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'id',
            'consultant_id' => 'consultant_id',
            'created_by' => 'created_by',
            'created_at' => 'created_at',
            'status' => 'status',
            'next_followup' => 'next_followup',
            'comment' => 'comment',
            'reason_code' => 'reason_code',
        ];
    }
    public function getlastfollowup($id)
    { 
        $cmts = StudentLeadFollowup::find()
                    ->where(['student_id' => $id])
                    ->orderBy(['id' => SORT_DESC])
                    ->limit('1')
                    ->all();
                    
        return $cmts;
    }
    public function gettodayfollowup($id)
    { 
        $cmts = StudentLeadFollowup::find()
                    ->where(['student_id' => $id])
                    ->andWhere(['like','next_followup',date("Y-m-d")])
                    ->orderBy(['id' => SORT_DESC])
                    ->limit('1')
                    ->all();
                    
        return $cmts;
    }

    

    /**
     * @return \yii\db\ActiveQuery
     */
    
}
