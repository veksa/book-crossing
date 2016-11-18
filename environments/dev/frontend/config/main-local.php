<?
$config =  [
    'components' => [
        'cache' => [
            'keyPrefix' => 'books'
        ]
    ]
];

if (!YII_ENV_TEST) {
    $config['modules']['debug'] = [
         'allowedIPs' => ['127.0.0.1']
    ];
}

return $config;
