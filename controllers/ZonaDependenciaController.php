<?php

namespace app\controllers;

use app\models\AreaDependencia;
use app\models\ZonaDependencia;
use Yii;
use yii\filters\VerbFilter;
use yii\helpers\Json;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\AccessControl;
/**
 * ZonaDependenciaController implements the CRUD actions for ZonaDependencia model.
 */
class ZonaDependenciaController extends Controller
{
    /**
     * @inheritdoc
     */
    public function behaviors()
    {
        return [
            'access' => [
                'class' => AccessControl::className(),
                'only'  => ['Listado', 'index', 'View', 'Create', 'Update', 'Delete'],
                'rules' => [
                    [
                        'allow'   => true,
                        'actions' => ['Listado', 'index', 'View', 'Create', 'Update', 'Delete'],
                        'roles'   => ['@'], //para usuarios logueados
                    ],
                ],  
            ],
            'verbs' => [
                'class'   => VerbFilter::className(),
                'actions' => [
                    'delete' => ['POST'],
                ],
            ],
        ];
    }

    public function actionListado()
    {

        $out  = [];
        $area = '3';
        if (isset($_POST['depdrop_parents'])) {

            $parents = $_POST['depdrop_parents'];
            if ($parents != null) {

                $area = $parents[0];

                $zonas = ZonaDependencia::find()->where(['area_dependencia_id' => $area])
                    ->all();

                $data         = array();
                $defaultValue = '';

                foreach ($zonas as $key) {

                    $data[]       = array('id' => $key->id, 'name' => $key->nombre);
                    $defaultValue = $key->id;
                }

                $value = (count($data) === 0) ? ['' => ''] : $data;

                $out = $value;

                echo Json::encode(['output' => $out, 'selected' => $defaultValue]);
                return;
            }

        }

        echo Json::encode(['output' => '', 'selected' => '']);

    }

    /**
     * Lists all ZonaDependencia models.
     * @return mixed
     */
    public function actionIndex()
    {
        $zonas = ZonaDependencia::find()->orderBy(['nombre' => SORT_ASC])->all();

        return $this->render('index', [
            'zonas' => $zonas,
        ]);
    }

    /**
     * Displays a single ZonaDependencia model.
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
     * Creates a new ZonaDependencia model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new ZonaDependencia();
        $areas = AreaDependencia::find()->orderBy(['nombre' => SORT_ASC])->all();

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect('index');
        } else {
            return $this->render('create', [
                'model' => $model,
                'areas' => $areas,
            ]);
        }
    }

    /**
     * Updates an existing ZonaDependencia model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     */
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);
        $areas = AreaDependencia::find()->orderBy(['nombre' => SORT_ASC])->all();

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect('index');
        } else {
            return $this->render('update', [
                'model' => $model,
                'areas' => $areas,
            ]);
        }
    }

    /**
     * Deletes an existing ZonaDependencia model.
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
     * Finds the ZonaDependencia model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return ZonaDependencia the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = ZonaDependencia::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }
}
