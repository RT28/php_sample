<?php

namespace common\models;

use Yii;

use yii\helpers\ArrayHelper;

/**
 * This is the model class for table "standard_tests".
 *
 * @property integer $id
 * @property integer $test_category_id
 * @property string $name
 * @property string $source
 * @property string $created_at
 * @property integer $created_by
 * @property string $updated_at
 * @property integer $updated_by
 *
 * @property TestCategory $testCategory
 */
class StandardTests extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'standard_tests';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['test_category_id', 'test_subject_id', 'name', 'source', 'created_at', 'created_by', 'updated_at', 'updated_by'], 'required'],
            [['test_category_id'], 'integer'],
            [['created_at', 'updated_at','created_by', 'updated_by'], 'safe'],
            [['name'], 'string', 'max' => 40],
            [['source'], 'string', 'max' => 60],
            [['test_category_id'], 'exist', 'skipOnError' => true, 'targetClass' => TestCategory::className(), 'targetAttribute' => ['test_category_id' => 'id']],
			[['name','test_category_id'], 'unique', 'targetAttribute' => ['name','test_category_id'], 'message' => 'The combination of Test Category, Standard Test Name has already been taken.'],
            
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'test_category_id' => 'Test Category', 
			'test_subject_id' => 'Test Subject',
            'name' => 'Name',
            'source' => 'Source',
            'created_at' => 'Created At',
            'created_by' => 'Created By',
            'updated_at' => 'Updated At',
            'updated_by' => 'Updated By',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getTestCategory()
    {
        return $this->hasOne(TestCategory::className(), ['id' => 'test_category_id']);
    }
	
	public function getTestSubject()
    {
        return $this->hasOne(TestSubject::className(), ['id' => 'test_subject_id']);
    }
	
	public function getAllStandardTests()
    {
		$tests = StandardTests::find()->orderBy('name')
                    ->all(); 
		return ArrayHelper::map($tests, 'id', 'name');
		 
    }

    public function getTestSubjectNames()
    {
        $test_subject_id = explode(',',$this->test_subject_id);
        $test_subject_names = '';
        foreach($test_subject_id as $key => $value){
            $tests = TestSubject::find()->select(['name'])->where(['id'=>$value])->asArray()->one();
            if(count($test_subject_id) > 1){
                if(end($test_subject_id) == $value){
                    $test_subject_names .= $tests['name'];
                }else{
                    $test_subject_names .= $tests['name'].',';
                }
            }else{
                $test_subject_names .= $tests['name'];
            }

        }
        return $test_subject_names;
         
    }
	
}
