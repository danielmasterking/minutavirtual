<?php
use kartik\datecontrol\Module;
use kartik\mpdf\Pdf;

$params = require __DIR__ . '/params.php';

$config = [
    'id'                => 'basic',
    'basePath'          => dirname(__DIR__),
    'bootstrap'         => ['log','MyGlobalClass'],
    
    'components'        => [
        /*'CheckIfLoggedIn'=>[
        'class'=>'app\components\CheckIfLoggedIn'
        ],*/
        'MyGlobalClass'=>[
            'class'=>'app\components\MyGlobalClass'
         ],
        'assetManager' => [
            'bundles' => [
                'yii\web\JqueryAsset'            => [
                    //'js'=>[]
                    'jsOptions' => ['position' => \yii\web\View::POS_HEAD],
                ],
                'dosamigos\google\maps\MapAsset' => [
                    'options' => [
                        'key'      => 'AIzaSyBrxwcssKaVRpa2MHvFmgbijKTBsCZvzpU',
                        'language' => 'id',
                        //'version' => '3.1.18'
                    ],
                ],
            ],
        ],

        'urlManager'   => [
            'showScriptName'  => false,
            'enablePrettyUrl' => true,
        ],

        'request'      => [
            // !!! insert a secret key in the following (if it is empty) - this is required by cookie validation
            'cookieValidationKey'  => 'HZcDFyhTDHXRLDVGS25druF57XR7LOSo',
            'enableCsrfValidation' => false,
        ],
        'cache'        => [
            'class' => 'yii\caching\FileCache',
        ],
        'user'         => [
            'identityClass'   => 'app\models\Usuario',
            'enableAutoLogin' => false,
        ],
        'errorHandler' => [
            'errorAction' => 'site/error',
        ],
        'mailer'       => [

            'class'            => 'yii\swiftmailer\Mailer',
            'transport'        => [
                'class'    => 'Swift_SmtpTransport',
                'host'     => '74.220.219.69',
                'username' => 'nomina@cvsc.co',
                'password' => 'nomina321*',
                'port'     => '25',

            ],
            // send all mails to a file by default. You have to set
            // 'useFileTransport' to false and configure a transport
            // for the mailer to send real emails.
            'useFileTransport' => false,
        ],
        'log'          => [
            'traceLevel' => YII_DEBUG ? 3 : 0,
            'targets'    => [
                [
                    'class'  => 'yii\log\FileTarget',
                    'levels' => ['error', 'warning'],
                ],
            ],
        ],
        'db'           => require __DIR__ . '/db.php',

        'second_db'    => [
            'class'    => 'yii\db\Connection',
            'dsn'      => 'sqlsrv:Server=181.49.3.226;database=oasis',
            //'dsn' => 'dblib:host=192.168.0.13;dbname=oasis;charset=UTF-8',
            'username' => 'moodle',
            'password' => 'moodle',

        ],

        'pdf'          => [
            'class'       => Pdf::classname(),
            'format'      => Pdf::FORMAT_A4,
            'orientation' => Pdf::ORIENT_PORTRAIT,
            'destination' => Pdf::DEST_BROWSER,

            // refer settings section for all configuration options
        ],
    ],
    'params'            => $params,

    'modules'           => [

        'datecontrol' => [
            'class'              => 'kartik\datecontrol\Module',

            // format settings for displaying each date attribute (ICU format example)
            'displaySettings'    => [
                Module::FORMAT_DATE     => 'php:Y-m-d',
                Module::FORMAT_TIME     => 'HH:mm:ss a',
                Module::FORMAT_DATETIME => 'dd-MM-yyyy HH:mm:ss a',
            ],

            // format settings for saving each date attribute (PHP format example)
            'saveSettings'       => [
                Module::FORMAT_DATE     => 'php:Y-m-d', // save as date
                Module::FORMAT_TIME     => 'php:H:i:s',
                Module::FORMAT_DATETIME => 'php:Y-m-d H:i:s',
            ],

            // set your display timezone
            'displayTimezone'    => 'Asia/Kolkata',

            // set your timezone for date saved to db
            'saveTimezone'       => 'UTC',

            // automatically use kartik\widgets for each of the above formats
            'autoWidget'         => true,

            // use ajax conversion for processing dates from display format to save format.
            'ajaxConversion'     => true,

            // default settings for each widget from kartik\widgets used when autoWidget is true
            'autoWidgetSettings' => [
                Module::FORMAT_DATE     => ['type' => 2, 'pluginOptions' => ['autoclose' => true]], // example
                Module::FORMAT_DATETIME => [], // setup if needed
                Module::FORMAT_TIME     => [], // setup if needed
            ],

            // custom widget settings that will be used to render the date input instead of kartik\widgets,
            // this will be used when autoWidget is set to false at module or widget level.
            'widgetSettings'     => [
                Module::FORMAT_DATE => [
                    'class'   => 'yii\jui\DatePicker', // example
                    'options' => [
                        'dateFormat' => 'php:d-M-Y',
                        'options'    => ['class' => 'form-control'],
                    ],
                ],
            ],
            // other settings
        ],

    ],
];

if (YII_ENV_DEV) {
    // configuration adjustments for 'dev' environment
    $config['bootstrap'][]      = 'debug';
    $config['modules']['debug'] = [
        'class' => 'yii\debug\Module',
    ];

    $config['bootstrap'][]    = 'gii';
    $config['modules']['gii'] = [
        'class' => 'yii\gii\Module',
    ];
}

return $config;
