<?php

use app\modules\admin\models\Menu;
use yii\helpers\Html;
use yii\helpers\Url;
use yii\grid\ActionColumn;
use yii\grid\GridView;

/** @var yii\web\View $this */
/** @var app\modules\admin\models\MenuSearch $searchModel */
/** @var yii\data\ActiveDataProvider $dataProvider */

$this->title = 'Menus';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="menu-index">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a('Create Menu',['create'],['class' =>'btn btn-primary']) ?>
    </p>

    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <?=
    GridView::widget([
        'dataProvider' => $dataProvider,
//        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],
            ['label' => 'Menu Name', 'attribute' => 'title'],
            'is_active:boolean',
            [
                'class' => ActionColumn::className(),
                'template' => '{view} {update}',
                'urlCreator' => function ($action, Menu $model, $key, $index, $column) {
                    return Url::toRoute([$action, 'menu_id' => $model->menu_id]);
                }
            ],
        ],
    ]); ?>


</div>
