<?php

namespace app\controllers;

use Yii;
use yii\filters\AccessControl;
use yii\web\Controller;
use yii\filters\VerbFilter;
use app\models\LoginForm;
use app\models\ContactForm;
use app\models\CentroCosto;
use app\models\Usuario;
use app\models\RolUsuario;
use app\models\PermisoRol;

class SiteController extends Controller
{
    public function behaviors()
    {
        return [
            'access' => [
                'class' => AccessControl::className(),
                'only' => ['logout','contact','index','cambio','inicio','about','login'],
                'rules' => [
                    [
                        'allow' => true,
                        'actions' => ['logout','contact','index','cambio','inicio','about'],
                        'roles' => ['@'],//para usuarios logueados
                    ],
                    [
                        'allow' => true,
                        'actions' => ['login'],
                        'roles' => ['?'],//para usuarios sin loguear
                    ],
                ],
            ],
            'verbs' => [
                'class' => VerbFilter::className(),
                'actions' => [
                    'logout' => ['get'],
                ],
            ],
        ];
    }
    public function actions()
    {
        return [
            'error' => [
                'class' => 'yii\web\ErrorAction',
            ],
            'captcha' => [
                'class' => 'yii\captcha\CaptchaAction',
                'fixedVerifyCode' => YII_ENV_TEST ? 'testme' : null,
            ],
        ];
    }

    public function actionIndex()
    {
       
   	    if (!\Yii::$app->user->isGuest) {
            return $this->goHome();
        }
		
		$model = new LoginForm();
        
		if ($model->load(Yii::$app->request->post()) && $model->login()) {
			
			 $usuario = Yii::$app->user->identity->usuario;
			 
			 $modelUsuario = Usuario::find()->where(['usuario' => $usuario])->one();
			 
			 $roles = $modelUsuario->roles;
             $rolesArray = array();	         
			 
			 foreach($roles as $rol){
				 
				 $rolesArray [] = strtolower($rol->rol->nombre);
   				 
			 }
			 Yii::$app->session->setTimeout(5400);//5400
			 Yii::$app->session['usuario-exito'] = $usuario;
			 Yii::$app->session['rol-exito'] = $rolesArray;
			 Yii::$app->session['permisos-exito'] = $this->allowed($usuario);
			 
			 $roles = Yii::$app->session['rol-exito'];

			$this->redirect(['centro-costo/index']);

		
		}else{
			
            return $this->render('login', [
                'model' => $model,
            ]);			
			
		}
    }
	
	public function actionCambio(){


         if(isset( Yii::$app->session['usuario-exito'] )){


            $array_post = Yii::$app->request->post();


            $nueva_clave = isset($array_post['clave']) ? $array_post['clave'] : 'X';

            $confirmacion_clave = isset($array_post['confirmacion_clave']) ? $array_post['confirmacion_clave'] : 'Y';

            $model = null;

            if($confirmacion_clave == $nueva_clave){


                $usuario = Usuario::find()->where(['usuario' => Yii::$app->session['usuario-exito'] ])->one();

                $model = $usuario;

                $model->SetAttribute('password',$nueva_clave);

                $model->save();


            }


            return $this->render('cambio',[

                        'model' => $model,
                        'post' =>  $array_post,

                ]);


         }
    }
	
	public function actionInicio(){
	    $usuario = Usuario::findOne(Yii::$app->session['usuario-exito']);
		$zonasUsuario = null;
		$marcasUsuario = null;
		$distritosUsuario = null;
		
		if($usuario != null){
		  
          $zonasUsuario = $usuario->zonas;		
          $marcasUsuario = $usuario->marcas;
          $distritosUsuario = $usuario->distritos;		  
			
		}
		
		//Establecer Layout
		
		$puestos = CentroCosto::find()->where(['estado' => 'A'])->all();
		return $this->render('inicio',
		
		 ['puestos' => $puestos,
          'zonasUsuario' => $zonasUsuario,
		  'marcasUsuario' => $marcasUsuario,
		  'distritosUsuario' => $distritosUsuario,]);
		
	}
	
    public function actionLogin()
    {		
		$model = new LoginForm();
        
		if ($model->load(Yii::$app->request->post()) && $model->login()) {
			$session = Yii::$app->session;
            // open a session
            $session->open();
			 $usuario = Yii::$app->user->identity->usuario;
			 
			 $modelUsuario = Usuario::find()->where(['usuario' => $usuario])->one();
			 
			 $roles = $modelUsuario->roles;
             $rolesArray = array();	         
			 
			 foreach($roles as $rol){
				 
				 $rolesArray [] = strtolower($rol->rol->nombre);
   				 
			 }
			 Yii::$app->session->setTimeout(5400);//5400
			 Yii::$app->session['usuario-exito'] = $usuario;
			 Yii::$app->session['rol-exito'] = $rolesArray;		
             Yii::$app->session['permisos-exito'] = $this->allowed($usuario);			 
			 
			 //Validar rol para determinar donde redirigir TODO
			 //$this->redirect('inicio');
			 $this->redirect(['centro-costo/index']);
			 
		
		}else{
			
            return $this->render('login', [
                'model' => $model,
            ]);			
			
		}
    }

    public function actionLogout()
    {
        Yii::$app->session->remove('usuario-exito');
		
		Yii::$app->session->remove('rol-exito');

        // close a session
        Yii::$app->session->close();

        Yii::$app->session->destroy();

        Yii::$app->user->logout();

        return $this->redirect('index');
    }

    public function actionContact()
    {
        $model = new ContactForm();
        if ($model->load(Yii::$app->request->post()) && $model->contact(Yii::$app->params['adminEmail'])) {
            Yii::$app->session->setFlash('contactFormSubmitted');

            return $this->refresh();
        }
        return $this->render('contact', [
            'model' => $model,
        ]);
    }

    public function actionAbout()
    {
        return $this->render('about');
    }
	
    public function allowed($usuario){
        
		Yii::$app->session->setTimeout(5400);	
        $usuario_model = RolUsuario::find()->where(['usuario' => $usuario])->all();
        $permisos = array();

        foreach ($usuario_model as $key) {

            /*Obtener Permisos Rol*/
            $permiso_rol = PermisoRol::find()->where(['rol_id' => $key->rol_id])->all();

            foreach ($permiso_rol as $key2) {

                $permisos [] = strtolower( rtrim($key2->permiso->nombre) );

            }
        }


        return $permisos;


    }	
}
