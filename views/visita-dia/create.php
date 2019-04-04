<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model app\models\Distrito */

$this->title = 'Formulario de Visita Quincenal';
?>
 <?= $this->render('_tabs',['periodica' => $periodica]) ?>

<?php if(isset($done) && $done === '200'):?>
   
   <p style="text-align: center;" class="alert alert-success">Visita períodica creada de forma satisfactoria.</p>
   
<?php endif;?>

   <h1 style="text-align: center;"><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
                'model' => $model,
				//'modelDetalle' => $modelDetalle,
				'categorias' => $categorias,
				'dependencias' => $dependencias,
				'marcasUsuario' => $marcasUsuario,
				'distritosUsuario' => $distritosUsuario,
				'zonasUsuario' => $zonasUsuario,
				'secciones' => $secciones,
    ]) ?>