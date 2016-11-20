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
                'OPTIONS v1/book' => 'v1/book/options',
                'GET v1/books' => 'v1/book/index',
                'GET v1/book/<id:\d+>' => 'v1/book/view',
                'POST v1/book' => 'v1/book/create',
                'PUT v1/book/<id:\d+>' => 'v1/book/update',
                'DELETE v1/book/<id:\d+>' => 'v1/book/delete',

                'OPTIONS v1/rating' => 'v1/rating/options',
                'GET v1/rating/<bookId:\d+>' => 'v1/rating/index',
                'POST v1/rating' => 'v1/rating/create',
                'DELETE v1/rating/<bookId:\d+>/<userId:\d+>' => 'v1/rating/delete',

                'OPTIONS v1/user' => 'v1/user/options',
                'GET v1/users' => 'v1/user/index',
                'GET v1/user/<id:\d+>' => 'v1/user/view',
                'POST v1/user' => 'v1/user/create',
                'PUT v1/user/<id:\d+>' => 'v1/user/update',
                'DELETE v1/user/<id:\d+>' => 'v1/user/delete'
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
