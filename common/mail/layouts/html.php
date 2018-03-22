<?php
use yii\helpers\Html;

/* @var $this \yii\web\View view component instance */
/* @var $message \yii\mail\MessageInterface the message being composed */
/* @var $content string main view render result */
?>
<?php $this->beginPage() ?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=<?= Yii::$app->charset ?>" />
    <title><?= Html::encode($this->title) ?></title>
    <?php $this->head() ?>
</head>
<body id="body-layout" style="margin:0;">
    <?php $this->beginBody() ?>
	<table width="100%" border="0" cellpadding="0" cellspacing="0" id="wrappertable" style="table-layout: fixed; font-family: arial; background-color: #fff;">
<tbody>
<tr>
<td align="center" valign="top"><table  width="100%" cellpadding="0" cellspacing="0" border="0" style="">
<tbody>
<tr>
<td width="600" align="center" valign="top"><table width="100%" cellpadding="0" cellspacing="0" border="0" style="">
<tbody>
<tr>
<td><table width="100%" cellpadding="0" cellspacing="0" border="0">
<tbody>
<tr>
<td style="padding-top: 20px;padding-bottom: 20px;line-height: 0px;text-align:center;border-bottom: 2px solid #00a4b6;"><a style="text-decoration: none; display: block; width: 170px; width: 320px;margin: 0 auto;" href="http://gotouniversity.com/" target="_blank"><img src="http://gotouniversity.com/frontend/web/email-images/logo.png" alt="" width=""></a></td>
</tr>
</tbody>
</table></td>
</tr>
<tr>
<td style="margin: 10px;" >
<br/>
 <?= $content ?>
<br/>
</td>
</tr>
</tbody>
</table></td>
</tr>
</tbody>
</table>
<table width="100%" cellpadding="0" cellspacing="0" border="0" style="border-top: 2px solid #00a4b6;margin-top: 25px;">
<tbody>
<tr>
<td align="center" valign="top"><table cellpadding="0" cellspacing="0" border="0">
<tbody>
<tr>
<td style="padding-top: 26px; line-height: 0px;"></td>
</tr>
<tr>
<td width="30" align="left" valign="top" style="line-height: 0px !important;"><a style="text-decoration: none; display: inline-block;" href="#" target="_blank"><img src="http://gotouniversity.com/frontend/web/email-images/fb-icon.png" alt="" width="38"></a></td>
<td width="30" align="left" valign="top" style="line-height: 0px !important; padding:0 0 0 10px"><a style="text-decoration: none; display: inline-block;" href="#" target="_blank"><img src="http://gotouniversity.com/frontend/web/email-images/g-icon.png" alt="" width="38"></a></td>
<td width="30" align="left" valign="top" style="line-height: 0px !important; padding:0 0 0 10px"><a style="text-decoration: none; display: inline-block;" href="#" target="_blank"><img src="http://gotouniversity.com/frontend/web/email-images/tw-icon.png" alt="" width="38"></a></td>
<td width="30" align="left" valign="top" style="line-height: 0px !important; padding:0 0 0 10px"><a style="text-decoration: none; display: inline-block;" href="#" target="_blank"><img src="http://gotouniversity.com/frontend/web/email-images/pint-icon.png" alt="" width="38"></a></td>
</tr>
<tr>
<td style="padding-top: 26px; line-height: 0px;"></td>
</tr>

</tbody>
</table></td>
</tr>
</tbody>
</table>
<table width="100%" border="0" cellspacing="0" cellpadding="0" style="background: #00a4b6;padding: 15px 0;">
<tbody>
<tr>
<td align="center" valign="top" style="padding: 0 90px; letter-spacing: .5px; font-size: 15px; line-height: 20px; font-family:Trebuchet MS, sans-serif; color:#ffffff; text-transform: uppercase;"><a href="https://www.gotouniversity.com/" target="_blank" style="color:#ffffff; text-decoration: none; margin-right: 5px;">www.gotouniversity.com</a> | <a href="mailto:info@gotouniversity.com" style="color:#ffffff; text-decoration: none; margin: 0 5px;">info@gotouniversity.com</a> | <a href="tel:+971-42428518" style="color:#ffffff; text-decoration: none; margin-left: 5px;">+971-42428518 </a></td>
</tr>
</tbody>
</table></td>
</tr>
</tbody>
</table>
   
    <?php $this->endBody() ?>
</body>
</html>
<?php $this->endPage() ?>
