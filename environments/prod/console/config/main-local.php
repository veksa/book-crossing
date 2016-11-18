<?
$rootPath = dirname(dirname(__DIR__));

$db = require($rootPath . '/common/config/db.php');

$config = [
    'components' => [
        'db' => $db
    ]
];

return $config;
