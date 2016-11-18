<?
$rootPath = dirname(dirname(__DIR__));

require($rootPath . '/common/config/bootstrap.php');

$params = array_merge(
    require($rootPath . '/common/config/params.php'),
    require($rootPath . '/common/config/params-local.php'),
    require($rootPath . '/console/config/params.php'),
    require($rootPath . '/console/config/params-local.php')
);

return [
    'id' => 'app-console',
    'basePath' => dirname(__DIR__),
    'controllerNamespace' => 'console\controllers',
    'params' => $params,
    'components' => []
];
