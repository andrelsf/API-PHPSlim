<?php

define('APP_ROOT', __DIR__);

$database = include(__DIR__."/src/Config/MySQL.php");

return [
    'settings' => [
        'displayErrorDetails' => true,
        'determineRouteBeforeAppMiddleware' => true,
    ],
    'doctrine' => [
        // If true, metadata caching is forcelly disabled
        'dev_mode' => true,
        // Path where the compiled metadata info will be cached
        // make sure the path exists and it is writable
        'cache_dir' => APP_ROOT.'/data/cache/doctrine',
        // You should add any other path containing annotated antity classes
        'metadata_dirs' => [APP_ROOT . "/src/Models/Entity"],
        'connection' => [
            'driver'    => $database['mysql']['driver'],
            'host'      => $database['mysql']['host'],
            'port'      => $database['mysql']['port'],
            'dbname'    => $database['mysql']['dbname'],
            'user'      => $database['mysql']['user'],
            'password'  => $database['mysql']['password'],
        ]
    ]
];