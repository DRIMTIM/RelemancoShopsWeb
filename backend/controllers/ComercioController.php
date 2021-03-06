<?php

namespace backend\controllers;

use Yii;
use yii\filters\AccessControl;
use backend\models\Comercio;
use backend\models\Localizacion;
use backend\models\BuscarComercio;
use backend\models\BuscarProducto;
use backend\models\ProductoComercioStock;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;

/**
 * ComercioController implements the CRUD actions for Comercio model.
 */
class ComercioController extends Controller
{
    public function behaviors()
    {
        return [
            'access' => [
                'class' => AccessControl::className(),
                'rules' => [
                    [
                        'allow' => true,
                        'roles' => ['@'],
                        'matchCallback' => function () {
                           return Yii::$app->user->identity->getIsAdmin();
                        },
                    ],
                ],
            ],
            'verbs' => [
                'class' => VerbFilter::className(),
                'actions' => [
                    'delete' => ['post'],
                ],
            ],
        ];
    }

    /**
     * Lists all Comercio models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new BuscarComercio();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single Comercio model.
     * @param integer $id
     * @return mixed
     */
    public function actionView($id)
    {

        return $this->render('view', [
            'model' => $this->findModel($id),
        ]);
    }

    /**
     * Creates a new Comercio model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new Comercio();
        $localizacion = new Localizacion();

        if ($model->load(Yii::$app->request->post()) && $localizacion->load(Yii::$app->request->post())) {
            $localizacion->nota = $model->nombre;
            $localizacion->save(false);
            $model->id_localizacion = $localizacion->id;
            $model->save(false);
            return $this->redirect(['view', 'id' => $model->id]);
        }

        return $this->render('create', [
            'model' => $model,
            'localizacion' => $localizacion,
        ]);

    }

    /**
     * Updates an existing Comercio model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     */
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);
        $localizacion = Localizacion::findOne($model->id_localizacion);

        if ($model->load(Yii::$app->request->post()) && $localizacion->load(Yii::$app->request->post())) {
            $localizacion->nota = $model->nombre;
            $localizacion->save(false);
            $model->save(false);
            return $this->redirect(['view', 'id' => $model->id]);
        } else {
            return $this->render('update', [
                'model' => $model,
                'localizacion' => $localizacion,
            ]);
        }
    }

    /**
     * Deletes an existing Comercio model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param integer $id
     * @return mixed
     */
    public function actionDelete($id)
    {
        $this->findModel($id)->delete();

        return $this->redirect(['index']);
    }

    /**
     * Asigna los productos seleccionados
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @return mixed
     */
    public function actionAsignarProductos()
    {
        $searchModel = new BuscarProducto();
        $comercios = new Comercio();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('asignarProductos', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
            'comercios' => $comercios,
        ]);
    }

    public function actionGuardarProductos(){

        if(Yii::$app->request->isAjax){
            \Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;

            $item = null;

            if(isset($_POST['id_comercio'])){
                
                if(isset($_POST['productos'])){
                    $productos = $_POST['productos'];
                    foreach ($productos as $producto) {
                        $stock = ProductoComercioStock::find()->where(['id_comercio' => $_POST['id_comercio'],
                                                                       'id_producto' => $producto,
                                                                      ])->one();
                        if(empty($stock)){
                            $prodComStock = new ProductoComercioStock();
                            $prodComStock->id_comercio = $_POST['id_comercio'];
                            $prodComStock->id_producto = $producto;
                            $prodComStock->cantidad = 0;
                            $prodComStock->save();
                        }
                    }
                }
                $item = ProductoComercioStock::find()->where(['id_comercio' => $_POST['id_comercio']]);
                return $item->asArray()->all();

            }else{
                return null;
            }

        }
    }

    /**
     * Finds the Comercio model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return Comercio the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = Comercio::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }

    public function getAll(){

        return Comercio::find()->select(['nombre', 'id'])->indexBy('id')->column();

    }

    public function actionObtenerProductos(){

        if(Yii::$app->request->isAjax){
            \Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;
            if(isset($_POST['id_comercio'])){
                $id = $_POST['id_comercio'];
                $model = Comercio::findOne($id);
                if (isset($model)) {
                    return $model->getProductos()->all();
                }
            }
        }

    }

    public function actionObtenerComercios(){

        \Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;
        $comercio = Comercio::find()->with('localizacion', 'productos');
        return $comercio->asArray()->all();

    }

}
