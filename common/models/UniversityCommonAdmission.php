<?php

namespace common\models;

use Yii;
use common\models\DegreeLevel;
use common\models\University;

/**
 * This is the model class for table "university_common_admission".
 *
 * @property integer $id
 * @property integer $university_id
 * @property integer $test_id
 * @property integer $score
 */
class UniversityCommonAdmission extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'university_common_admission';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['university_id', 'degree_level_id', 'test_id', 'score'], 'required'],
            [['university_id','degree_level_id', 'test_id', 'score'], 'integer'],			
            //[['degree_level_id'], 'exist', 'skipOnError' => true, 'targetClass' => DegreeLevel::className(), 'targetAttribute' => ['degree_level_id' => 'id']],
            //[['university_id'], 'exist', 'skipOnError' => true, 'targetClass' => University::className(), 'targetAttribute' => ['university_id' => 'id']],
			[['university_id', 'degree_level_id', 'test_id'], 'unique', 'targetAttribute' => ['university_id', 'degree_level_id', 'test_id'], 'message' => 'The University, Degree Level and Standard Test has already been taken.'],
            
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'university_id' => 'University',
			'degree_level_id' => 'Degree Level',
            'test_id' => 'Standard Test List',
            'score' => 'Score',
        ];
    }
	 public function getDegreeLevel()
    {
        return $this->hasOne(DegreeLevel::className(), ['id' => 'degree_level_id']);
    }
}
