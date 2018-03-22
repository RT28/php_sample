<?php

namespace frontend\models;
use yii\db\ActiveRecord;
use yii\web\IdentityInterface;

use common\models\StudentSchoolDetail;
use common\models\StudentCollegeDetail;
use common\models\StudentSubjectDetail;
use common\models\StudentEnglishLanguageProficienceyDetails;
use common\models\StudentConsultantRelation;
use common\models\StudentStandardTestDetail;
use common\models\StudentUniveristyApplication;
use common\models\Student;

use Yii;

/**
 * This is the model class for table "user_login".
 *
 * @property integer $id
 * @property string $email
 * @property string $username
 * @property string $first_name
 * @property string $last_name
 * @property string $auth_key
 * @property string $password_hash
 * @property string $password_reset_token
 * @property integer $degree_preference
 * @property string $majors_preference
 * @property string $country_preference
 * @property integer $country
 * @property string $created_at
 * @property string $updated_at
 * @property integer $created_by
 * @property integer $updated_by
 * @property integer $role_id
 *
 * @property Student $student
 * @property StudentEnglishLanguageProficienceyDetails[] $studentEnglishLanguageProficienceyDetails
 * @property StudentSchoolDetail[] $studentSchoolDetails
 * @property StudentCollegeDetail[] $studentCollegeDetails 
 * @property StudentStandardTestDetail[] $studentStandardTestDetails
 * @property StudentSubjectDetail[] $studentSubjectDetails
 * @property StudentUniversityApplication[] $studentUniversityApplications
 */
class UserLogin extends ActiveRecord implements IdentityInterface
{
    /**
     * @inheritdoc
     */
	public $agree;
	public $password; 
	public $confirm_password;
	 
    const STATUS_NEW = 0;
    const STATUS_ACTIVE = 1;
    const STATUS_INACTIVE = 2;
	const STATUS_ACCESS_SENT = 3;
	const STATUS_SUBSCRIBED = 4;
 

