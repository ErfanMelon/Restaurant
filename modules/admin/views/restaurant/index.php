<?php

use app\modules\admin\models\Restaurant;
use yii\grid\ActionColumn;
use yii\grid\GridView;
use yii\helpers\Html;
use yii\helpers\Url;

/** @var yii\web\View $this */
/** @var \app\modules\admin\models\RestaurantSearch $searchModel */
/** @var yii\data\ActiveDataProvider $dataProvider */

$this->title = 'Restaurants';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="restaurant-index">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a('Create Restaurant', ['create'], ['class' => 'btn btn-success']) ?>
    </p>

    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
//        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],
//            'restaurant_id',
            'name',
            'address',
            'phone_number',
            ['label' =>'Owner','attribute'=>'user_id' , 'value' => function($m){return $m->getUserName();}],
            ['label' =>'Created On' , 'attribute' =>'created_at' , 'value' => function($m){return Yii::$app->formatter->asRelativeTime($m->created_at);}],
//            'updated_at',
            [
                'class' => ActionColumn::className(),
                'urlCreator' => function ($action, Restaurant $model, $key, $index, $column) {
                    return Url::toRoute([$action, 'restaurant_id' => $model->restaurant_id]);
                 }
            ],
        ],
    ]); ?>


</div>
