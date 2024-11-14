<?php

/** @var yii\web\View $this */

$this->title = 'My Yii Application';
?>
<div class="site-index">

    <div class="jumbotron text-center bg-transparent mt-5 mb-5">
        <h1 class="display-4">Welcome To Food Market 🍽️</h1>

        <p class="lead">Where you can order delicious meals or be a restaurateur 🧑‍🍳 !</p>
    </div>

    <div class="body-content">

        <div class="row">
            <?php if( Yii::$app->user->isGuest || !Yii::$app->user->identity->getRestaurant()): ?>
                <div class="col-lg-4 mb-3">
                    <h2>🍴Open a restaurant🍴</h2>
                    <p>Get orders and deliver food 😋🚚!</p>
                    <p>
                    <?php echo \yii\helpers\Html::a('New Restaurant 🏛','/restaurant/new',['class' => 'btn btn-outline-primary']); ?>
                    </p>
                </div>
            <?php else: ?>
                <div class="col-lg-4 mb-3">
                    <h2>View your restaurant 🏛</h2>
                    <p><?php echo Yii::$app->user->identity->getRestaurant()->name.' waits for you 💖 !' ?></p>
                    <p>
                        <?php echo \yii\helpers\Html::a('Go','/restaurant/view?restaurant_id='.Yii::$app->user->identity->getRestaurant()->restaurant_id,['class' => 'btn btn-primary']); ?>
                    </p>
                </div>
            <?php endif; ?>
            <div class="col-lg-4 mb-3">
                <h2>Heading</h2>

                <p>Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut labore et
                    dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip
                    ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu
                    fugiat nulla pariatur.</p>

                <p><a class="btn btn-outline-secondary" href="https://www.yiiframework.com/forum/">Yii Forum &raquo;</a></p>
            </div>
            <div class="col-lg-4">
                <h2>Heading</h2>

                <p>Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut labore et
                    dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip
                    ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu
                    fugiat nulla pariatur.</p>

                <p><a class="btn btn-outline-secondary" href="https://www.yiiframework.com/extensions/">Yii Extensions &raquo;</a></p>
            </div>
        </div>

    </div>
</div>
