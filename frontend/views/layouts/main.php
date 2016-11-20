<?
use yii\bootstrap\Nav;
use yii\helpers\Html;
use frontend\assets\AppAsset;

AppAsset::register($this);

/**
 * @var string $content
 */
?>

<? $this->beginPage() ?>
<!DOCTYPE html>
<html lang="<?= Yii::$app->language ?>">
<head>
    <meta charset="<?= Yii::$app->charset ?>">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta content="width=device-width, initial-scale=1" name="viewport"/>

    <?= Html::csrfMetaTags() ?>
    <title><?= Html::encode($this->title) ?></title>

    <? $this->head() ?>
</head>
<body>
<? $this->beginBody() ?>

<?= Nav::widget([
    'options' => ['class' => 'navbar-nav navbar-right'],
    'items' => [
        ['label' => 'Index', 'url' => ['default/index']]
    ]
]) ?>

<?= $content ?>

<? $this->endBody() ?>
</body>
</html>
<? $this->endPage() ?>
