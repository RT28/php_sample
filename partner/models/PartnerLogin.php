<?php
namespace partner\models;

use yii;
use yii\base\NotSupportedException;
use yii\behaviors\TimestampBehavior;
use yii\db\ActiveRecord;
use yii\web\IdentityInterface;
use partner\models\Partner;
use common\components\Status;
use common\models\Consultant;
use common\models\SRM;
use common\models\Agency;
use common\models\University;
use common\models\PartnerEmployee;
/**
* This is the model class for table "partner_login".
*
* @property integer $id
* @property string $username
* @property string $auth_key
* @property string $password_hash
* @property string $password_reset_token
* @property string $email
* @property integer $status
* @property string $created_at
* @property string $updated_at
* @property integer $created_by
* @property integer $updated_by
* @property integer $role_id
*
* @property Consultant[] $consultants
* @property ConsultantCalendar[] $consultantCalendars
* @property ConsultantNotifications[] $consultantNotifications
* @property Partner[] $partners
* @property StudentConsultantRelation[] $studentConsultantRelations
* @property StudentUniveristyApplication[] $studentUniveristyApplications
* @property UniversityNotifications[] $universityNotifications
*/

class PartnerLogin extends ActiveRecord implements IdentityInterface
{
    /**
     * @inheritdoc
     */
	 
	 public $agree;
	 public $confirm_password; 
	 
	const STATUS_NEW = 0;
    const STATUS_ACTIVE = 1;
    const STATUS_INACTIVE = 2;
	const STATUS_ACCESS_SENT = 3;
	const STATUS_SUBSCRIBED = 4;
	 
    public static function tableName()
    {
        return 'partner_login';
    }

    public function behaviors()
    {
        return [
            TimestampBehavior::className()
        ];
    }

    public function rules()
    {
        return [
            [['username', 'email', 'agree',  'created_at', 'updated_at'], 'required'],
            [['status', 'created_by', 'updated_by', 'role_id'], 'integer'],
            [['status','password_hash', 'role_id','created_at', 'updated_at'], 'safe'],
            [['username',   'email'], 'string', 'max' => 255],
			[['username','email'], 'unique'],
			['agree', 'required', 'requiredValue' => 1, 'message' => 'You should accept term to use our service']
			
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'username' => 'Username',
            'auth_key' => 'Authorization Key',
            'password_hash' => 'Password',
            'password_reset_token' => 'Password Reset Token',
            'email' => 'Email',
            'status' => 'Status',
			'agree' => 'Terms and Conditions',
            'created_at' => 'Created At',
            'updated_at' => 'Updated At',
            'created_by' => 'Created By',
            'updated_by' => 'Updated By',
            'role_id' => 'Role ID',
        ];
    }

	public static function findIdentity($id)
	{
		return static::findOne(['id'=>$id, 'status'=> STATUS::STATUS_ACTIVE]);
	}

    /**
     * @inheritdoc
     */
    public static function findIdentityByAccessToken($token, $type = null)
    {
        throw new NotSupportedException('"findIdentityByAccessToken" is not implemented.');
    }

	public static function findByUsername($username)
	{
		return static::findOne(['username' => $username, 'status' => Status::STATUS_ACTIVE]);
	}

 	public function getId()
    {
        return $this->getPrimaryKey();
    }

    public function getAuthKey()
    {
        return $this->auth_key;
    }

    public function validateAuthKey($authKey)
    {
        return $this->getAuthKey() === $authKey;
    }

    public function validatePassword($password)
    {
        return Yii::$app->security->validatePassword($password, $this->password_hash);
    }

    public function setPassword($password)
    {
        $this->password_hash = Yii::$app->security->generatePasswordHash($password);
    }

    public function generateAuthKey()
    {
        $this->auth_key = Yii::$app->security->generateRandomString();
    }

    public function generatePasswordResetToken()
    {
        $this->password_reset_token = Yii::$app->security->generateRandomString() . '_' . time();
    }

    public function removePasswordResetToken()
    {
        $this->password_reset_token = null;
    }

    /**
    * @return \yii\db\ActiveQuery
    */
    public function getUniversity()
    {        
        return $this->hasOne(University::className(), ['id' => 'partner_id']);
    }

    /**
    * @return \yii\db\ActiveQuery
    */
    public function getConsultant()
    {        
        return $this->hasOne(Consultant::className(), ['consultant_id' => 'id']);
    }
	 /**
    * @return \yii\db\ActiveQuery
    */
    public function getEmployee()
    {        
        return $this->hasOne(PartnerEmployee::className(), ['partner_login_id' => 'id']);
    }
	
	 /**
    * @return \yii\db\ActiveQuery
    */
    public function getTrainer()
    {        
        return $this->hasOne(PartnerEmployee::className(), ['partner_login_id' => 'id']);
    }
	
	public function getSrm()
    {        
        return $this->hasOne(SRM::className(), ['srm_id' => 'id']);
    }
	
	public function getAgency()
    {        
        return $this->hasOne(Agency::className(), ['partner_login_id' => 'id']);
    }
}
