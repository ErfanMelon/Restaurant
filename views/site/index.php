<?php

use yii\bootstrap5\Carousel;

/** @var yii\web\View $this */
/** @var app\modules\admin\models\Menu $menus */
/** @var app\modules\admin\models\Product $products */

$this->title = 'My Yii Application';
// foreach($menus as $v){
//     echo '<pre>';
//     var_dump($v->title);
//     echo '</pre>';
// }
// die();
?>
    <div class="site-index">

        <div class="jumbotron text-center bg-transparent mt-5 mb-5">
            <h1 class="display-4">See Products</h1>

            <p class="lead">Find out new products available</p>
        </div>

        <div class="body-content">
            <div class="row mb-5">
                <?=
                Carousel::widget([
                    'items' => [
                        // the item contains only the image
                        '<img src="https://h5p.org/sites/default/files/h5p/content/130336/images/file-59e4817a7fd3c.jpg"/>',
                        // equivalent to the above
                        ['content' => '<img src="https://h5p.org/sites/default/files/h5p/content/130336/images/file-59e4817d23fd2.jpeg"/>'],
                        // the item contains both the image and the caption
                        [
                            'content' => '<img src="https://h5p.org/sites/default/files/h5p/content/130336/images/file-59e481d1a23da.jpeg"/>',
                            'caption' => '<h4>This is title</h4><p>This is the caption text</p>',
                        ],
                    ]
                ]);
                ?>
                <div class="card text-center mt-3" style="width: 18rem;">
                    <div class="card-header">
                        Menus
                    </div>
                    <ul class="list-group list-group-flush">
                        <?php foreach ($menus as $menu): ?>
                            <li class="list-group-item"><?= $menu->title ?></li>
                        <?php endforeach; ?>
                    </ul>
                </div>
            </div>
            <div class="row">
                <?php foreach ($products as $product): ?>

                    <div class="col-lg-3 col-md-auto mb-3">
                        <div class="card" style="width: 18rem;">
                            <div class="card-body">
                                <h5 class="card-title"><?= $product->name ?></h5>
                                <h6 class="card-subtitle mb-2 text-body-secondary"><?= $product->getMenu()->one()->title ?></h6>
                                <p class="card-text">Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do
                                    eiusmod
                                    tempor incididunt ut labore et dolore magna aliqua.</p>
                                <a onclick="addToCart(<?= $product->product_id ?>)" class="btn btn-success">Order</a>
                            </div>
                        </div>
                    </div>
                <?php endforeach; ?>
            </div>

        </div>
    </div>
<?php $this->beginBlock('scripts'); ?>
    <script>
        function addToCart(product_id) {
            $.ajax({
                'type': 'post',
                'data' : {product_id : product_id},
                'url': `<?= \yii\helpers\Url::toRoute(['/order/add-item']) ?>`,
                'datatype': 'json',
                success: function (data) {
                    alert(data);
                }
            });
        }
    </script>
<?php $this->endBlock(); ?>