<?php

namespace app\controllers;

use Yii;
use app\models\Macroactividad;
use app\models\Metrica;
use app\models\MacroactividadSearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use yii\filters\AccessControl;

/**
 * MacroactividadController implements the CRUD actions for Macroactividad model.
 */
class MacroactividadController extends Controller
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
     * Lists all Macroactividad models.
     * @return mixed
     */
    public function actionIndex()
    {
        $macroactividades = Macroactividad::find()->orderBy(['nombre' => SORT_ASC])->all();

        return $this->render('index', [
            'macroactividades' => $macroactividades,
            'macroactividad' => 'active',
        ]);
    }

    /**
     * Displays a single Macroactividad model.
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
     * Creates a new Macroactividad model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new Macroactividad();
        $metricas = Metrica::find()->orderBy(['nombre' => SORT_ASC])->all();
        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect('index');
        } else {
            return $this->render('create', [
                'model' => $model,
				'metricas' => $metricas,
				'macroactividad' => 'active',
            ]);
        }
    }

    /**
     * Updates an existing Macroactividad model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     */
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);
        $metricas = Metrica::find()->orderBy(['nombre' => SORT_ASC])->all();
        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect('index');
        } else {
            return $this->render('update', [
                'model' => $model,
				'metricas' => $metricas,
				'macroactividad' => 'active',
            ]);
        }
    }

    /**
     * Deletes an existing Macroactividad model.
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
     * Finds the Macroactividad model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return Macroactividad the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = Macroactividad::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }
}
