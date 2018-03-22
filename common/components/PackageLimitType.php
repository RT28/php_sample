<?php

namespace common\components;

class PackageLimitType {
    const LIMIT_HOURS = 1;
    const LIMIT_SCHOOLS = 2;
    const LIMIT_UNIVERSITY = 3;

    public static function getPackageLimitType() {
        return [
            PackageLimitType::LIMIT_HOURS => 'Hours',
            PackageLimitType::LIMIT_SCHOOLS => 'Schools',
            PackageLimitType::LIMIT_UNIVERSITY => 'Universities'
        ];
    }

    public static function getPackageLimitTypeName($code) {
        $limit = PackageLimitType::getPackageLimitType();
        return $limit[$code];
    }
}

?>