<?php

use yii\helpers\Html;

/** @var yii\web\View $this */
/** @var \app\modules\admin\models\Restaurant $model */

$this->title = 'Create Restaurant';
$this->params['breadcrumbs'][] = ['label' => 'Restaurants', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="restaurant-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
