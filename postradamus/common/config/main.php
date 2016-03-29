<?php
if (!function_exists('prr')) {
    function prr($str)
    {
        return false;
    }
}

return [
    'vendorPath' => dirname(dirname(__DIR__)) . '/vendor',
    'modules' => [
        'datecontrol' => [
            'class' => 'kartik\datecontrol\Module',

            // format settings for displaying each date attribute
            'displaySettings' => [
                \kartik\datecontrol\Module::FORMAT_DATE => 'Y-m-d',
                \kartik\datecontrol\Module::FORMAT_TIME => 'H:i:s A',
                \kartik\datecontrol\Module::FORMAT_DATETIME => 'd-M-Y H:i:s A',
            ],

            // format settings for saving each date attribute
            'saveSettings' => [
                \kartik\datecontrol\Module::FORMAT_DATE => 'U', // saves as unix timestamp
                \kartik\datecontrol\Module::FORMAT_TIME => 'H:i:s',
                \kartik\datecontrol\Module::FORMAT_DATETIME => 'Y-m-d H:i:s',
            ],

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
        ]
    ],
    'components' => [
        'cache' => [
            'class' => 'yii\caching\FileCache',
        ],
        'request' => [
            'enableCookieValidation' => true,
            'enableCsrfValidation' => true,
            'cookieValidationKey' => 'hUp43xMa',
        ],
    ],
];
