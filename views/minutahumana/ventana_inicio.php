<?php

use yii\helpers\Html;
use yii\helpers\Url;


/* @var $this yii\web\View */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Minuta Humana';
$this->params['breadcrumbs'][] = $this->title;
?>



<div class="row">
    <div class="col-lg-12">
        <h1 class="page-header"><?php echo $this->title ?></h1>
    </div>
    <!-- /.col-lg-12 -->
</div>


<div class="row">
	<div class="col-lg-3 col-md-6">
		<div class="panel panel-primary">
		    <div class="panel-heading">
		        <div class="row">
		            <div class="col-xs-3">
		                <i class="fa fa-sign-in fa-5x"></i>
		            </div>
		            <div class="col-xs-9 text-right">
		                <div class="huge"><i class="fa fa-circle-o-notch" aria-hidden="true"></i><?//= $conteo_dia?></i></div>
		                <div>Registrar Ingreso</div>
		            </div>
		        </div>
		    </div>
		    <a href="<?= Yii::$app->request->baseUrl.'/minutahumana/create'  ?>">
		        <div class="panel-footer">
		            <span class="pull-left">Ver Mas</span>
		            <span class="pull-right"><i class="fa fa-arrow-circle-right"></i></span>
		            <div class="clearfix"></div>
		        </div>
		    </a>
		</div>
	</div>

	<div class="col-lg-3 col-md-6">
		<div class="panel panel-primary">
		    <div class="panel-heading">
		        <div class="row">
		            <div class="col-xs-3">
		                <i class="fa fa-calendar fa-5x"></i>
		            </div>
		            <div class="col-xs-9 text-right">
		                <div class="huge"><i class="fa fa-circle-o-notch" aria-hidden="true"></i></div>
		                <div>Reporte</div>
		            </div>
		        </div>
		    </div>
		    <a href="<?php echo Yii::$app->request->baseUrl.'/minutahumana/index'  ?>">
		        <div class="panel-footer">
		            <span class="pull-left">Ver Mas</span>
		            <span class="pull-right"><i class="fa fa-arrow-circle-right"></i></span>
		            <div class="clearfix"></div>
		        </div>
		    </a>
		</div>
	</div>

</div>
