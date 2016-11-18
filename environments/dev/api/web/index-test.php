<?
// NOTE: Make sure this file is not accessible when deployed to production
if (!in_array(@$_SERVER['REMOTE_ADDR'], ['127.0.0.1', '::1'])) {
    //die('You are not allowed to access this file.');
}

header('Access-Control-Allow-Origin: *');
header('Access-Control-Allow-Methods: POST, GET, PUT, PATCH, DELETE, OPTIONS');
header('Access-Control-Allow-Headers: Content-Type, Authorization');

defined('YII_DEBUG') or define('YII_DEBUG', true);
defined('YII_ENV') or define('YII_ENV', 'test');

$rootPath = dirname(dirname(__DIR__));

require($rootPath . '/vendor/autoload.php');
require($rootPath . '/vendor/yiisoft/yii2/Yii.php');
require($rootPath . '/common/config/bootstrap.php');
$config = require($rootPath . '/tests/codeception/config/api/acceptance.php');

(new yii\web\Application($config))->run();
