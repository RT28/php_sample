<?php
namespace backend\models;

use yii;
use yii\base\NotSupportedException;
use yii\behaviors\TimestampBehavior;
use yii\db\ActiveRecord;
use yii\web\IdentityInterface;
use backend\models\Employee;
use common\models\StudentSrmRelation;

/**
* This is the model class for table "employee_login".
*
* @property integer $id
* @property string $username
* @property integer $role_id
* @property string $auth_key
* @property string $password_hash
* @property string $password_reset_token
* @property string $email
* @property integer $status
* @property string $created_at
* @property string $updated_at
* @property integer $created_by
* @property integer $updated_by
*
* @property Employee[] $employees
* @property StudentSrmRelation[] $studentSrmRelations
*/

class EmployeeLogin extends ActiveRecord implements IdentityInterface
{
	const STATUS_DELETED = 0;
	const STATUS_ACTIVE = 1;
    
    //public $username;
	public $password;
	//public $rememberMe = true;
	//private $_user;  

	public static function tableName()
	{
		return 'employee_login';
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
            [['username', 'password','role_id','email'], 'required'],
			['status', 'default', 'value' => self::STATUS_ACTIVE],
			['status', 'in', 'range' => [self::STATUS_ACTIVE, self::STATUS_DELETED]],
		];
	}

	public static function findIdentity($id)
	{
		return static::findOne(['id'=>$id, 'status'=> self::STATUS_ACTIVE]);
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
		return static::findOne(['username' => $username, 'status' => self::STATUS_ACTIVE]);
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
   public function getEmployee()
   {       
       return $this->hasOne(Employee::className(), ['employee_id' => 'id']);
   }

   /**
    * @return \yii\db\ActiveQuery
    */
   public function getStudentSrmRelations()
   {       
       return $this->hasMany(StudentSrmRelation::className(), ['srm_id' => 'id']);
   }
}
