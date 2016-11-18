<?
header('Access-Control-Allow-Origin: *');
header('Access-Control-Allow-Methods: POST, GET, PUT, PATCH, DELETE, OPTIONS');
header('Access-Control-Allow-Headers: Content-Type, Authorization');

defined('YII_DEBUG') or define('YII_DEBUG', true);
defined('YII_ENV') or define('YII_ENV', 'dev');

$rootPath = dirname(dirname(__DIR__));

require($rootPath . '/vendor/autoload.php');
require($rootPath . '/vendor/yiisoft/yii2/Yii.php');
require($rootPath . '/common/config/bootstrap.php');

$config = yii\helpers\ArrayHelper::merge(
    require($rootPath . '/common/config/main.php'),
    require($rootPath . '/common/config/main-local.php'),
    require($rootPath . '/api/config/main.php'),
    require($rootPath . '/api/config/main-local.php')
);

(new yii\web\Application($config))->run();
