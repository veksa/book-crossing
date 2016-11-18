<?
defined('YII_DEBUG') or define('YII_DEBUG', true);
defined('YII_ENV') or define('YII_ENV', 'dev');

$rootPath = dirname(dirname(__DIR__));

require($rootPath . '/vendor/autoload.php');
require($rootPath . '/vendor/yiisoft/yii2/Yii.php');
require($rootPath . '/common/config/bootstrap.php');

$config = yii\helpers\ArrayHelper::merge(
    require($rootPath . '/common/config/main.php'),
    require($rootPath . '/common/config/main-local.php'),
    require($rootPath . '/frontend/config/main.php'),
    require($rootPath . '/frontend/config/main-local.php')
);

(new yii\web\Application($config))->run();
