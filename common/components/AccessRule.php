<?php

namespace common\components;

class AccessRule extends \yii\filters\AccessRule
{
	/**
	 * @inheritdoc
	 */
	protected function matchRole($user)
	{
		if(empty($this->roles)) {
			return true;
		}
		foreach ($this->roles as $role) {
			if ($role == '?') {
				if ($user->getIsGuest()) {
					return true;
				}
			} elseif ($role == '@') {
				if (!$user->getIsGuest()) {
					return true;
				}
			// check if the user is logged in, and the roles match
			} elseif(!$user->getIsGuest() && $role == $user->identity->role_id) {
				return true;
			}
		}

		return false;
	}
}

?>