<?php

use yii\helpers\Html;

/** @var yii\web\View $this */
/** @var app\models\Restaurant $model */

$this->title = 'Update Restaurant: ' . $model->name;
$this->params['breadcrumbs'][] = ['label' => 'Restaurants', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->name, 'url' => ['view', 'restaurant_id' => $model->restaurant_id]];
$this->params['breadcrumbs'][] = 'Update';
?>
<div class="restaurant-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
