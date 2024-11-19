<?php

namespace app\controllers;

use Yii;

class OrderController extends \yii\web\Controller
{
    // public function actionIndex()
    // {
    //     return $this->render('index');
    // }
    public function addItem()
    {
        Yii::$app->request->get('product_id');
    }
}
