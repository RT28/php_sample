<?php
namespace partner\models;
use yii;
use yii\base\Model;
use partner\models\PartnerLogin;

class PartnerSignup extends Model 
{
	public $username;
	public $password;
	public $confirm_password;
	public $agree;	
	private $_user;

	public function rules() 
	{
	return [
	
	[['username', 'password','confirm_password','agree'], 'required'], 
	
	[['password','confirm_password'], 'string',  'min' => 6, 'max' => 50],  
	['confirm_password', 'compare', 'compareAttribute'=>'password', 'message'=>"Password & Confirm Password do not match" ],  
	[['username'], 'unique', 'targetAttribute' => 'username', 
	'targetClass' => '\partner\models\PartnerLogin', 
	'message' => 'This username can not be taken because this username already exist as our partner.',
	'when' => function ($model) {
	return $model->username != PartnerLogin::findByUsername($model->username);  
	}],

	[['agree'], 'required', 'requiredValue' => 1, 'message' => 'You should accept term to use our service']
	];
	}

	public function validatePassword($attribute, $params)
	{
		if (!$this->hasErrors()) {
			$user = $this->getUser();
			if (!$user || !$user->validatePassword($this->password)) {
				$this->addError($attribute, 'Incorrect username or password');
			}
		}
	}

	public function login() {
		
		if ($this->validate()) {
			
			
			return Yii::$app->user->login($this->getUser(), $this->rememberMe ? 3600 * 24 * 30 : 0);
		} else {
			return false;
		}
	}

	protected function getUser() {
		if ($this->_user === null) {
			$this->_user = PartnerLogin::findByUsername($this->username);
		}
		return $this->_user;
	}
}