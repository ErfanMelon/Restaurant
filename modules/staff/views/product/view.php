<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/** @var yii\web\View $this */
/** @var app\modules\admin\models\Product $model */

$this->title = $model->name;
$this->params['breadcrumbs'][] = ['label' => 'Products', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
\yii\web\YiiAsset::register($this);
?>
<div class="product-view">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a('Update', ['update', 'product_id' => $model->product_id], ['class' => 'btn btn-primary']) ?>
    </p>

    <?= DetailView::widget([
        'model' => $model,
        'attributes' => [
            'product_id',
            ['label' => 'Menu', 'attribute' => 'menu_id', 'value' => function ($m){return $m->getMenu()->one()->title;}],
            'name',
            'inStock',
            'price',
            ['label' => 'Created_at', 'attribute' => 'created_at', 'value' => function ($m){return Yii::$app->formatter->asRelativeTime($m->created_at);}],
            ['label' => 'Created_by', 'attribute' => 'created_by', 'value' => function ($m){return $m->getCreator();}],
            ['label' => 'Updated_at', 'attribute' => 'updated_at', 'value' => function ($m){return Yii::$app->formatter->asRelativeTime($m->updated_at);}],
            ['label' => 'Updated_by', 'attribute' => 'updated_by', 'value' => function ($m){return $m->getModifier();}],
        ],
    ]) ?>

</div>
