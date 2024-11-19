<?php

namespace app\modules\admin\models;

use app\models\User;
use Yii;
use yii\behaviors\BlameableBehavior;
use yii\behaviors\TimestampBehavior;
use yii\helpers\ArrayHelper;

/**
 * This is the model class for table "product".
 *
 * @property int $product_id
 * @property int $menu_id
 * @property string $name
 * @property int $inStock
 * @property int $created_at
 * @property int $created_by
 * @property int|null $updated_at
 * @property int|null $updated_by
 * @property int $price
 *
 * @property User $createdBy
 * @property Menu $menu
 * @property User $updatedBy
 */
class Product extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'product';
    }

    public function behaviors()
    {
        return array_merge(parent::behaviors(), [
            TimestampBehavior::class,
            BlameableBehavior::class
        ]);
    }

    /**
     * {@inheritdoc}
     */
    public
    function rules()
    {
        return [
            [['menu_id', 'name'], 'required'],
            [['menu_id', 'inStock', 'created_at', 'created_by', 'updated_at', 'updated_by', 'price'], 'integer'],
            ['inStock', 'compare', 'compareValue' => 0, 'operator' => '>='],
            ['price', 'compare', 'compareValue' => 0, 'operator' => '>='],
            [['name'], 'string', 'max' => 100],
            [['created_by'], 'exist', 'skipOnError' => true, 'targetClass' => User::class, 'targetAttribute' => ['created_by' => 'user_id']],
            [['updated_by'], 'exist', 'skipOnError' => true, 'targetClass' => User::class, 'targetAttribute' => ['updated_by' => 'user_id']],
            [['menu_id'], 'exist', 'skipOnError' => true, 'targetClass' => Menu::class, 'targetAttribute' => ['menu_id' => 'menu_id']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public
    function attributeLabels()
    {
        return [
            'product_id' => 'Product ID',
            'menu_id' => 'Menu ID',
            'name' => 'Name',
            'inStock' => 'In Stock',
            'created_at' => 'Created At',
            'created_by' => 'Created By',
            'updated_at' => 'Updated At',
            'updated_by' => 'Updated By',
            'price' => 'Price',
        ];
    }

    /**
     * Gets query for [[CreatedBy]].
     *
     * @return \yii\db\ActiveQuery
     */
    public
    function getCreatedBy()
    {
        return $this->hasOne(User::class, ['user_id' => 'created_by']);
    }


    /**
     * Gets query for [[Menu]].
     *
     * @return \yii\db\ActiveQuery
     */
    public
    function getMenu()
    {
        return $this->hasOne(Menu::class, ['menu_id' => 'menu_id']);
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

    public function getMenus()
    {
        return ArrayHelper::map(Menu::find()->select(['menu_id', 'title'])->all(), 'menu_id', 'title');
    }

    public function getModifier()
    {
        return User::findOne(['user_id' => $this->updated_by])->user_name ?? '';
    }

    public function getCreator()
    {
        return User::findOne(['user_id' => $this->created_by])->user_name ?? '';
    }

    public function getCurrentUserMenu()
    {
        return ArrayHelper::map(
            Menu::findAll(['created_by' =>Yii::$app->user->id]) , 'menu_id', 'title');
    }
}