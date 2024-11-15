<?php

namespace app\modules\admin\models;

use Yii;
use yii\behaviors\BlameableBehavior;
use yii\behaviors\TimestampBehavior;
use yii\helpers\ArrayHelper;

/**
 * This is the model class for table "menu".
 *
 * @property int $menu_id
 * @property int $restaurant_id
 * @property string|null $title
 * @property bool|null $is_active
 * @property int|null $created_at
 * @property int|null $updated_at
 * @property int|null $created_by
 * @property int|null $updated_by
 *
 * @property User $createdBy
 * @property Restaurant $restaurant
 * @property User $updatedBy
 */
class Menu extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'menu';
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
    public function rules()
    {
        return [
            [['restaurant_id'], 'required' ,'message' => 'please enter valid restaurant '],
            [['restaurant_id', 'created_at', 'updated_at', 'created_by', 'updated_by'], 'integer'],
            [['is_active'], 'boolean'],
            [['title'], 'string', 'max' => 50],
            ['title' ,'required'],
            [['restaurant_id'], 'exist', 'skipOnError' => true, 'targetClass' => Restaurant::class, 'targetAttribute' => ['restaurant_id' => 'restaurant_id']],
            [['created_by'], 'exist', 'skipOnError' => true, 'targetClass' => User::class, 'targetAttribute' => ['created_by' => 'user_id']],
            [['updated_by'], 'exist', 'skipOnError' => true, 'targetClass' => User::class, 'targetAttribute' => ['updated_by' => 'user_id']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'menu_id' => 'Menu ID',
            'restaurant_id' => 'Restaurant ID',
            'title' => 'Title',
            'is_active' => 'Is Active',
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
     * Gets query for [[Restaurant]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getRestaurant()
    {
        return $this->hasOne(Restaurant::class, ['restaurant_id' => 'restaurant_id']);
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

    public function getRestaurants()
    {
        return ArrayHelper::map(Restaurant::find()->all(), 'restaurant_id', 'name');
    }
}
