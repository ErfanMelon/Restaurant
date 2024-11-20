<?php

namespace app\controllers;

use app\models\OrderForm;
use Yii;
use yii\web\MethodNotAllowedHttpException;
use yii\web\NotFoundHttpException;

class OrderController extends \yii\web\Controller
{
    // public function actionIndex()
    // {
    //     return $this->render('index');
    // }
    public function actionAddItem()
    {
        if(Yii::$app->user->isGuest) return Yii::$app->response->redirect(['site/login']);
        if (Yii::$app->request->isAjax) {
            $product_id = Yii::$app->request->post('product_id');
            $result = OrderForm::orderNewItem($product_id, 1);
            return $result ? 'Product Added to Cart' : 'Error';
        }
        throw new MethodNotAllowedHttpException();
    }

    public function actionIndex()
    {
        $searchModel = new OrderForm(['SCENARIO' => OrderForm::SCENARIO_SEARCH]);
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);
        return $this->render('index', [
            'orders' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    public function actionView($order_id)
    {
        $model = OrderForm::findOne($order_id);
        if (!$model) {
            throw new NotFoundHttpException('The order does not exist.');
        }
        return $this->render('view', [
            'model' => $model,
        ]);
    }

    public function actionDelete()
    {
        if (Yii::$app->request->isPost) {
            $product_id = Yii::$app->request->get('product_id');
            $order_id = Yii::$app->request->get('order_id');
            $result =OrderForm::removeItemFromOrder($order_id, $product_id);
            if($result){
                return $this->redirect(['view', 'order_id' => $order_id]);
            }
        }
        throw new MethodNotAllowedHttpException();
    }

    public function actionCancellOrder()
    {
        if(Yii::$app->request->isPost){
            $order_id = Yii::$app->request->get('order_id');
            OrderForm::cancellOrder($order_id);
            return $this->redirect(['order/index']);
        }
    }
}
