<?php
use yii\helpers\Html;
use yii\helpers\Url;
$this->title = 'Crear Proyecto';
?>
<ol class="breadcrumb">
  <li><a href="#">Inicio</a></li>
  <li><a href="#">Presupuestacion Proyectos</a></li>
  <li class="active">Crear Proyecto</li>
</ol>
<a href="<?php echo Url::toRoute('proyectos/index')?>" class="btn btn-primary">
    <i class="fa fa-arrow-left"></i>
</a>
<h1 style="text-align: center;"><?= Html::encode($this->title) ?></h1>
<div id="info"></div>
<?= $this->render('_form', [
    'model' => $model,
    'dependencias'     => $dependencias,
    'marcasUsuario'    => $marcasUsuario,
    'distritosUsuario' => $distritosUsuario,
    'zonasUsuario'     => $zonasUsuario,
]) ?>
<script>
    function validar(){
        var flag=false;
        if($('#proyectos-ceco').val()==='0' || $('#proyectos-ceco').val()===''){
            flag=false;
            $('#proyectos-ceco').select2('open');
            $('#info').html(
                    '<div class="alert alert-warning alert-dismissable">'+
                        '<a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>'+
                        '<strong>Aviso!</strong> Seleccione la Dependencia.'+
                    '</div>')
        }else{
            flag=true;
        }
        if(flag){
            /*var form=document.getElementById("form_create");
            form.submit();*/
            $('#form_create').yiiActiveForm('submitForm');
        }
    }
</script>