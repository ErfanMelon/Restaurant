<?php

namespace app\Models;

use app\models\Order;
use app\models\OrderItem;
use app\models\OrderStatus;
use app\modules\admin\models\Menu;
use app\modules\admin\models\Product;
use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use yii\debug\models\search\Log;
use yii\helpers\ArrayHelper;
use yii\helpers\VarDumper;
use yii\log\Logger;
use yii\web\BadRequestHttpException;
use yii\web\NotAcceptableHttpException;
use yii\web\NotFoundHttpException;

class OrderForm extends Order
{
    public const SCENARIO_CREATE = 'CREATE';
    public const SCENARIO_INCREASE = 'INCREASE';
    public const SCENARIO_SEARCH = 'SEARCH';

    public static function cancellOrder($order_id)
    {
        $order = Order::findOne($order_id);
        if(!$order) throw new NotFoundHttpException();
        if($order->getOrderStatus()->one()->name != 'preInvoice') throw new NotAcceptableHttpException();
        $order->order_status_id = OrderStatus::findOne(['name' => 'cancelled'])->order_status_id;
        $order->save();
        return true;
    }

    public static function payOrder($order_id)
    {
        $order = Order::findOne($order_id);
        if(!$order) throw new NotFoundHttpException();
        if($order->getOrderStatus()->one()->name != 'preInvoice') throw new NotAcceptableHttpException();
        $order->order_status_id = OrderStatus::findOne(['name' => 'restaurantVerificati'])->order_status_id;
        $order->save();
        return true;
    }

    public function rules()
    {
        return [
            [['user_id', 'total_price', 'order_date', 'order_status_id'], 'required', 'on' => self::SCENARIO_CREATE],
            [['user_id', 'total_price', 'order_date', 'order_status_id'], 'integer'],
            [['description'], 'string', 'max' => 350],
            [['order_status_id'], 'exist', 'skipOnError' => true, 'targetClass' => OrderStatus::class, 'targetAttribute' => ['order_status_id' => 'order_status_id']],
            [['user_id'], 'exist', 'skipOnError' => true, 'targetClass' => User::class, 'targetAttribute' => ['user_id' => 'user_id']],
            [['order_date'], 'required', 'on' => self::SCENARIO_SEARCH],
        ];
    }

    public function scenarios()
    {
        return ArrayHelper::merge(Model::scenarios(), [
            self::SCENARIO_CREATE,
            self::SCENARIO_INCREASE,
            self::SCENARIO_SEARCH
        ]);
    }

    public static function updateOrderPrice($order)
    {
        $order->total_price = OrderItem::find()
            ->where(['order_id' => $order->order_id])
            ->sum('unit_price * quantity');

        $order->save(false);
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
        $order_item->save(false);

        self::updateOrderPrice($order);
        return true;
    }

    public function search($params)
    {
        $query = \app\models\Order::find();

        // add conditions that should always apply here

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
        ]);

        $this->load($params);

        $query->where(['user_id' => Yii::$app->user->getId()]);

        if (!$this->validate()) {
            // uncomment the following line if you do not want to return any records when validation fails
            // $query->where('0=1');
            return $dataProvider;
        }

        return $dataProvider;
    }

    public function getOrderItems()
    {
        return OrderItem::find()
            ->with('product')
            ->where(['order_id' => $this->order_id])
            ->all();
    }

    public function orderItemSearch($params)
    {
        $query = \app\models\OrderItem::find();

        // add conditions that should always apply here

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
        ]);

        $this->load($params);

        $query->where(['order_id' => $this->order_id]);

        if (!$this->validate()) {
            // uncomment the following line if you do not want to return any records when validation fails
            // $query->where('0=1');
            return $dataProvider;
        }

        return $dataProvider;
    }

    public static function removeItemFromOrder($order_id, $product_id)
    {
        $order = Order::findOne(['user_id' => Yii::$app->user->getId(), 'order_id' => $order_id]);
        if (!$order) {
            throw new BadRequestHttpException();
        }
        if ($order->getOrderStatus()->one()->name !=='preInvoice'){
            throw new BadRequestHttpException();
        }
        $order_item = OrderItem::findOne(['order_id' => $order_id, 'product_id' => $product_id]);
        if (!$order_item) {
            throw new BadRequestHttpException();
        }
        $order_item->delete();

        self::updateOrderPrice($order);

        return true;
    }
}