<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/** @var yii\web\View $this */
/** @var app\modules\admin\models\Menu $model */

$this->title = $model->title;
$this->params['breadcrumbs'][] = ['label' => 'Menus', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
\yii\web\YiiAsset::register($this);
?>
<div class="menu-view">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a('Update', ['update', 'menu_id' => $model->menu_id], ['class' => 'btn btn-primary']) ?>
    </p>

    <?= DetailView::widget([
        'model' => $model,
        'attributes' => [
            'menu_id',
            'title',
            'is_active:boolean',
        ],
    ]) ?>

</div>
