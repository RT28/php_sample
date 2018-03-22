<?php

namespace backend\models;

use Yii;

/**
 * This is the model class for table "site_config".
 *
 * @property integer $id
 * @property string $name
 * @property string $value
 */
class SiteConfig extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'site_config';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['name', 'value'], 'required'],
            [['name', 'value'], 'string', 'max' => 255],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'name' => 'Name',
            'value' => 'Value',
        ];
    }
	
	public static function getConfigFromEmail() {
        $model = SiteConfig::findBySql('SELECT value FROM site_config WHERE name="from_email"')->one();
		if($model->value) {
			$cc = $model->value;
		}else{
			$cc = "info@gotouniversity.com";
		}
		return $cc;
    }
	
	public static function getConfigHelpEmail() {
        $model = SiteConfig::findBySql('SELECT value FROM site_config WHERE name="help_email"')->one();
		if($model->value) {
			$help = $model->value;
		}else{
			$help = "help@gotouniversity.com";
		}
		return $help;
    }
	
	public static function getConfigGeneralEmail() {
        $model = SiteConfig::findBySql('SELECT value FROM site_config WHERE name="general_email"')->one();
		if($model->value) {
			$bcc = $model->value;
		}else{
			$bcc = "general@gotouniversity.com";
		}
		return $bcc;
    }
	public static function getConfigStoreEmail() {
        $model = SiteConfig::findBySql('SELECT value FROM site_config WHERE name="store_email"')->one();
		if($model->value) {
			$cc = $model->value;
		}else{
			$cc = "info@gotouniversity.com";
		}
		return $cc;
    }
    public static function getConfigUniversityEmail() {
        $model = SiteConfig::findBySql('SELECT value FROM site_config WHERE name="university_email"')->one();
		if($model->value) {
			$cc = $model->value;
		}else{
			$cc = "university@gotouniversity.com";
		}
		return $cc;
    }
    public static function getConfigConsultantEmail() {
        $model = SiteConfig::findBySql('SELECT value FROM site_config WHERE name="consultant_email"')->one();
		if($model->value) {
			$cc = $model->value;
		}else{
			$cc = "consultant@gotouniversity.com";
		}
		return $cc;
    }
    public static function getConfigStudentEmail() {
        $model = SiteConfig::findBySql('SELECT value FROM site_config WHERE name="student_email"')->one();
		if($model->value) {
			$cc = $model->value;
		}else{
			$cc = "students@gotouniversity.com";
		}
		return $cc;
    }
	public static function getAddress() {
        $model = SiteConfig::findBySql('SELECT value FROM site_config WHERE name="address"')->one();
		if($model->value) {
			$cc = $model->value;
		}else{
			$cc = "Brighter Admissions Consultant DMCC. <br>
					1602, 1 Lake Plaza, <br>
					Jumeirah Lakes Towers, <br>
					Dubai, UAE";
		}
		return $cc;
    }
	
	public static function getPhoneNumber() {
        $model = SiteConfig::findBySql('SELECT value FROM site_config WHERE name="phone_number"')->one();
		if($model->value) {
			$cc = $model->value;
		}else{
			$cc = "+971-42428518";
		}
		return $cc;
    }
}
