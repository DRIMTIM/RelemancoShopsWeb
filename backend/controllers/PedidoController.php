<?php

namespace backend\controllers;

use Yii;
use backend\models\Pedido;
use backend\models\ProductoPedido;
use backend\models\ProductoComercioStock;
use backend\models\BuscarPedido;
use backend\models\BuscarProducto;
use backend\models\Comercio;
use yii\data\ActiveDataProvider;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;

/**
 * PedidoController implements the CRUD actions for Pedido model.
 */
class PedidoController extends Controller
{
    public function behaviors()
    {
        return [
            'verbs' => [
                'class' => VerbFilter::className(),
                'actions' => [
                    'delete' => ['post'],
                ],
            ],
        ];
    }

    /**
     * Lists all Pedido models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new BuscarPedido();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single Pedido model.
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
     * Creates a new Pedido model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate($id)
    {
        $model = new Pedido();
        $comercio = Comercio::findOne($id);
        $model->id_comercio = $comercio->id;
        $dataProvider = new ActiveDataProvider([
            'query' => $comercio->getProductos(),
            'pagination' => [
                'pageSize' => 15,
            ],
        ]);

        return $this->render('create', [
            'model' => $model,
            'dataProvider' => $dataProvider,
            'comercio' => $comercio,
        ]);

    }

    public function actionConfirmarPedido(){

        if(Yii::$app->request->isAjax){
            \Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;

            if(isset($_POST['id_comercio'])){
                $comercio = Comercio::findOne($_POST['id_comercio']);

                if(isset($_POST['productos'])){
                    $productos = $_POST['productos'];
                    $cantidades = $_POST['cantidades'];
                    $pedido = new Pedido();
                    $pedido->id_comercio = $_POST['id_comercio'];
                    $dateSplit = explode("/", $_POST['fecha']);
                    $hoy = new \DateTime();
                    $hoySplit = $hoy->format('Y-m-d H:i:s');
                    $hoySplit2 = explode(" ", $hoySplit);
                    $date = new \DateTime($dateSplit[2] . "/" . $dateSplit[1] . "/" . $dateSplit[0] . " " . $hoySplit2[1]);
                    $pedido->fecha_realizado = $date->format('Y-m-d H:i:s');
                    $pedido->save();
                    $i = 0;

                    foreach ($productos as $producto) {
                        $prodPedido = new ProductoPedido();
                        $prodPedido->id_pedido = $pedido->id;
                        $prodPedido->id_producto = $producto;
                        $prodPedido->cantidad = $cantidades[$i];
                        $prodComStock = ProductoComercioStock::find()->where(['id_comercio' => $pedido->id_comercio, 'id_producto' => $prodPedido->id_producto])->one();
                        $prodComStock->cantidad += $cantidades[$i];
                        $prodComStock->save();
                        $prodPedido->save();
                        $i++;
                    }

                }
                $item = $_POST['productos'];
                return $item;
            }
        }

    }

    /**
     * Updates an existing Pedido model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     */
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['view', 'id' => $model->id]);
        } else {
            return $this->render('update', [
                'model' => $model,
            ]);
        }
    }

    /**
     * Deletes an existing Pedido model.
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
     * Finds the Pedido model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return Pedido the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = Pedido::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }
}
