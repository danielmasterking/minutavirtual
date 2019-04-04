<?php
use yii\helpers\Html;
//use yii\bootstrap\ActiveForm;
use \kartik\form\ActiveForm;

$this->title = 'Login';
/* @var $this yii\web\View */
/* @var $form yii\bootstrap\ActiveForm */
/* @var $model app\models\LoginForm */

?>
	
	<?php if(isset($_GET['flash'])): ?>
                               
	   <p class="alert alert-danger" style="text-align: center;"><?= $_GET['flash'] ?></p>
	   
 <?php endif;?>	



    <div class="container">
        <div class="row">
            <div class="col-md-4 col-md-offset-4">
                <div class="login-panel panel panel-default">
                    <div class="panel-heading">
                        <h3 class="panel-title text-center">
                            <img height="80px" src="<?= Yii::$app->request->baseUrl.'/img/user_login_man-128.png'  ?>">
                        </h3>
                    </div>
                    <div class="panel-body">
                        <?php $form = ActiveForm::begin([
                                                       'id' => 'login-form',
                                                       'options' => [/*'class' => 'form-horizontal',*/'role'=>'form'],
                                                   ]); ?>
                            <fieldset>
                                <div class="form-group">
                                    
                                     <?php

                                        echo $form->field($model, 'username')->textInput(['placeholder' => "Username",'autofocus'=>true])->label(false);

                                        ?>
                                </div>
                                <div class="form-group">
                                  
                                    <?php

                                        echo $form->field($model, 'password')->passwordInput(['placeholder' => "Password"])->label(false);

                                    ?>
                                </div>
                                <!-- <div class="checkbox">
                                    <label>
                                        <input name="remember" type="checkbox" value="Remember Me">Remember Me
                                    </label>
                                </div> -->
                                <!-- Change this to a button or input when using this as a form -->
                                <!-- <a href="index.html" class="btn btn-lg btn-primary btn-block">Login</a> -->
                                <?= Html::submitButton('Login', ['class' => 'btn btn-lg btn-primary btn-block', 'name' => 'login-button']) ?>

                                  <?php ActiveForm::end(); ?>
                            </fieldset>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>