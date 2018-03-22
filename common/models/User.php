<?php
namespace common\models;

use Yii;
use yii\base\NotSupportedException;
use yii\behaviors\TimestampBehavior;
use yii\db\ActiveRecord;
use yii\web\IdentityInterface;

/**
 * User model
 *
 * @property integer $id
 * @property string $username
 * @property string $password_hash
 * @property string $password_reset_token
 * @property string $email
 * @property string $auth_key
 * @property integer $status
 * @property integer $created_at
 * @property integer $updated_at
 * @property string $password write-only password
 */
class User extends ActiveRecord implements IdentityInterface
{
    const STATUS_NEW = 0;
    const STATUS_ACTIVE = 1;
    const STATUS_INACTIVE = 2;
	const STATUS_ACCESS_SENT = 3;
	const STATUS_SUBSCRIBED = 4;


    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'user_login';
    }

    /**
     * @inheritdoc
     */
    public function behaviors()
    {
        return [
            TimestampBehavior::className(),
        ];
    }
 
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['email', 'username', 'first_name', 'last_name', 'phonetype','code','phone','begin', 'auth_key', 'password_hash', 'country', 'created_at', 'updated_at', 'role_id'], 'required'],
            [['degree_preference', 'country', 'phone', 'status', 'created_by', 'updated_by', 'role_id','access_code','tmc', 'knowus'], 'integer'],
            [['created_at', 'updated_at','package_type','knowus','knowus_others','qualification','logged_status'], 'safe'],
            [['email', 'password_hash', 'password_reset_token'], 'string', 'max' => 255],
            [['username', 'first_name', 'last_name','others'], 'string', 'max' => 50],
            [['auth_key'], 'string', 'max' => 32],
            [['email'], 'unique'],	
			[['comment'], 'string'],
			[['password_hash'], 'string', 'min' => 8],
            [['password_reset_token'], 'unique'], 
            [['user_id'], 'exist', 'skipOnError' => true, 'targetClass' => Student::className(), 'targetAttribute' => ['user_id' => 'id']],
        ];
    }

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
			'access_code' => 'Access Status',
			'tmc' => 'Terms and Condition',
			'comment' => 'Comment',
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
    public static function findIdentity($id)
    {
        return static::findOne(['id' => $id]);
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
            //'status' => self::STATUS_ACTIVE,
        ]);
    }

    /**
     * Finds out if password reset token is valid
     *
     * @param string $token password reset token
     * @return boolean
     */
    public static function isPasswordResetTokenValid($token)
    {
        if (empty($token)) {
            return false;
        }

        $timestamp = (int) substr($token, strrpos($token, '_') + 1);
        $expire = Yii::$app->params['user.passwordResetTokenExpire'];
        return $timestamp + $expire >= time();
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
     * @inheritdoc
     */
    public function validateAuthKey($authKey)
    {
        return $this->getAuthKey() === $authKey;
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

    /**
     * Generates password hash from password and sets it to the model
     *
     * @param string $password
     */
    public function setPassword($password)
    {
        $this->password_hash = Yii::$app->security->generatePasswordHash($password);
    }

    /**
     * Generates "remember me" authentication key
     */
    public function generateAuthKey()
    {
        $this->auth_key = Yii::$app->security->generateRandomString();
    }

    /**
     * Generates new password reset token
     */
    public function generatePasswordResetToken()
    {
        $this->password_reset_token = Yii::$app->security->generateRandomString() . '_' . time();
    }

    /**
     * Removes password reset token
     */
    public function removePasswordResetToken()
    {
        $this->password_reset_token = null;
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getStudent()
    {
        return $this->hasOne(Student::className(), ['id' => 'user_id']);
    }
 
     public function getConsultant()
    { 
       return $this->hasOne(StudentConsultantRelation::className(), ['student_id' => 'id']); 
    }

 
     public function getConsultantdetails()
    { 
        return $this->hasMany(Consultant::className(), ['consultant_id' => 'consultant_id'])
        ->viaTable('student_consultant_relation', ['student_id' => 'id']);
    }
    
}
