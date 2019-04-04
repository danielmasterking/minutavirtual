<?php

namespace app\controllers;

use app\models\Ciudad;
use app\models\CiudadZona;
use app\models\Zona;
use Yii;
use yii\filters\VerbFilter;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\AccessControl;
/**
 * ZonaController implements the CRUD actions for Zona model.
 */
class ZonaController extends Controller
{
    /**
     * @inheritdoc
     */
    public function behaviors()
    {
        return [
            'access' => [
                'class' => AccessControl::className(),
                'only'  => ['index', 'View', 'Create', 'Update', 'DeleteCiudad', 'Ciudades', 'Delete'],
                'rules' => [
                    [
                        'allow'   => true,
                        'actions' => ['index', 'View', 'Create', 'Update', 'DeleteCiudad', 'Ciudades', 'Delete'],
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

    /**
     * Lists all Zona models.
     * @return mixed
     */
    public function actionIndex()
    {
        $zonas = Zona::find()->orderBy(['nombre' => SORT_ASC])->all();

        return $this->render('index', [
            'zonas' => $zonas,

        ]);
    }

    /**
     * Displays a single Zona model.
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
     * Creates a new Zona model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new Zona();

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect('index');
        } else {
            return $this->render('create', [
                'model' => $model,
            ]);
        }
    }

    /**
     * Updates an existing Zona model.
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
            ]);
        }
    }

    public function actionDeleteCiudad($id, $codigo_dane)
    {
        $primaryConnection = Yii::$app->db;
        $primaryCommand    = $primaryConnection->createCommand("DELETE
                                                             FROM  ciudad_zona
                                                             WHERE zona_id = :zona_id
                                                             AND   ciudad_codigo_dane = :ciudad
                                                             ");

        $borrado = $primaryCommand->bindValue(':zona_id', $id)
            ->bindValue(':ciudad', $codigo_dane)
            ->execute();

        return $this->redirect(Yii::$app->request->baseUrl . '/zona/ciudades?id=' . $id);

    }

    public function actionCiudades($id)
    {

        $array_post         = Yii::$app->request->post();
        $ciudades_asignadas = CiudadZona::find()->where(['zona_id' => $id])->all();
        $zona               = $this->findModel($id);
        $asignaciones       = array_key_exists('ciudades', $array_post) ? $array_post['ciudades'] : array();

        $tamano_asignaciones = count($asignaciones);

        $index = 0;

        while ($index < $tamano_asignaciones) {

            $model = new CiudadZona();
            $model->SetAttribute('ciudad_codigo_dane', $asignaciones[$index]);
            $model->SetAttribute('zona_id', $id);
            $model->save();
            $index++;

        }

        if ($tamano_asignaciones > 0) {

            return $this->redirect('index');

        }

        $ciudades = Ciudad::find()->orderBy(['nombre' => SORT_ASC])->all();

        return $this->render('ciudades', ['zona' => $zona, 'ciudades_asignadas' => $ciudades_asignadas, 'ciudades' => $ciudades]);

    }

    /**
     * Deletes an existing Zona model.
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
     * Finds the Zona model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return Zona the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = Zona::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }
}
