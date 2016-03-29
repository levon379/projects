<?php

$params = array_merge(
    require(__DIR__ . '/../../common/config/params.php'),
    require(__DIR__ . '/../../common/config/params-local.php'),
    require(__DIR__ . '/params.php'),
    require(__DIR__ . '/params-local.php')
);

return [
    'id' => 'app-backend',
    'name' => 'Postradamus',
    'basePath' => dirname(__DIR__),
    'controllerNamespace' => 'backend\controllers',
    //'bootstrap' => ['debug'],
	'bootstrap' => ['tooltips'],
    'modules' => [
        'datecontrol' => [
            'class' => '\kartik\datecontrol\Module',

            // format settings for displaying each date attribute
            'displaySettings' => [
                \kartik\datecontrol\Module::FORMAT_DATE => 'M d Y',
                \kartik\datecontrol\Module::FORMAT_TIME => 'H:i A',
                \kartik\datecontrol\Module::FORMAT_DATETIME => 'M d Y h:i A',
            ],

            // format settings for saving each date attribute
            'saveSettings' => [
                \kartik\datecontrol\Module::FORMAT_DATE => 'Y-M-d',
                \kartik\datecontrol\Module::FORMAT_TIME => 'H:i',
                \kartik\datecontrol\Module::FORMAT_DATETIME => 'U', // saves as unix timestamp
            ],

            // use ajax conversion for processing dates from display format to save format.
            'ajaxConversion' => true,

            // automatically use kartik\widgets for each of the above formats
            'autoWidget' => true,

            // custom widget settings that will be used to render the date input instead of kartik\widgets,
            // this will be used when autoWidget is set to false at module or widget level.
            'widgetSettings' => [
                \kartik\datecontrol\Module::FORMAT_DATE => [
                    'class' => 'yii\jui\DatePicker',
                    'options' => [
                        'options' => ['class' => 'form-control'],
                        'clientOptions' => ['dateFormat' => 'dd-mm-yy'],
                    ]
                ]
            ]
            // other settings
        ],
		'tooltips'=>['class' => 'app\modules\tooltips\Module']
    ],
    'components' => [
		'postradamus' => [
            'class' => 'backend\components\Postradamus',
        ],
        'image' => [
            'class' => 'backend\components\Image'
        ],
        'user' => [
            'identityClass' => 'common\models\cUser',
            'enableAutoLogin' => true,
        ],
        'feed' => array(
            'class' => 'yii\feed\FeedDriver',
        ),
        'authClientCollection' => [
            'class' => 'yii\authclient\Collection',
            'clients' => [
                /*
                'tumblr' => [
                    'class' => 'yii\authclient\clients\Tumblr',
                    'consumerKey' => 'ewsaskVRmsLOCPZ9TRJ3rhq78c1YjfbvB8C3DTPUtcHEzJn709',
                    'consumerSecret' => 'HJnXAXvAhGizAS9pAd3yQVNyQF7GeeXuBcx5Z9EPnbbRZKGkk9',
                ],
                'paypal' => [
                    'class' => 'yii\authclient\clients\Paypal',
                    'clientId' => 'AXjcMBBi3phoZD_Ar_hl-rINjDBS15TPDa-SHNqmdyfNAwmvbbPMD9E3iWvN',
                    'clientSecret' => 'EL30CxDqoZcpLMyNKKCzh96DggQ0UuE1qZC3OkpXF4xKX_OEjZT97FZli0D1',
                ],
                */
            ],
        ],
        'mail' => [
            'class' => 'yii\swiftmailer\Mailer',
        ],
        /*'log' => [
            'traceLevel' => YII_DEBUG ? 3 : 0,
            'targets' => [
                [
                    'class' => 'yii\log\FileTarget',
                    'levels' => ['error', 'warning'],
                ],
            ],
        ],*/
        'view' => [
            'theme' => [
                'pathMap' => ['@backend/views' => '@backend/web/themes/pixeladmin/views'],
                'baseUrl' => '@web/themes/pixeladmin',
            ],
        ],
    ],
    'params' => $params,
];
