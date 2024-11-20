<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/** @var yii\web\View $this */
/** @var \app\models\OrderForm $model */

$this->title = 'Invoice No . ' . $model->order_id;
$this->params['breadcrumbs'][] = ['label' => 'Order Detailds', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
\yii\web\YiiAsset::register($this);
?>
<div class="restaurant-view">

    <h1><?= Html::encode($this->title) ?></h1>
    <?= DetailView::widget([
        'model' => $model,
        'attributes' => [
            'order_id',
            'order_date:date',
            ['label' => 'Order Status', 'attribute' => 'order_status_id', 'value' => fn($m) => $m->getOrderStatus()->one()->name],
            ['label' => 'total_price', 'attribute' => 'total_price', 'value' => fn($model) => Yii::$app->formatter->asInteger($model->total_price)],
        ],
    ]) ?>

    <?= \yii\grid\GridView::widget([
        'dataProvider' => $model->orderItemSearch(Yii::$app->request->queryParams),
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],
            ['label' => 'Product', 'attribute' => 'product_id', 'value' => fn($m) => $m->getProduct()->one()->name],
            ['label' => 'Quantity', 'attribute' => 'quantity', 'value' => fn($m) => $m->quantity],
            ['label' => 'Price', 'attribute' => 'price', 'value' => fn($m) => $m->unit_price],
            [
                'class' => 'yii\grid\ActionColumn',
                'template' => '{delete}', // Customize to only show the delete button
                'buttons' => [
                    'delete' => function ($url, $model, $key) {
                        return Html::a('Delete', ['/order/delete', 'order_id' => $model->order_id, 'product_id' => $model->product_id], [
                            'class' => 'btn btn-danger btn-sm',
                            'data' => [
                                'confirm' => 'Are you sure you want to delete this item?',
                                'method' => 'post',
                            ],
                        ]);
                    },
                ],
            ],
        ]
    ]); ?>

</div>
