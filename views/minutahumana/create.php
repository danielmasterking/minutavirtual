<?php

use yii\helpers\Html;
use yii\helpers\Url;
use kartik\widgets\TimePicker;

/* @var $this yii\web\View */
/* @var $model app\models\MinutaHumana */

$this->title = 'Registro Diario';
$this->params['breadcrumbs'][] = ['label' => 'Minuta Humanas', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="minuta-humana-create">

     <a href="<?php echo Url::toRoute('minutahumana/ventanainicio')?>" class="btn btn-primary">
        <i class="fa fa-reply"></i> Volver 
    </a><br><br>

    <form class="form-inline" method="post" action="<?php //echo Url::toRoute('prefacturaelectronica/index')?>" id='form'>
    	<div class="form-group">
	    	<div class="input-group">
			  <span class="input-group-addon" id="basic-addon1"><i class="fa fa-search"></i></span>
			  <input type="text" class="form-control" placeholder="Buscar..." aria-describedby="basic-addon1" id="buscar" style="width: 300px;" onkeypress="return pulsar(event);">
			</div>
		</div>

		 <button onclick="consultar(0)" type="button" class="btn btn-primary"> <i class="fa fa-search"></i> Buscar</button>
    </form>


    <h1><i class="fa fa-sign-in "></i> <?= Html::encode($this->title) ?></h1>

    <?php 

        $flashMessages = Yii::$app->session->getAllFlashes();
        if ($flashMessages) {
            echo "<br><br>";
            foreach($flashMessages as $key => $message) {
                echo "<div class='row'>
                        <div class='col-md-6'>
                            <div class='alert alert-" . $key . " alert-dismissible  text-center' role='alert'>
                                <button type='button' class='close' data-dismiss='alert' aria-label='Close'><span aria-hidden='true'>&times;</span></button>
                                $message
                            </div>
                        </div>
                    </div>";   
            }
        }
    ?>

    <button type="button" class="btn btn-primary " data-toggle="modal" data-target="#myModal" id="agregar_minuta">
 	<i class="fa fa-plus"></i>
	</button>

	<div class="row">
        <hr>
        <div id="info"></div>
        <div id="partial"><?=$partial?></div>
    </div>

   

</div>


<!-- Modal -->
<div class="modal fade" id="myModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
  <div class="modal-dialog " role="document">
    <div class="modal-content">
      <div class="modal-header" style="background-color: blue;color: white;">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title" id="myModalLabel"><i class="fa fa-plus"></i> Nueva Minuta</h4>
      </div>
      <div class="modal-body">
        <?= $this->render('_form', [
	        'model' => $model,
	        'list_inv'=>$list_inv,
	        'list_obs'=>$list_obs,
	        'empresas'=>$empresas,
            'list_dependencia'=>$list_dependencia,
            'areas'=>$areas,
            'list_puestos'=>$list_puestos,
            'array_personas'=>$array_personas
	    ]) ?>
      </div>
      <!-- <div class="modal-footer">
        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
        <button type="button" class="btn btn-primary">Save changes</button>
      </div> -->
    </div>
  </div>
</div>

<!-- Modal -->
<div class="modal fade" id="myModal1" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
  <div class="modal-dialog " role="document">
    <div class="modal-content">
      <div class="modal-header" style="background-color: blue;color: white;">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title" id="myModalLabel"><i class="fa fa-group"></i> Nueva persona </h4>
      </div>
      <div class="modal-body" id="update">
        
        <?= $this->render('_formpersona', [
            'model' => $personas
                      
        ]) ?>


      </div>
      <!-- <div class="modal-footer">
        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
        <button type="button" class="btn btn-primary">Save changes</button>
      </div> -->
    </div>
  </div>
</div>

<!-- Modal -->
<div class="modal fade" id="myModal-salida" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title" id="myModalLabel">Salida</h4>
      </div>
      <div class="modal-body">
      <form method="post" action="" id='form-salida'>


        <label>Hora Salida</label>
        <?php 
        date_default_timezone_set ( 'America/Bogota');
        echo TimePicker::widget([
            'name' => 'hora',
            'pluginOptions' => [
                //'showSeconds' => true,
                'showMeridian' => false,
                'minuteStep' => 1,
                'secondStep' => 5,
                'defaultTime' => date('H:i:s')
            ]
        ]);

        ?>

        <br>

        <label>Observacion Salida</label>
        <textarea rows="3" name="obs_salida" class="form-control"></textarea>   
        
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-default" data-dismiss="modal">Cerrar</button>
        <button type="submit" class="btn btn-primary">Salir</button>

        </form>
      </div>
    </div>
  </div>
</div>

<script type="text/javascript">

    
    $(function (){
        $.fn.modal.Constructor.prototype.enforceFocus = function() {};
        document.getElementById('cedula').focus();
    });
	
    $('#cedula').keyup(function(event) {
        /* Act on the event */
        var tamano=$('#cedula').val().toString().length;
        //
        //alert(tamano)
        if(tamano==10 || tamano==9){
            buscar_persona();
        }
    });

    $("#agregar_minuta").click(function(event) {
        /* Act on the event */
      
        document.getElementById('cedula').focus();
    });

	$(document).on( "click", "#partial .pagination li", function() {
        var page = $(this).attr('p');
        consultar(page);



    });

    /*$('#tipo_person').change(function(event) {
       var tipo=$('#tipo_person option:selected').text();

       if (tipo=='INVITADO') {

            $('#div_invitado').show('slow/400/fast', function() {
                
            });
       }else{

            $('#div_invitado').hide('slow/400/fast', function() {
                
            });
       }
    });*/

    function consultar(page){
        var form=document.getElementById("form");
        
       
        var buscar=$("#buscar").val();
        
        $.ajax({
            url:"<?php echo Url::toRoute('minutahumana/create')?>",
            type:'POST',
            dataType:"json",
            cache:false,
            data: {
                buscar: buscar,
                page: page
            },
            beforeSend:  function() {
                $('#info').html('Cargando... <i class="fa fa-spinner fa-spin fa-1x fa-fw"></i>');
            },
            success: function(data){
                $("#partial").html(data.respuesta);
                $("#info").html('');
            }
        });
    }


    // function update(id,nombre){

    //     $('#nombre_act').html(nombre);

    //     $.ajax({
    //         url:"<?php //echo Url::toRoute('minutahumana/update')?>",
    //         type:'POST',
    //         dataType:"json",
    //         cache:false,
    //         data: {
    //             id: id,
                
    //         },
    //         beforeSend:  function() {
    //             $('#update').html('Cargando... <i class="fa fa-spinner fa-spin fa-1x fa-fw"></i>');
    //         },
    //         success: function(data){
    //             $("#update").html(data.respuesta);
                
    //         }
    //     });

    // }


</script>