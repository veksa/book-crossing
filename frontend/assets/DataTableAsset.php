<?
namespace frontend\assets;

use yii\web\AssetBundle;

class DataTableAsset extends AssetBundle
{
    public $sourcePath = '@vendor/datatables/datatables/media';

    public $css = [
        'css/jquery.dataTables.min.css',
        'css/dataTables.bootstrap.min.css'
    ];

    public $js = [
        'js/jquery.dataTables.min.js',
        'js/dataTables.bootstrap.min.js'
    ];
}