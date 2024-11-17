<?php

use yii\db\Migration;

/**
 * Class m241117_152926_add_default_roles_and_permissions
 */
class m241117_152926_add_default_roles_and_permissions extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {

        $auth = Yii::$app->authManager;

        $admin = $auth->createRole('admin');
        $customer = $auth->createRole('customer');
        $restaurantManager = $auth->createRole('restaurantManager');

        $auth->add($admin);
        $auth->add($customer);
        $auth->add($restaurantManager);

        $auth->addChild($admin, $customer);
        $auth->addChild($admin, $restaurantManager);

        $createRestaurant = $auth->createPermission('createRestaurant');
        $createRestaurant->description = 'Create a restaurant';
        $auth->add($createRestaurant);

        $updateRestaurant = $auth->createPermission('updateRestaurant');
        $updateRestaurant->description = 'Update a restaurant';
        $auth->add($updateRestaurant);

        $deleteRestaurant = $auth->createPermission('deleteRestaurant');
        $deleteRestaurant->description = 'Delete a restaurant';
        $auth->add($deleteRestaurant);

        $createMenu = $auth->createPermission('createMenu');
        $createMenu->description = 'Create a menu';
        $auth->add($createMenu);

        $updateMenu = $auth->createPermission('updateMenu');
        $updateMenu->description = 'Update a menu';
        $auth->add($updateMenu);

        $deleteMenu = $auth->createPermission('deleteMenu');
        $deleteMenu->description = 'Delete a menu';
        $auth->add($deleteMenu);

        $auth->addChild($restaurantManager,$createRestaurant);
        $auth->addChild($restaurantManager,$updateRestaurant);
        $auth->addChild($restaurantManager,$createMenu);
        $auth->addChild($restaurantManager,$updateMenu);

        $auth->addChild($admin,$deleteRestaurant);
        $auth->addChild($admin,$deleteMenu);
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $auth = Yii::$app->authManager;
        $auth->removeAll();
    }

}
