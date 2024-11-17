<?php

namespace app\modules\admin\models;

use app\models\User;
use Seld\PharUtils\Timestamps;
use Yii;
use yii\behaviors\BlameableBehavior;

/**
 * This is the model class for table "price".
 *
 * @property int $price_id
 * @property int $product_id
 * @property int $value
 * @property int $from_date
 * @property int|null $to_date
 * @property int|null $created_at
 * @property int|null $updated_at
 * @property int|null $created_by
 * @property int|null $updated_by
 *
 * @property User $createdBy
 * @property Product $product
 * @property User $updatedBy
 */
class Price extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'price';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['product_id', 'value', 'from_date'], 'required'],
            [['product_id', 'value', 'from_date', 'to_date', 'created_at', 'updated_at', 'created_by', 'updated_by'], 'integer'],
            [['created_by'], 'exist', 'skipOnError' => true, 'targetClass' => User::class, 'targetAttribute' => ['created_by' => 'user_id']],
            [['updated_by'], 'exist', 'skipOnError' => true, 'targetClass' => User::class, 'targetAttribute' => ['updated_by' => 'user_id']],
            [['product_id'], 'exist', 'skipOnError' => true, 'targetClass' => Product::class, 'targetAttribute' => ['product_id' => 'product_id']],
        ];
    }

    public function behaviors()
    {

        return [
            Timestamps::class,
            BlameableBehavior::class
        ];
}
    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'price_id' => 'Price ID',
            'product_id' => 'Product ID',
            'value' => 'Value',
            'from_date' => 'From Date',
            'to_date' => 'To Date',
            'created_at' => 'Created At',
            'updated_at' => 'Updated At',
            'created_by' => 'Created By',
            'updated_by' => 'Updated By',
        ];
    }

    /**
     * Gets query for [[CreatedBy]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getCreatedBy()
    {
        return $this->hasOne(User::class, ['user_id' => 'created_by']);
    }

    /**
     * Gets query for [[Product]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getProduct()
    {
        return $this->hasOne(Product::class, ['product_id' => 'product_id']);
    }

    /**
     * Gets query for [[UpdatedBy]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getUpdatedBy()
    {
        return $this->hasOne(User::class, ['user_id' => 'updated_by']);
    }
}
