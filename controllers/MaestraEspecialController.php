<?php

namespace app\controllers;

use Yii;
use app\models\MaestraEspecial;
use yii\data\ActiveDataProvider;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use yii\filters\AccessControl;

/**
 * MaestraEspecialController implements the CRUD actions for MaestraEspecial model.
 */
class MaestraEspecialController extends Controller
{
    /**
     * @inheritdoc
     */
    public function behaviors()
    {
        return [
            'access' => [
                'class' => AccessControl::className(),
                'only'  => ['index', 'View', 'Create', 'Update', 'Delete', 'productos'],
                'rules' => [
                    [
                        'allow'   => true,
                        'actions' => ['index', 'View', 'Create', 'Update', 'Delete', 'productos'],
                        'roles'   => ['@'], //para usuarios logueados
                    ],
                ],  
            ],
            'verbs' => [
                'class' => VerbFilter::className(),
                'actions' => [
                    'delete' => ['POST'],
                ],
            ],
        ];
    }

    /**
     * Lists all MaestraEspecial models.
     * @return mixed
     */
    public function actionIndex()
    {
		$maestras = MaestraEspecial::find()->orderBy(['texto_breve' => SORT_ASC])->all();

        return $this->render('index', [
            'maestras' => $maestras,
			'maestraEspecial' => 'active', 
        ]);
    }

    /**
     * Displays a single MaestraEspecial model.
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
     * Creates a new MaestraEspecial model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new MaestraEspecial();

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect('index');
        } else {
            return $this->render('create', [
                'model' => $model,
				'maestraEspecial' => 'active', 
            ]);
        }
    }

    /**
     * Updates an existing MaestraEspecial model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     */
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect('index');
        } else {
            return $this->render('update', [
                'model' => $model,
				'maestraEspecial' => 'active', 
            ]);
        }
    }

    /**
     * Deletes an existing MaestraEspecial model.
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
     * Finds the MaestraEspecial model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return MaestraEspecial the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = MaestraEspecial::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }
    public function actionProductos(){
        $rowsPerPage=500;
        $page=0;
        if(isset($_POST['page'])) {
            if($_POST['page']!=0){
                $page = (isset($_POST['page']) ? $_POST['page'] : 1);
                $page -= 1;
                $per_page = $rowsPerPage; // Per page records
                $start = $page * $per_page;
            }else{
                $per_page = $rowsPerPage; // Per page records
                $start = $page * $per_page;
            }
        }else{
            $per_page = $rowsPerPage; // Per page records
            $start = $page * $per_page;
        }
        $productos = MaestraEspecial::find();
        $productos_aux = MaestraEspecial::find();
        $productos->where("estado='A'");
        $productos_aux->where("estado='A'");
        $count = $productos_aux->count();
        $productos2=$productos->orderBy(['texto_breve' => SORT_ASC])->limit($rowsPerPage)->offset($start)->all();
        $resultado = $this->renderPartial('_html', ['productos'=>$productos2]);
        \Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;
        return [
            'count' => $count,
            'resultado' => $resultado,
            'contprov' => count($productos2),
            'query' => $productos->createCommand()->getRawSql(),
        ];
    }
    public function actionActivarProducto($id_detalle_producto){
        $model = MaestraEspecial::findOne($id_detalle_producto);
        
        if($model != null){
            // Estado A en estado indica item aprobado
            $model->setAttribute('estado', 'A');
            $model->save();
        }
        return $this->redirect(['index']);
    }

    public function actionDesactivarProducto($id_detalle_producto){
        $model = MaestraEspecial::findOne($id_detalle_producto);
        if($model != null){
            // Estado N en estado indica item no aprobado
            $model->setAttribute('estado', 'N');
            if($model->precio==null){
                $model->setAttribute('precio', 0);
            }
            if($model->save()){
                return $this->redirect(['index']);
            }else{
                print_r($model->getErrors());exit();
            }
        }
    }
}
