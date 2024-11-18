<?php

namespace app\modules\staff\controllers;

use app\modules\admin\models\Menu;
use app\modules\admin\models\MenuSearch;
use app\modules\admin\models\Restaurant;
use Yii;
use yii\filters\AccessControl;
use yii\filters\VerbFilter;
use yii\helpers\ArrayHelper;
use yii\web\Controller;
use yii\web\NotFoundHttpException;

class MenuController extends Controller
{
    /**
     * @inheritDoc
     */
    public function behaviors()
    {
        return ArrayHelper::merge(parent::behaviors(), [
            'access' => [
                'class' => AccessControl::className(),
                'rules' => [
                    [
                        'allow' => true,
                        'actions' => ['update'],
                        'roles' => ['restaurantManager'],
                        'roleParams' => function () {
                            return ['menu' => Menu::findOne(['menu_id' => Yii::$app->request->get('menu_id')])];
                        }
                    ],
                    [
                        'allow' => true,
                        'actions' => ['index','view','create'],
                        'roles' => ['restaurantManager'],
                    ],
                    [
                        'allow' => true,
                        'roles' => ['admin'],
                    ]
                ]
            ]
        ]);
    }

    /**
     * Lists all Menu models.
     *
     * @return string
     */
    public function actionIndex()
    {
        $searchModel = new MenuSearch();
        $searchModel->restaurant_id = Yii::$app->user->identity->getUserRestaurant()->restaurant_id;
        $dataProvider = $searchModel->search($this->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single Menu model.
     * @param int $menu_id Menu ID
     * @return string
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionView($menu_id)
    {
        return $this->render('view', [
            'model' => $this->findModel($menu_id),
        ]);
    }

    /**
     * Creates a new Menu model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return string|\yii\web\Response
     */
    public function actionCreate($restaurant_id = null)
    {
        $model = new Menu();
        $model->restaurant_id = Yii::$app->user->identity->getUserRestaurant()->restaurant_id;

        if (isset($restaurant_id) && is_numeric($restaurant_id)) {
            $model->restaurant_id = $restaurant_id;
        }

        if ($this->request->isPost) {
            if ($model->load($this->request->post()) && $model->save()) {
                return $this->redirect(['view', 'menu_id' => $model->menu_id]);
            }
        } else {
            $model->loadDefaultValues();
        }

        return $this->render('create', [
            'model' => $model,
        ]);
    }

    /**
     * Updates an existing Menu model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param int $menu_id Menu ID
     * @return string|\yii\web\Response
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionUpdate($menu_id)
    {
        $model = $this->findModel($menu_id);
        $model->restaurant_id = Yii::$app->user->identity->getUserRestaurant()->restaurant_id;

        if ($this->request->isPost && $model->load($this->request->post()) && $model->save()) {
            return $this->redirect(['view', 'menu_id' => $model->menu_id]);
        }

        return $this->render('update', [
            'model' => $model,
        ]);
    }

    /**
     * Finds the Menu model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param int $menu_id Menu ID
     * @return Menu the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($menu_id)
    {
        if (($model = Menu::findOne(['menu_id' => $menu_id, 'created_by' => Yii::$app->user->getId()])) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }
}