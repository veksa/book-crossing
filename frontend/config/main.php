<?
$rootPath = dirname(dirname(__DIR__));

$params = yii\helpers\ArrayHelper::merge(
    require($rootPath . '/common/config/params.php'),
    require($rootPath . '/common/config/params-local.php'),
    require($rootPath . '/frontend/config/params.php'),
    require($rootPath . '/frontend/config/params-local.php')
);

$config = [
    'id' => 'book-crossing',
    'name' => 'book-crossing UI',
    'basePath' => dirname(__DIR__),
    'controllerNamespace' => 'frontend\controllers',
    'defaultRoute' => 'default/index',
    'components' => [
        'request' => [
            // !!! insert a secret key in the following (if it is empty) - this is required by cookie validation
            'cookieValidationKey' => 'O7Rk79g5ETH4Z-2GRaOrQ-PsHDE6RU8x'
        ],
        'errorHandler' => [
            'errorAction' => 'default/error'
        ],
        'urlManager' => [
            'class' => 'yii\web\UrlManager',
            'enablePrettyUrl' => true,
            'showScriptName' => false,
            'rules' => [
                '' => 'default/index'
            ]
        ]
    ],
    'params' => $params
];

if (!YII_ENV_TEST) {
    // configuration adjustments for 'dev' environment
    $config['bootstrap'][] = 'debug';
    $config['modules']['debug'] = [
        'class' => 'yii\debug\Module'
    ];
}

return $config;
