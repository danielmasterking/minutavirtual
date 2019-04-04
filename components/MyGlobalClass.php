<?php 
namespace app\components;
use yii\helpers\Url;
/**
 * Redirects all users to login page if not logged in
 *
 * Class AccessBehavior
 * @package app\components
 * @author  Artem Voitko <r3verser@gmail.com>
 */
class MyGlobalClass extends \yii\base\Component{
    public function init(){
    	if(isset(\Yii::$app->session['permisos-exito'])){
    		if (\Yii::$app->session['permisos-exito']==null) {
	        	\Yii::$app->getResponse()->redirect(\Yii::$app->getUser()->loginUrl);
	        }
    	}
        parent::init();
    }
}
?>