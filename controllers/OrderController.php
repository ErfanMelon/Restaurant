<?php

namespace app\controllers;

use app\models\OrderForm;
use Yii;

class OrderController extends \yii\web\Controller
{
    // public function actionIndex()
    // {
    //     return $this->render('index');
    // }
    public function actionAddItem()
    {
        $product_id = Yii::$app->request->get('product_id');
        $result = OrderForm::orderNewItem($product_id, 1);
        return $result === 1;
    }
}
