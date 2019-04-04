<?php
use yii\helpers\Html;
use yii\bootstrap\Nav;
use yii\bootstrap\NavBar;

$permisos = array();
if( isset(Yii::$app->session['permisos-exito']) ){
	$permisos = Yii::$app->session['permisos-exito'];
}
//$this->title = 'Exito';
?>
<link href="https://fonts.googleapis.com/css?family=Anton" rel="stylesheet"> 
<nav class="navbar navbar-default navbar-static-top" role="navigation" style="margin-bottom: 0">
            <div class="navbar-header">
                <button type="button" class="navbar-toggle" data-toggle="collapse" data-target=".navbar-collapse">
                    <span class="sr-only">Toggle navigation</span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                </button>
                <a class="navbar-brand" href="<?= Yii::$app->request->baseUrl.'/site/home'  ?>" style="font-family: 'Anton', sans-serif;font-size: 35px;">
                    <i class="fa fa-book" aria-hidden="true"></i>

                    MINUTA VIRTUAL
                </a>
            </div>
            <!-- /.navbar-header -->

            <ul class="nav navbar-top-links navbar-right">
                
               
                <!-- /.dropdown -->
                <li class="dropdown">
                    <a class="dropdown-toggle" data-toggle="dropdown" href="#">
                        <i class="fa fa-user fa-fw"></i><?= Yii::$app->session['usuario-exito']?> <i class="fa fa-caret-down"></i>
                    </a>
                    <ul class="dropdown-menu dropdown-user">
                        <li><a href="#"><i class="fa fa-user fa-fw"></i> <?= Yii::$app->session['usuario-exito']?></a>
                        </li>
                        <li><a href="<?= Yii::$app->request->baseUrl.'/site/cambio'?>"><i class="fa fa-gear fa-fw"></i> Cambiar clave</a>
                        </li>
                        <li class="divider"></li>
                        <li><a href="<?= Yii::$app->request->baseUrl.'/site/logout'  ?>"><i class="fa fa-sign-out fa-fw"></i> Logout</a>
                        </li>
                    </ul>
                    <!-- /.dropdown-user -->
                </li>
                <!-- /.dropdown -->
            </ul>
            <!-- /.navbar-top-links -->

            <div class="navbar-default sidebar" role="navigation">
                <div class="sidebar-nav navbar-collapse">
                    <ul class="nav" id="side-menu">
                        <li class="sidebar-search">
                            <!-- <div class="input-group custom-search-form">
                                <input type="text" class="form-control" placeholder="Search...">
                                <span class="input-group-btn">
                                    <button class="btn btn-default" type="button">
                                        <i class="fa fa-search"></i>
                                    </button>
                                </span>
                            </div> -->

                            <!-- <img class="img-responsive" src="https://cdn4.iconfinder.com/data/icons/free-large-boss-icon-set/128/Policeman.png" height="70px" width="150px"> -->

                            <img class="img-responsive" src="<?= Yii::$app->request->baseUrl.'/img/guarda.png'  ?>" height="70px" width="150px">

                            <!-- /input-group -->
                        </li>
                        <li>
                            <a href="<?= Yii::$app->request->baseUrl.'/site/home'  ?>"><i class="fa fa-dashboard fa-fw"></i> Home</a>
                        </li>

                        <li>
                            <a href="<?= Yii::$app->request->baseUrl.'/personas'  ?>">&nbsp;<i class="fa fa-male" aria-hidden="true"></i> Personas</a>
                        </li>

                        <li>
                            <a href="<?= Yii::$app->request->baseUrl.'/centro-costo/index'  ?>"><i class="fa fa-building-o fa-fw" aria-hidden="true"></i> Dependencias</a>
                        </li>
                        
                        <?php if(in_array("administrador", $permisos)){ ?>
                        <li>
                            <a href="<?= Yii::$app->request->baseUrl.'/empresa/create'  ?>">&nbsp;<i class="fa fa-building" aria-hidden="true"></i> Empresas</a>
                        </li>
                        

                        

                        <li>
                            <a href="<?= Yii::$app->request->baseUrl.'/puestosdependencia'  ?>"><i class="fa fa-dot-circle-o fa-fw" aria-hidden="true"></i> Puestos</a>
                        </li> 



                        <li>
                            <a href="<?= Yii::$app->request->baseUrl.'/tipoobservacion'  ?>"><i class="fa fa-dot-circle-o fa-fw" aria-hidden="true"></i> Tipo Observacion</a>
                        </li>

                        <li>
                            <a href="<?= Yii::$app->request->baseUrl.'/tipoinvitado'  ?>"><i class="fa fa-dot-circle-o fa-fw" aria-hidden="true"></i> Tipo Invitado</a>
                        </li>


                        <li>
                            <a href="<?= Yii::$app->request->baseUrl.'/rol/index'  ?>"><i class="fa fa-dot-circle-o fa-fw"></i> Roles</a>
                        </li>

                        <li>
                            <a href="<?= Yii::$app->request->baseUrl.'/permiso/index'  ?>"><i class="fa fa-dot-circle-o fa-fw"></i> Permisos</a>
                        </li>

                        <li>
                            <a href="<?= Yii::$app->request->baseUrl.'/usuario/index'  ?>">&nbsp;<i class="fa fa-user"></i> Usuarios</a>
                        </li>

                        <li>
                            <a href="<?= Yii::$app->request->baseUrl.'/zona/index'  ?>"><i class="fa fa-dot-circle-o"></i>Regionales</a>
                        </li>

                        <li>
                            <a href="<?= Yii::$app->request->baseUrl.'/area-dependencia/index'  ?>"><i class="fa  fa-university"></i> Areas dependencia</a>
                        </li>

                        <?php } ?>
                      
                    </ul>
                </div>
                <!-- /.sidebar-collapse -->
            </div>
            <!-- /.navbar-static-side -->
        </nav>