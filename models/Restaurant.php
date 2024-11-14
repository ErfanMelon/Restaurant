<?php

namespace app\models;

use Yii;
use yii\helpers\ArrayHelper;

/**
 * This is the model class for table "restaurant".
 *
 * @property int $restaurant_id
 * @property string $name
 * @property string $address
 * @property string $phone_number
 * @property int $user_id
 * @property int $created_at
 * @property int|null $updated_at
 *
 * @property Users $user
 */
class Restaurant extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'restaurant';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['name', 'address', 'phone_number', 'user_id'], 'required'],
            [['user_id', 'created_at', 'updated_at'], 'integer'],
            [['name'], 'string', 'max' => 150],
            [['address'], 'string', 'max' => 350],
            [['phone_number'], 'string', 'max' => 11],
            [['user_id'], 'exist', 'skipOnError' => true,
                'targetClass' => User::class,
                'targetAttribute' => ['user_id' => 'id']],
            [['user_id'],'immutableOnUpdate'],
            [['user_id'],'unique' , 'message' => 'user already owns restaurant'],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'restaurant_id' => 'Restaurant ID',
            'name' => 'Name',
            'address' => 'Address',
            'phone_number' => 'Phone Number',
            'user_id' => 'User ID',
            'created_at' => 'Created At',
            'updated_at' => 'Updated At',
        ];
    }

    /**
     * Gets query for [[User]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getUser()
    {
        return $this->hasOne(User::class, ['id' => 'user_id']);
    }

    public function getUserList()
    {
        return ArrayHelper::map(User::find()->all(), 'id', 'user_name');
    }

    public function save($runValidation = true, $attributeNames = null): bool
    {
        if ($this->getIsNewRecord()) {
            $this->created_at = time();
        } else {
            $this->updated_at = time();
        }
        return parent::save($runValidation, $attributeNames);
    }

    public function immutableOnUpdate($attribute, $params)
    {
        // Prevent `user_id` from being modified if it's already set
        if (!$this->isNewRecord && $this->isAttributeChanged('user_id')) {
            $this->addError($attribute, 'The user ID cannot be modified after creation.');
        }
    }
}
