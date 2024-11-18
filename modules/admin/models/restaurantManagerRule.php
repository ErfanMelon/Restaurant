<?php

namespace app\modules\admin\models;

use yii\rbac\Rule;

class restaurantManagerRule extends Rule
{
    public $name = 'isRestaurantManager';
    public function execute($user, $item, $params)
    {
        return isset($params['menu']) ? $params['menu']->created_By == $user : false;
    }
}