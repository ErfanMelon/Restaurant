<?php

namespace app\modules\staff;

use yii\filters\AccessControl;

/**
 * staff module definition class
 */
class Module extends \yii\base\Module
{
    public function behaviors()
    {
        return array_merge(
            parent::behaviors(),
            [
                'access' => [
                    'class' => AccessControl::class,
                    'rules' => [
                        [
                            'allow' => false,
                            'roles' => ['?'],
                        ],
                        [
                            'allow' => true,
                            'roles' => ['restaurantManager'],
                        ]
                    ]
                ]
            ]
        );
    }
    /**
     * {@inheritdoc}
     */
    public $controllerNamespace = 'app\modules\staff\controllers';

    /**
     * {@inheritdoc}
     */
    public function init()
    {
        $this->layout = 'main';
        parent::init();
        // custom initialization code goes here
    }
}
