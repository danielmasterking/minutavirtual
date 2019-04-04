<?php
/**
 * @link http://www.yiiframework.com/
 * @copyright Copyright (c) 2008 Yii Software LLC
 * @license http://www.yiiframework.com/license/
 */

namespace app\assets;

use yii\web\AssetBundle;

/**
 * @author Qiang Xue <qiang.xue@gmail.com>
 * @since 2.0
 */
class AppAsset extends AssetBundle
{
    public $basePath = '@webroot';
    public $baseUrl = '@web';
    public $css = [
        
		'js/DataTables/datatables.min.css',
      //  'css/bootstrap-toggle.min.css',
      //  'css/main.css',
      //  'css/sticky-footer-navbar.css',
    'admin/metisMenu/metisMenu.min.css',
    'admin/dist/css/sb-admin-2.css',
    'admin/font-awesome/css/font-awesome.min.css',
    'admin/sweet_alert/sweetalert2.min.css'
    ];
    public $js = [
	  
       'js/DataTables/datatables.min.js',
       //'js/bootstrap-toggle.min.js',
       'js/momentjs.js',
       'js/moment-duration-format.js',
       'js/main.js',
       'admin/metisMenu/metisMenu.min.js',
       'admin/dist/js/sb-admin-2.js',
       'admin/sweet_alert/sweetalert2.min.js'
    ];
    public $depends = [
        'yii\web\YiiAsset',
        'yii\bootstrap\BootstrapAsset',
		'yii\bootstrap\BootstrapPluginAsset',
		
    ];
}
