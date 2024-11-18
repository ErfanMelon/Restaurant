<?php

namespace app\models;

use app\modules\admin\models\Restaurant;
use Yii;

/**
 * This is the model class for table "user".
 *
 * @property int $user_id
 * @property string $user_name
 * @property string $email
 * @property string $password
 * @property string $auth_key
 * @property string $access_token
 * @property string|null $user_status
 * @property string|null $user_type
 */
class User extends \yii\db\ActiveRecord implements \yii\web\IdentityInterface
{
    private const USER_TYPE_ADMIN = 'ADMIN';
    private const USER_TYPE_USER = 'USER';
    private const USER_TYPE_RESTAURANT = 'RESTAURANT';

    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'user';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['user_name', 'email', 'password', 'auth_key', 'access_token'], 'required'],
            [['user_status', 'user_type'], 'string'],
            [['user_name', 'email'], 'string', 'max' => 150],
            [['password', 'auth_key', 'access_token'], 'string', 'max' => 255],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'user_id' => 'User ID',
            'user_name' => 'User Name',
            'email' => 'Email',
            'password' => 'Password',
            'auth_key' => 'Auth Key',
            'access_token' => 'Access Token',
            'user_status' => 'User Status',
            'user_type' => 'User Type',
        ];
    }

    public static function findIdentity($id)
    {
        return user::findOne($id);
    }

    public static function findIdentityByAccessToken($token, $type = null)
    {
        return user::findOne(['access_token' => $token]);
    }

    public function getId()
    {
        return $this->user_id;
    }

    public function getAuthKey()
    {
        return $this->auth_key;
    }

    public function validateAuthKey($authKey)
    {
        return $this->auth_key === $authKey;
    }

    public static function getByEmail($email)
    {
        return user::findOne(['email' => $email]);
    }

    public function validatePassword($password)
    {
        return Yii::$app->security->validatePassword($password, $this->password);
    }

    public function is_admin()
    {
        return $this->user_type === self::USER_TYPE_ADMIN;
    }

    public function getUserRestaurant()
    {
        $restaurant = Restaurant::find()
        ->where(['user_id' => $this->user_id])
        ->select(['restaurant_id', 'name'])
        ->one();
        if(!$restaurant)
        {
            return [];
        }
        return $restaurant;
    }
}
