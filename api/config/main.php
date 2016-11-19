<?
$rootPath = dirname(dirname(__DIR__));

$params = yii\helpers\ArrayHelper::merge(
    require($rootPath . '/common/config/params.php'),
    require($rootPath . '/common/config/params-local.php'),
    require($rootPath . '/api/config/params.php'),
    require($rootPath . '/api/config/params-local.php')
);

$config = [
    'id' => 'api.books',
    'name' => 'book crossing rest api',
    'basePath' => dirname(__DIR__),
    'defaultRoute' => 'api/v1/default/index',
    'components' => [
        'errorHandler' => [
            'errorAction' => 'api/default/error'
        ],
        'response' => [
            'format' => 'json'
        ],
        'request' => [
            'parsers' => [
                'application/json' => 'yii\web\JsonParser'
            ]
        ],
        'urlManager' => [
            'enablePrettyUrl' => true,
            'enableStrictParsing' => true,
            'showScriptName' => false,
            'rules' => [
                'v1/login' => 'v1/default/login',
                [
                    'class' => 'yii\rest\UrlRule',
                    'controller' => [
                        'v1/book',
                        'v1/rating',
                        'v1/user'
                    ]
                ]
            ]
        ]
    ],
    'modules' => [
        'v1' => [
            'basePath' => '@app/modules/v1',
            'class' => 'api\modules\v1\Module'
        ]
    ],
    'params' => $params
];

return $config;
