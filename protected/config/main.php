<?php return [
    'basePath' => __DIR__ . DIRECTORY_SEPARATOR . '..',
    'name'     => 'glCMS',
    'import'   => [
        'application.models.*',
        'application.components.*'
    ],

    'modules' => array_merge([
        'gii' => [
            'class'     => 'system.gii.GiiModule',
            'password'  => false,
            'ipFilters' => ['locahost', $_SERVER['REMOTE_ADDR']]

        ],
    ], include_once __DIR__ . DIRECTORY_SEPARATOR . 'modules.php'),

    'components' => [
        'db' => [
            'class'                 => 'CDbConnection',
            'connectionString'      => 'mysql:host=mysql;dbname=glclms',
            'emulatePrepare'        => true,
            'username'              => 'glclms',
            'password'              => 'glclms',
            'charset'               => 'utf8',
            'schemaCachingDuration' => '3600',
            'enableProfiling'       => true,
        ],

        'errorHandler' => [
            'errorAction' => 'site/error',
        ],
        'cache'        => [
            'class'    => 'CRedisCache',
            'hostname' => 'redis',
            'port'     => 6379,
            'database' => 0,
        ],
        'urlManager'   => [
            'class'          => 'application.components.CMSUrlManager',
            'urlFormat'      => 'path',
            'showScriptName' => false,
        ],
        'log'          => [
            'class'  => 'CLogRouter',
            'routes' => [
                [
                    'class'   => 'CWebLogRoute',
                    'levels'  => 'error, warning, trace, info',
                    'enabled' => false
                ]
            ]
        ],
    ],

    'params' => [
        'includes' => require __DIR__ . '/params.php',
        'debug'    => true,
        'trace'    => 3
    ]
];
