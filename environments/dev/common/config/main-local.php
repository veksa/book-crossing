<?
$rootPath = dirname(dirname(__DIR__));

$db = require($rootPath . '/common/config/db.php');

$config = [
    'components' => [
        'db' => $db,
        'cache' => [
            'class' => 'yii\caching\DummyCache'
        ]
    ]
];

return $config;
