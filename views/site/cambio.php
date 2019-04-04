<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;


$permisos = array();


if( isset(Yii::$app->session['permisos']) ){

  $permisos = Yii::$app->session['permisos'];

}

/* @var $this yii\web\View */
/* @var $model app\models\Preaviso */
/* @var $form yii\widgets\ActiveForm */

?>
<?php $form = ActiveForm::begin(); ?>

    <?php if($model != null): ?>

      <p class="alert alert-success"> Cambio de clave realizado.</p>

    <?php endif;?> 

    <label>Nueva Clave</label>
    <input type="password" name="clave" class=" form-control"  />
    <label>Repetir Clave</label>
    <input type="password" name="confirmacion_clave" class=" form-control"  />
    <p>&nbsp;</p>
    <input type="submit" class="btn btn-primary" name="guardar" value="Cambiar clave" />
    



<?php ActiveForm::end(); ?>