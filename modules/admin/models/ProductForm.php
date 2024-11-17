<?php

namespace app\modules\admin\models;

use app\models\User;
use PhpParser\Node\Stmt\Expression;
use yii\helpers\ArrayHelper;

class ProductForm extends Product
{
    public $product_id;
    public $name;
    public $menu_id;
    public $inStock;
    public $price;
    public $price_valid_to;
    public $price_valid_from;
    public $created_by;
    public $created_at;
    public $updated_at;
    public $updated_by;

    public function __construct(Product $product)
    {
        $this->product_id = $product->product_id;
        $this->name = $product->name;
        $this->menu_id = $product->menu_id;
        $this->inStock = $product->inStock;
        $this->created_at = $product->created_at;
        $this->updated_at = $product->updated_at;
        $this->created_by = $product->created_by;
        $this->created_at = $product->created_at;
        $price = $this->getActivePrice($product->product_id)[0];
//        var_dump($price);
//        die();
        $this->price = $price['value'];
        $this->price_valid_to = $price['to_date'];
        $this->price_valid_from = $price['from_date'];
    }

    public function getActivePrice($product_id)
    {
        $price = Price::find()
            ->where(['product_id' => $this->product_id])
            ->asArray();
        $a = $price
            ->all();
        $b = $price
            ->andWhere(['=', 'to_date', ''])
            ->all();
        return ArrayHelper::merge($a, $b);
    }

    public function rules()
    {
        return [
            [['name', 'menu_id', 'inStock', 'price'], 'required'],
            ['name', 'string'],
            [['menu_id', 'price', 'inStock'], 'integer'],
            [['inStock', 'price'], 'compare', 'compareValue' => 0, 'operator' => '>='],
            [['price_valid_to', 'price_valid_from'], 'date', 'format' => 'php:Y-m-d'],
            [['name'], 'string', 'max' => 100],
        ];
    }

    public function attributeLabels()
    {
        return [
            'name' => 'Product Name',
            'menu_id' => 'Menu',
            'inStock' => 'In Stock',
            'price' => 'Price',
            'price_valid_to' => 'Valid To',
            'price_valid_from' => 'Valid From',
        ];
    }

    public function createProduct()
    {
        $product = new Product();
        $product->name = $this->name;
        $product->menu_id = $this->menu_id;
        $product->inStock = $this->inStock;

        $saveResult = $product->save();
        if (!$saveResult) {
            $this->addErrors($product->getErrors());
            return false;
        }
        $this->product_id = $product->product_id;
        $price = new Price();
        $price->product_id = $this->product_id;
        $price->value = $this->price;
        if ($this->price_valid_from) {
            $price->from_date = strtotime($this->price_valid_from);
        } else {
            $price->from_date = date('U');
        }
        if ($this->price_valid_to) {
            $price->to_date = strtotime($this->price_valid_to);
            if ($price->from_date >= $price->to_date) {
                $this->addError('price_valid_to', 'valid to must be bigger than from date');
                return false;
            }
        }

        $saveResult = $price->save();

        if (!$price->validate()) {
            $this->addError('price', $price->getErrors()[0]);
            return false;
        }
        return true;
        return $this->createPrice();
    }

    private function createPrice()
    {
//        $price = new Price();
//        $price->product_id = $this->product_id;
//        $price->value = $this->price;
//        if ($this->price_valid_from) {
//            $price->from_date = strtotime($this->price_valid_from);
//        } else {
//            $price->from_date = date('U');
//        }
//        if ($this->price_valid_to) {
//            $price->to_date = strtotime($this->price_valid_to);
//            if ($price->from_date >= $price->to_date) {
//                $this->addError('price_valid_to', 'valid to must be bigger than from date');
//                return false;
//            }
//        }
//
//        $saveResult = $price->save();
//
//        if (!$price->validate()) {
//            $this->addError('price', $price->getErrors()[0]);
//            return false;
//        }
    }

    public function getMenus()
    {
        return ArrayHelper::map(Menu::find()->select(['menu_id', 'title'])->all(), 'menu_id', 'title');
    }

    public function updateProduct()
    {
        $product = Product::findOne(['product_id' => $this->product_id]);
        if (!$product) {
            $this->addError('product_id', 'Product not found');
            return false;
        }
        $product->name = $this->name;
        $product->menu_id = $this->menu_id;
        $product->inStock = $this->inStock;
        $saveResult = $product->save();

        if (!$saveResult) {
            $this->addErrors($product->getErrors());
            return false;
        }
        $this->product_id = $product->product_id;

        $this->expirePrice();

        $price2 = new Price();
        $price2->product_id = $this->product_id;
        $price2->value = $this->price;
        if ($this->price_valid_from) {
            $price2->from_date = strtotime($this->price_valid_from);
        } else {
            $price2->from_date = date('U');
        }
        if ($this->price_valid_to) {
            $price2->to_date = strtotime($this->price_valid_to);
            if ($price2->from_date >= $price2->to_date) {
                $this->addError('price_valid_to', 'valid to must be bigger than from date');
                return false;
            }
        }

        $saveResult = $price2->save();

        if (!$price2->validate()) {
            $this->addError('price', $price2->getErrors()[0]);
            return false;
        }
        return true;
        return $this->createPrice();
    }

    private function expirePrice()
    {
        $currentdate = time();
//        $query = Price::find()
//            ->where(['product_id' => $this->product_id]);
//        $futurePrices = $query
//            ->andWhere(['=', 'to_date', null])
//            ->asArray()
//            ->all();
        echo Price::updateAll(['to_date' => $currentdate], ['and', ['product_id' => $this->product_id], ['to_date' => null]]);
//        $oldPrices = $query
//            ->andWhere(['<=', 'from_date', $currentdate])
//            ->asArray()
//            ->all();
        echo Price::updateAll(['to_date' => $currentdate], ['and', ['product_id' => $this->product_id], ['>', 'to_date', $currentdate]]);
//        $result = ArrayHelper::merge($futurePrices, $oldPrices);
    }

    public function getModifier()
    {
        return User::findOne(['user_id' => $this->updated_by])->user_name ?? '';
    }

    public function getCreator()
    {
        return User::findOne(['user_id' => $this->created_by])->user_name ?? '';
    }
}