    public static function tableName()
    {
        return 'user_login';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    { 
        return [
            [['email', 'username', 'first_name', 'last_name', 'code','phone','begin', 'auth_key', 'password', 'country', 'created_at', 'updated_at', 'role_id','confirm_password'], 'required'],
            [['degree_preference', 'country', 'phone', 'status', 'created_by', 'updated_by', 'role_id', 'knowus'], 'integer'],
			['phone', 'number'], 
			//[['phone'], 'match', 'pattern'=>"/^(?:(?:\+?1\s*(?:[.-]\s*)?)?(?:\(\s*([2-9]1[02-9]|[2-9][02-8]1|[2-9][02-8][02-9])\s*\)|([2-9]1[02-9]|[2-9][02-8]1|[2-9][02-8][02-9]))\s*(?:[.-]\s*)?)?([2-9]1[02-9]|[2-9][02-9]1|[2-9][02-9]{2})\s*(?:[.-]\s*)?([0-9]{4})(?:\s*(?:#|x\.?|ext\.?|extension)\s*(\d+))?$/", 'message'=>'Please enter valid phone number'],
            [['phone'], 'match', 'pattern'=>"/^(\d{6})|(\d{7})|(\d{8})|(\d{9})|(\d{10})$/", 'message'=>'Please enter valid phone number'],
            //[['phone'], 'integer','max'=> 9999999999, 'message'=>'Invalid Phone Number'],
            //[['phone'], 'integer','min'=> 100000, 'message'=>'Invalid Phone Number'],
            [['created_at', 'updated_at','package_type','knowus','knowus_others','majors_preference','country_preference','qualification'], 'safe'],
            [['email', 'password', 'password_reset_token'], 'string', 'max' => 255],
            [['username', 'first_name', 'last_name','others'], 'string', 'max' => 50],
            [['first_name','last_name'],'match','pattern' => '/^[a-zA-Z\s]+$/'],
            [['auth_key'], 'string', 'max' => 32],
            [['email'], 'unique'],
 
            [['email'], 'email'],
			[['password','confirm_password'], 'string', 'min' => 8],
            [['password_reset_token'], 'unique'], 		
			['confirm_password', 'compare', 'compareAttribute'=>'password', 'skipOnEmpty' => true, 'message'=>"Password & Confirm Password do not match" ],
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
            'email' => 'Email *',
            'username' => 'Username *',
            'first_name' => 'First Name *',
            'last_name' => 'Last Name *',
            'auth_key' => 'Auth Key',
            'password_hash' => 'Password *',
            'password_reset_token' => 'Password Reset Token',
			'phone' => 'Phone Number *', 
            'degree_preference' => 'Degree Preference',
            'majors_preference' => 'Majors Preference',
            'country_preference' => 'Country Preference',
            'country' => 'Current Country *',
			'begin' => 'I want to begin',
			'qualification' => 'Qualification',
			'others' => 'Others',
			'knowus' => 'How did you come to know about GTU',
			'knowus_others' => 'Others',
            'status' => 'Status',
            'created_at' => 'Created At',
            'updated_at' => 'Updated At',
            'created_by' => 'Created By',
            'updated_by' => 'Updated By',
            'role_id' => 'Role ID',
        ];
    }

    /**
     * @inheritdoc
     */
    public static function findIdentityByAccessToken($token, $type = null)
    {
        throw new NotSupportedException('"findIdentityByAccessToken" is not implemented.');
    }

    /**
     * Finds user by username
     *
     * @param string $username
     * @return static|null
     */
    public static function findByUsername($username)
    {
        return static::findOne(['username' => $username]);
    }

    /**
     * Finds user by username
     *
     * @param string $username
     * @return static|null
     */
    public static function findByEmail($email)
    {
        return static::findOne(['email' => $email, 'status' => self::STATUS_ACTIVE]);
    }

    /**
     * Finds user by password reset token
     *
     * @param string $token password reset token
     * @return static|null
     */
    public static function findByPasswordResetToken($token)
    {
        if (!static::isPasswordResetTokenValid($token)) {
            return null;
        }

        return static::findOne([
            'password_reset_token' => $token,
            'status' => self::STATUS_ACTIVE,
        ]);
    }

    /**
     * @inheritdoc
     */
    public function getId()
    {
        return $this->getPrimaryKey();
    }

    /**
     * @inheritdoc
     */
    public function getAuthKey()
    {
        return $this->auth_key;
    }

    /**
     * Validates password
     *
     * @param string $password password to validate
     * @return boolean if password provided is valid for current user
     */
    public function validatePassword($password)
    {
        return Yii::$app->security->validatePassword($password, $this->password_hash);
    }
	 public function setPassword($password)
    {
        $this->password_hash = Yii::$app->security->generatePasswordHash($password);
    }

    /**
     * @inheritdoc
     */
    public function validateAuthKey($authKey)
    {
        return $this->getAuthKey() === $authKey;
    }

    public static function findIdentity($id)
    {
       // return static::findOne(['id' => $id, 'status' => self::STATUS_ACTIVE]);
		 return static::findOne(['id' => $id]);
    }

    public function getStudentEnglishLanguageProficienceyDetails()
    {       
       return $this->hasMany(StudentEnglishLanguageProficienceyDetails::className(), ['student_id' => 'id']);
    }

    public function getStudentSchoolDetails() 
    {
        return $this->hasMany(StudentSchoolDetail::className(), ['student_id' => 'id']);
    }

    public function getStudentCollegeDetails() 
    {
        return $this->hasMany(StudentCollegeDetail::className(), ['student_id' => 'id']);
    }

    public function getStudentConsultantRelation()
    {
        return $this->hasOne(StudentConsultantRelation::className(), ['student_id' => 'id']);
    }

    public function getStudentStandardTestDetails()
    {
        return $this->hasMany(StudentStandardTestDetail::className(), ['student_id' => 'id']);
    }

    public function getStudentSubjectDetails()
    {
        return $this->hasMany(StudentSubjectDetail::className(), ['student_id' => 'id']);
    }    

    public function getStudentUniversityApplications()
    {
        return $this->hasMany(StudentUniveristyApplication::className(), ['student_id' => 'id']);
    }

    public function getStudent()
    {
        return $this->hasOne(Student::className(), ['student_id' => 'id']);
    }
	
	
	 public static function getStatus() {
        return [ 
			UserLogin::STATUS_NEW => 'New Registration',
            UserLogin::STATUS_ACTIVE => 'Active',
            UserLogin::STATUS_INACTIVE => 'Inactive',            
            UserLogin::STATUS_ACCESS_SENT => 'Access Sent',
            UserLogin::STATUS_SUBSCRIBED => 'Subscribed', 
        ];
    }

    public static function getStatusName($code) {
        $status = UserLogin::getStatus();
        return $status[$code];
    }
}
