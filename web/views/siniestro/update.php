<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model app\models\Distrito */

$this->title = 'Actualizar siniestro ';
?>
<?php if(isset($done) && $done === '200'):?>
   
   <p style="text-align: center;" class="alert alert-success">Siniestro actualizado de forma correcta.</p>
   
<?php endif;?>

    <h1 style="text-align:center;"><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
		'novedades' => $novedades,
		'dependencias' => $dependencias,
		'areas' => $areas,
		'marcasUsuario' => $marcasUsuario,
		'distritosUsuario' => $distritosUsuario,
		'zonasUsuario' => $zonasUsuario,
		//'zonas' => $zonas,
    ]) ?>