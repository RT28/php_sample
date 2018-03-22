<?php
namespace frontend\models;

use yii\base\Model;
use common\models\User;

/**
 * Signup form
 */
class TncForm extends Model
{
    public $agree; 


    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [ 
            ['agree', 'required', 'requiredValue' => 1, 'message' => 'You should accept term to use our service']
			
        ];
    }

    /**
     * Signs user up.
     *
     * @return User|null the saved model or null if saving fails
     */
    public function signup()
    {
        if (!$this->validate()) {
            return null;
        }
        
        $user = new User();
        $user->username = $this->username;
        $user->email = $this->email;
        $user->setPassword($this->password);
        $user->generateAuthKey();
        
        return $user->save() ? $user : null;
    }
}
