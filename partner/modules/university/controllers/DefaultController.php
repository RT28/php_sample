<?php

namespace partner\modules\university\controllers;

use yii\web\Controller;
use yii\filters\AccessControl;
use common\components\Roles;
use common\components\AccessRule;

/**
 * Default controller for the `university` module
 */
class DefaultController extends Controller
{
    /**
     * Renders the index view for the module
     * @return string
     */
    public function actionIndex()
    {
        return $this->render('index');
    }
}
