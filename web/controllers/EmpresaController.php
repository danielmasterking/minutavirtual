<?php

namespace app\controllers;

use Yii;
use app\models\Empresa;
use yii\data\ActiveDataProvider;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use yii\web\UploadedFile;
use yii\filters\AccessControl;

/**
 * EmpresaController implements the CRUD actions for Empresa model.
 */
class EmpresaController extends Controller
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
     * Lists all Empresa models.
     * @return mixed
     */
    public function actionIndex()
    {
        $dataProvider = new ActiveDataProvider([
            'query' => Empresa::find(),
        ]);

        return $this->render('index', [
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single Empresa model.
     * @param string $id
     * @return mixed
     */
    public function actionView($id)
    {
        return $this->render('view', [
            'model' => $this->findModel($id),
        ]);
    }

    /**
     * Creates a new Empresa model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new Empresa();
		$empresas = Empresa::find()->orderBy(['nombre' => SORT_ASC])->all();
		Yii::$app->params['uploadPath'] = Yii::$app->basePath . '/web/uploads/';
		$shortPath = '/uploads/';	

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
			
			$image = UploadedFile::getInstance($model, 'image');
			
            if($image !== null)
            {
                date_default_timezone_set ( 'America/Bogota');
                $fecha_registro = date('Ymd',time());
                
                $model->logo = $fecha_registro.'_'.utf8_encode($image->name);
                $ext = end((explode(".", $image->name)));
                $path = Yii::$app->params['uploadPath'] . $model->logo;
                $model->logo = $shortPath. $model->logo;
				$model->save();
				$image->saveAs($path);
				
				
            }						
			
            return $this->redirect('create');
			
        } else {
            return $this->render('create', [
                'model' => $model,
				'empresa' => 'active',
				'empresas' => $empresas,
            ]);
        }
    }

    /**
     * Updates an existing Empresa model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param string $id
     * @return mixed
     */
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);
		Yii::$app->params['uploadPath'] = Yii::$app->basePath . '/web/uploads/';
		$shortPath = '/uploads/';	
		$empresas = Empresa::find()->orderBy(['nombre' => SORT_ASC])->all();

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
				
				$image = UploadedFile::getInstance($model, 'image');
				
				if($image !== null)
				{
					date_default_timezone_set ( 'America/Bogota');
					$fecha_registro = date('Ymd',time());
					
					$model->logo = $fecha_registro.'_'.utf8_encode($image->name);
					$ext = end((explode(".", $image->name)));
					$path = Yii::$app->params['uploadPath'] . $model->logo;
					$model->logo = $shortPath. $model->logo;
					$model->save();
					$image->saveAs($path);
					
					
				}						
				
				return $this->redirect('create');
			
        } else {
            return $this->render('update', [
                'model' => $model,
				'empresa' => 'active',
				'actualizar' => 's',
				'empresas' => $empresas,
            ]);
        }
    }

    /**
     * Deletes an existing Empresa model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param string $id
     * @return mixed
     */
    public function actionDelete($id)
    {
        $this->findModel($id)->delete();

        return $this->redirect(['create']);
    }

    /**
     * Finds the Empresa model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param string $id
     * @return Empresa the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = Empresa::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }
}
