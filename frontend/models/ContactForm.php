<?php

namespace frontend\models;

use Yii;
use yii\base\Model;

/**
 * ContactForm is the model behind the contact form.
 */
class ContactForm extends Model
{
    public $name;
    public $email;
    public $subject;
    public $body;
	public $code;
    public $phone;
	
  //  public $verifyCode;


    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            // name, email, subject and body are required
            [['name', 'email','code','phone', 'subject', 'body'], 'required'],
            // email has to be a valid email address
			[['phone','code'], 'number'], 
            ['email', 'email'], 
            [['phone'], 'match', 'pattern'=>"/^(\d{6})|(\d{7})|(\d{8})|(\d{9})|(\d{10})$/", 'message'=>'Please enter valid phone number'],
            //[['phone'], 'match', 'pattern'=>"/^(?:(?:\+?1\s*(?:[.-]\s*)?)?(?:\(\s*([2-9]1[02-9]|[2-9][02-8]1|[2-9][02-8][02-9])\s*\)|([2-9]1[02-9]|[2-9][02-8]1|[2-9][02-8][02-9]))\s*(?:[.-]\s*)?)?([2-9]1[02-9]|[2-9][02-9]1|[2-9][02-9]{2})\s*(?:[.-]\s*)?([0-9]{4})(?:\s*(?:#|x\.?|ext\.?|extension)\s*(\d+))?$/", 'message'=>'Please enter valid phone number'],
            //[['phone'], 'integer','max'=> 9999999999, 'message'=>'Invalid Phone Number'],
            //[['phone'], 'integer','min'=> 100000, 'message'=>'Invalid Phone Number'],
            ['name','match','pattern' => '/^[a-zA-Z\s]+$/'],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
			'Phone' => 'Phone Number',
			'body' => 'Message',
			'code' => 'Code',
           
        ];
    }

    /**
     * Sends an email to the specified email address using the information collected by this model.
     *
     * @param string $email the target email address
     * @return boolean whether the email was sent
     */
    public function sendEmail($email)
    {
        return Yii::$app->mailer->compose()
            ->setTo($email)
            ->setFrom([$this->email => $this->name])
            ->setSubject($this->subject)
            ->setTextBody($this->body)
            ->send();
    }
}
