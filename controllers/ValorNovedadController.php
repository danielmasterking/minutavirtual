<?php

namespace app\controllers;

use Yii;
use app\models\NovedadCategoriaVisita;
use app\models\Resultado;
use app\models\ValorNovedad;
use yii\data\ActiveDataProvider;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use yii\filters\AccessControl;
/**
 * ValorNovedadController implements the CRUD actions for ValorNovedad model.
 */
class ValorNovedadController extends Controller
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
     * Lists all ValorNovedad models.
     * @return mixed
     */
    public function actionIndex()
    {
        $novedades = ValorNovedad::find()->all();

        return $this->render('index', [
            'novedades' => $novedades,
        ]);
    }

    /**
     * Displays a single ValorNovedad model.
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
     * Creates a new ValorNovedad model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new ValorNovedad();
		$novedades = NovedadCategoriaVisita::find()->orderBy(['nombre' => SORT_ASC])->all();
        $resultados = Resultado::find()->orderBy(['nombre' => SORT_ASC])->all();
        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect('index');
        } else {
            return $this->render('create', [
                'model' => $model,
				'novedades' => $novedades,
				'resultados' => $resultados,
            ]);
        }
    }

    /**
     * Updates an existing ValorNovedad model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     */
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);
		$novedades = NovedadCategoriaVisita::find()->orderBy(['nombre' => SORT_ASC])->all();
        $resultados = Resultado::find()->orderBy(['nombre' => SORT_ASC])->all();

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect('index');
        } else {
            return $this->render('update', [
                'model' => $model,
				'novedades' => $novedades,
				'resultados' => $resultados,
            ]);
        }
    }

    /**
     * Deletes an existing ValorNovedad model.
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
     * Finds the ValorNovedad model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return ValorNovedad the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = ValorNovedad::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }
}
