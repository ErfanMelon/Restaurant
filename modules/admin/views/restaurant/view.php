<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/** @var yii\web\View $this */
/** @var \app\modules\admin\models\Restaurant $model */

$this->title = $model->name;
$this->params['breadcrumbs'][] = ['label' => 'Restaurants', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
\yii\web\YiiAsset::register($this);
?>
<div class="restaurant-view">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a('Update', ['update', 'restaurant_id' => $model->restaurant_id], ['class' => 'btn btn-primary']) ?>
        <?= Html::a('Delete', ['delete', 'restaurant_id' => $model->restaurant_id], [
            'class' => 'btn btn-danger',
            'data' => [
                'confirm' => 'Are you sure you want to delete this item?',
                'method' => 'post',
            ],
        ]) ?>
    </p>

    <?= DetailView::widget([
        'model' => $model,
        'attributes' => [
            'restaurant_id',
            'name',
            'address',
            'phone_number',
            'user_id',
        ],
    ]) ?>

</div>
