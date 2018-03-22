<?php

namespace common\components;

class Status {
	const STATUS_NEW = 0;
    const STATUS_ACTIVE = 1;   
    const STATUS_INACTIVE = 2;
    const STATUS_REVIEW = 3;
    const STATUS_COMPLETE = 4;
    const STATUS_DELETED = 10;
	const STATUS_INPROGRESS = 5;
	const STATUS_APPROVED = 6;
	const STATUS_CHNAGESREQUIRED = 7;

    public static function getStatus() {
        return [
			Status::STATUS_NEW => 'New Registration',
            Status::STATUS_ACTIVE => 'Active',
            Status::STATUS_INACTIVE => 'Inactive',            
            Status::STATUS_REVIEW => 'Review',
            Status::STATUS_COMPLETE => 'Complete',
            Status::STATUS_DELETED => 'Deleted',
			Status::STATUS_INPROGRESS => 'In Progress',
			Status::STATUS_APPROVED => 'Approved',
			Status::STATUS_CHNAGESREQUIRED => 'Changes Required',
        ];
    }

    public static function getStatusName($code) {
        $status = Status::getStatus();
        return $status[$code];
    }

    public static function getActiveInactiveStatus() {
        return [
            Status::STATUS_ACTIVE => 'Active',
            Status::STATUS_INACTIVE => 'Inactive',
        ];
    }
}

?>