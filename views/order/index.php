<?php

/** @var yii\web\View $this */
/** @var app\models\OrderForm $searchModel */

/** @var yii\data\ActiveDataProvider $dataProvider */

use yii\grid\ActionColumn;
use yii\grid\GridView;
use yii\helpers\Html;
use yii\helpers\Url;

$this->title = 'Orders';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="restaurant-index">

    <h1><?= Html::encode($this->title) ?></h1>

    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],
            'order_date:date',
            ['label' => 'Order Status', 'attribute' => 'order_status_id', 'value' => fn($m) => $m->getOrderStatus()->one()->name],
            ['label' => 'total_price', 'attribute' => 'total_price', 'value' => fn($model) => Yii::$app->formatter->asInteger($model->total_price)],
            [
                'class' => ActionColumn::className(),
                'template' => '{view} {cancell-order} {submit-order}',
                'urlCreator' => function ($action, $model, $key, $index, $column) {
                    return Url::toRoute([$action, 'order_id' => $model->order_id]);
                },
                'buttons' => [
                    'cancell-order' => function ($url, $model, $key) {
                        return Html::a('cancell order', ['/order/cancell-order', 'order_id' => $model->order_id], [
                            'class' => 'btn btn-danger btn-sm',
                            'data' => [
                                'confirm' => 'Are you sure you want to cancell this order?',
                                'method' => 'post',
                            ],
                        ]);
                        },
                        'submit-order' =>function ($url, $model, $key) {
                            return Html::a('submit order', ['/order/pay-order', 'order_id' => $model->order_id], [
                                'class' => 'btn btn-success btn-sm',
                                'data' => [
                                    'confirm' => 'Are you sure you want to submit this order?',
                                    'method' => 'post',
                                ]
                            ]);
                        }
                        ],
                ],
            ],
        ]);
    ?>


</div>
