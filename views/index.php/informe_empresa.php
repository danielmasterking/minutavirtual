<?php 
use yii\helpers\Html;
use yii\grid\GridView;
use kartik\widgets\Select2;
use yii\bootstrap\Modal;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $searchModel app\models\RolSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */
$permisos = array();
if( isset(Yii::$app->session['permisos-exito']) ){
	$permisos = Yii::$app->session['permisos-exito'];
}
$this->title = 'Informe de dependencias sin empresa de seguridad ';
//var_dump(Yii::$app->session->getTimeout());
$permisos = array();

if( isset(Yii::$app->session['permisos-exito']) ){

  $permisos = Yii::$app->session['permisos-exito'];

}


?>


<h1 style="text-align: center;"><?= Html::encode($this->title) ?></h1>
<!---->
<?php 

	$flashMessages = Yii::$app->session->getAllFlashes();
    if ($flashMessages) {
        foreach($flashMessages as $key => $message) {
            echo "<div class='alert alert-" . $key . " alert-dismissible' role='alert'>
                    <button type='button' class='close' data-dismiss='alert' aria-label='Close'><span aria-hidden='true'>&times;</span></button>
                    $message
                </div>";   
        }
    }

?>

<!---->

<table  class="display my-data" data-page-length='50' cellspacing="0" width="100%">
	 
   <thead>

	   <tr>
	       
	       <th> </th>
		   <th>CeBe</th>
		   <th>CeCo</th>
	       <th>Nombre</th>
		   <th>Marca</th>
		   <th>Ciudad</th>
		   <th>Codigo</th>
	      
	   </tr>
       

   </thead>	 
   <tbody>
   		<?php
   			foreach($rows as $row): 
   		?>
   		<tr>
   			<td>
   				<a href="#" data-toggle="modal" data-target="#kartik-modal" title="Asignar empresa" onclick="id_dependencia('<?= $row['codigo']?>');">
   					<i class="fa fa-share" aria-hidden="true"></i>
   				</a>
   			</td>
   			<td><?= $row['cebe']?></td>
   			<td><?= $row['ceco']?></td>
   			<td><?= $row['nombre']?></td>
   			<td><?= $row['marca']?></td>
   			<td><?= $row['ciudad']?></td>
   			<td><?= $row['codigo']?></td>

   		</tr>
   		<?php

   		endforeach;
   		?>

   </tbody>
</table>
<!--MODAL ASIGNACION EMPRESA-->
 <?php 
	Modal::begin([
	    'options' => [
	        'id' => 'kartik-modal',
	        'tabindex' => false // important for Select2 to work properly
	    ],
	    'header' => '<h4 style="margin:0; padding:0">Seleccione una empresa de seguridad</h4>',
	    //'toggleButton' => ['label' => 'Show Modal', 'class' => 'btn btn-lg btn-primary'],
	]);

    $form = ActiveForm::begin([
    	'action'=>'asignar_empresa'
    	]); 

	echo Select2::widget([
	    'name' => 'empresa',
	    'data' => $empresas,
	    'options' => ['placeholder' => 'Selecciona una empresa ...'],
	    'pluginOptions' => [
	        'allowClear' => true
	    ],
	]);

	echo "<input type='hidden' id='id_dependencia' name='id_dependencia'>";

	echo "<br>";

	echo Html::submitButton('Asignar', ['class' => 'btn btn-primary btn-lg ']);

    ActiveForm::end();

	Modal::end();
?>
<!--END MODAL-->
<script type="text/javascript">
	function id_dependencia(id){
		$('#id_dependencia').val(id);
	}
</script>