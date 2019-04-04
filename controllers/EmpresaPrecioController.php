<?php

namespace app\controllers;

use Yii;
use app\models\EmpresaPrecio;
use app\models\TipoAlarma;
use app\models\Empresa;
use yii\data\ActiveDataProvider;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use yii\filters\AccessControl;

/**
 * EmpresaPrecioController implements the CRUD actions for EmpresaPrecio model.
 */
class EmpresaPrecioController extends Controller
{
    /**
     * @inheritdoc
     */
    public function behaviors()
    {
        return [
            'access' => [
                'class' => AccessControl::className(),
                'only'  => ['index', 'View', 'Create', 'Update', 'Delete'],
                'rules' => [
                    [
                        'allow'   => true,
                        'actions' => ['index', 'View', 'Create', 'Update', 'Delete'],
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
     * Lists all EmpresaPrecio models.
     * @return mixed
     */
    public function actionIndex()
    {
        $dataProvider = new ActiveDataProvider([
            'query' => EmpresaPrecio::find(),
        ]);

        return $this->render('index', [
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single EmpresaPrecio model.
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
     * Creates a new EmpresaPrecio model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new EmpresaPrecio();
		$alarmas = TipoAlarma::find()->orderBy(['nombre' => SORT_ASC])->all();
		$empresas = Empresa::find()->all();
        $precios = EmpresaPrecio::find()->all();		

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect('create');
        } else {
            return $this->render('create', [
                'model' => $model,
				'empresa' => 'active',
				'alarmas' => $alarmas,
				'empresas' => $empresas,
				'precios' => $precios,
            ]);
        }
    }

    /**
     * Updates an existing EmpresaPrecio model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     */
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);
		$alarmas = TipoAlarma::find()->orderBy(['nombre' => SORT_ASC])->all();
		$empresas = Empresa::find()->all();	
        $precios = EmpresaPrecio::find()->all();		

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect('create');
        } else {
            return $this->render('update', [
                'model' => $model,
				'empresa' => 'active',
				'alarmas' => $alarmas,
				'empresas' => $empresas,
                'precios' => $precios,
				
            ]);
        }
    }

    /**
     * Deletes an existing EmpresaPrecio model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param integer $id
     * @return mixed
     */
    public function actionDelete($id)
    {
        $this->findModel($id)->delete();

        return $this->redirect(['create']);
    }

    /**
     * Finds the EmpresaPrecio model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return EmpresaPrecio the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = EmpresaPrecio::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }
}
