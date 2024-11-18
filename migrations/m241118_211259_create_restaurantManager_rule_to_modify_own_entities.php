<?php

use yii\db\Migration;

/**
 * Class m241118_211259_create_restaurantManager_rule_to_modify_own_entities
 */
class m241118_211259_create_restaurantManager_rule_to_modify_own_entities extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $auth = Yii::$app->authManager;

        $rule = new \app\modules\admin\models\restaurantManagerRule();
        $auth->add($rule);

        $updateOwnMenu = $auth->createPermission('updateOwnMenu');
        $updateOwnMenu->description = 'Update own menu';
        $updateOwnMenu->ruleName = $rule->name;
        $auth->add($updateOwnMenu);

        $updateMenu = $auth->getPermission('updateMenu');

        $auth->addChild($updateOwnMenu, $updateMenu);

        $restaurantManager = $auth->getRole('restaurantManager');
        $auth->addChild($restaurantManager, $updateOwnMenu);
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $auth = Yii::$app->authManager;

        $rule = $auth->getRule('restaurantManager');
        $updateOwnMenu = $auth->getPermission('updateOwnMenu');
        $auth->removeChild($rule, $updateOwnMenu);
        $auth->remove($updateOwnMenu);
    }

}
