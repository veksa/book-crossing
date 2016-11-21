<?
return [
    'components' => [
        'db' => [
            'class' => 'yii\db\Connection',
            'dsn' => 'mysql:host=localhost;dbname=book_crossing',
            'username' => 'root',
            'password' => '',
            'charset' => 'utf8',
            'enableSchemaCache' => false
        ],
        'cache' => [
            'class' => 'yii\caching\DummyCache'
        ]
    ]
];
