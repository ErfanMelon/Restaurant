<?php

namespace app\Models;

use app\models\Order;
use app\models\OrderItem;
use app\models\OrderStatus;
use app\modules\admin\models\Product;
use Yii;
use yii\web\NotFoundHttpException;

class OrderForm extends Order
{
    public const SCENARIO_CREATE = 'CREATE';
    public const SCENARIO_INCREASE = 'INCREASE';

    public function rules()
    {
        return [
            [['user_id', 'total_price', 'order_date', 'order_status_id'], 'required', 'on' => self::SCENARIO_CREATE],
            [['user_id', 'total_price', 'order_date', 'order_status_id'], 'integer'],
            [['description'], 'string', 'max' => 350],
            [['order_status_id'], 'exist', 'skipOnError' => true, 'targetClass' => OrderStatus::class, 'targetAttribute' => ['order_status_id' => 'order_status_id']],
            [['user_id'], 'exist', 'skipOnError' => true, 'targetClass' => User::class, 'targetAttribute' => ['user_id' => 'user_id']],
        ];
    }

    public function scenarios()
    {
        return [
            self::SCENARIO_CREATE,
            self::SCENARIO_INCREASE
        ];
    }

    public static function orderNewItem($product_id, $count)
    {
        $order = Order::findOne(['user_id' => Yii::$app->user->getId(),
            'order_status_id' => OrderStatus::findOne(['name' => 'preInvoice']
            )->order_status_id]);
        if (!$order) {
            $order = new Order();
            $order->user_id = Yii::$app->user->getId();
            $order->order_date = time();
            $order->total_price = 0; // temporary
            $order->order_status_id = OrderStatus::findOne(['name' => 'preInvoice'])->order_status_id;
            if (!$order->save()) {
                return false;
            }
        }
        $order_item = OrderItem::findOne(['order_id' => $order->order_id, 'product_id' => $product_id]);
        if (!$order_item) {
            $order_item = new OrderItem();
            $order_item->order_id = $order->order_id;
            $product = \app\modules\admin\models\Product::findOne(['product_id' => $product_id]);
            if (!$product) {
                throw new NotFoundHttpException();
            }
            $order_item->product_id = $product->product_id;
            $order_item->unit_price = $product->price;
            $order_item->quantity = 1;
        } else {
            $order_item->quantity++;
        }
        $order->total_price = OrderItem::find()
            ->where(['order_id' => $order->order_id])
            ->sum('unit_price * quantity');
        $order_item->save(false);
        $order->save();
        return true;
    }
}