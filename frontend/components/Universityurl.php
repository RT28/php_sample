<?php
namespace frontend\components;

use yii\web\UrlRuleInterface;
use common\models\University;

class Universityurl implements UrlRuleInterface
{

    public function createUrl($manager, $route, $params)
    {
        if ($route === 'university/view') {
            $urlparam = '';
            if (isset($params['id'])) {
                $urlparam = 'university/'.$params['id'];
            }
            if (isset($params['page'])) {
                $urlparam =  $urlparam.'?page='.$params['page'];
            }
            return $urlparam;
        }
        return false;  // this rule does not apply
    }

    public function parseRequest($manager, $request)
    {
        $route = 'university/view';
        $params = [];
        $pathInfo = $request->getPathInfo();
        //if (preg_match('%^(\w+)(/(\w+))?$%', $pathInfo, $matches))
        $parameters = explode('/', $pathInfo);
            $i=0;
            foreach ($parameters as $parameter) {
                $i++;
                if($parameter === 'view'){
                    $i=0;
                    continue;
                }
                 $parameter = str_replace("-", " ", $parameter);
                 if(University::find()->where(['name'=>$parameter])->count()){
                    $parameter = str_replace(" ", "-", $parameter);
                    $params['id'] = $parameter;  
                    return ['university/view', $params];
                 }
                 if($i==1){
                    $params['id'] = $parameter;
                 }
                 
            }
            // check $matches[1] and $matches[3] to see
            // if they match a manufacturer and a model in the database
            // If so, set $params['manufacturer'] and/or $params['model']
            // and return ['car/index', $params]
        return false; // this rule does not apply
    }
}