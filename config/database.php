<?php

return [

    /*
    |--------------------------------------------------------------------------
    | PDO Fetch Style
    |--------------------------------------------------------------------------
    |
    | By default, database results will be returned as instances of the PHP
    | stdClass object; however, you may desire to retrieve records in an
    | array format for simplicity. Here you can tweak the fetch style.
    |
    */

    'fetch' => PDO::FETCH_CLASS,

    /*
    |--------------------------------------------------------------------------
    | Default Database Connection Name
    |--------------------------------------------------------------------------
    |
    | Here you may specify which of the database connections below you wish
    | to use as your default connection for all database work. Of course
    | you may use many connections at once using the Database library.
    |
    */

    'default' => env('DB_CONNECTION', 'sqlsrv'),

    /*
    |--------------------------------------------------------------------------
    | Database Connections
    |--------------------------------------------------------------------------
    |
    | Here are each of the database connections setup for your application.
    | Of course, examples of configuring each database platform that is
    | supported by Laravel is shown below to make development simple.
    |
    |
    | All database work in Laravel is done through the PHP PDO facilities
    | so make sure you have the driver for your particular database of
    | choice installed on your machine before you begin development.
    |
    */

    'connections' => [

        'sqlite' => [
            'driver'   => 'sqlite',
            'database' => storage_path('database.sqlite'),
            'prefix'   => '',
        ],

        'mysql' => [
            'driver'    => 'mysql',
            'host'      => '192.168.200.51',
            'database'  => 'metland_hris',
            'username'  => 'cron_job',
            'password'  => 'm3tl4nd!@#',
            'charset'   => 'utf8',
            'collation' => 'utf8_unicode_ci',
            'prefix'    => '',
            'strict'    => false,
        ],
        'websen' => [
            'driver'    => env('DB_CONNECTION_SECOND'),
            'host'      => env('DB_HOST_SECOND'),
//            'port'      => env('DB_PORT_SECOND'),
            'database'  => env('DB_DATABASE_SECOND'),
            'username'  => env('DB_USERNAME_SECOND'),
            'password'  => env('DB_PASSWORD_SECOND'),
            'charset'   => 'utf8',
            'collation' => 'utf8_unicode_ci',
            'prefix'    => '',
            'strict'    => false,
            'options' => [
                PDO::ATTR_EMULATE_PREPARES => true,
            ], // Error SQL 1615 Prepared statement needs to be re-prepared
        ],
//        'adms' => [
//            'driver'    => env('DB_CONNECTION_THIRD'),
//            'host'      => env('DB_HOST_THIRD'),
////            'port'      => env('DB_PORT_SECOND'),
//            'database'  => env('DB_DATABASE_THIRD'),
//            'username'  => env('DB_USERNAME_THIRD'),
//            'password'  => env('DB_PASSWORD_THIRD'),
//            'charset'   => 'utf8',
//            'collation' => 'utf8_unicode_ci',
//            'prefix'    => '',
//            'strict'    => false,
//            'options' => [
//                PDO::ATTR_EMULATE_PREPARES => true,
//            ], // Error SQL 1615 Prepared statement needs to be re-prepared
//        ],
        'adms' => [
            'driver'    => env('DB_CONNECTION_THIRD'),
            'host'      => env('DB_HOST_THIRD'),
//            'port'      => env('DB_PORT_SECOND'),
            'database'  => env('DB_DATABASE_THIRD'),
            'username'  => env('DB_USERNAME_THIRD'),
            'password'  => env('DB_PASSWORD_THIRD'),
            'charset'   => 'utf8',
            'prefix'    => '',
            'trust_server_certificate' => 'true',
        ],
        'pgsql' => [
            'driver'   => 'pgsql',
            'host'     => env('DB_HOST', 'localhost'),
            'database' => env('DB_DATABASE', 'forge'),
            'username' => env('DB_USERNAME', 'forge'),
            'password' => env('DB_PASSWORD', ''),
            'charset'  => 'utf8',
            'prefix'   => '',
            'schema'   => 'public',
        ],

        'sqlsrv' => [
            'driver'   => 'sqlsrv',
            'host'     => env('DB_HOST', 'localhost'),
            'database' => env('DB_DATABASE', 'forge'),
            'username' => env('DB_USERNAME', 'forge'),
            'password' => env('DB_PASSWORD', ''),
            'charset'  => 'utf8',
            'prefix'   => '',
	    'trust_server_certificate' => 'true',
        ],
        'sqlsrv_sso' => [
            'driver' => 'sqlsrv',
            'host' => env('DB_HOST_SSO', 'localhost'),
            'database' => env('DB_DATABASE_SSO', 'SSO'),
            'username' => env('DB_USERNAME_SSO', 'forge'),
            'password' => env('DB_PASSWORD_SSO', ''),
            'charset' => 'utf8',
            'prefix' => '',
            'prefix_indexes' => true,
            'trust_server_certificate' => 'true',
        ],

    ],

    /*
    |--------------------------------------------------------------------------
    | Migration Repository Table
    |--------------------------------------------------------------------------
    |
    | This table keeps track of all the migrations that have already run for
    | your application. Using this information, we can determine which of
    | the migrations on disk haven't actually been run in the database.
    |
    */

    'migrations' => 'migrations',

    /*
    |--------------------------------------------------------------------------
    | Redis Databases
    |--------------------------------------------------------------------------
    |
    | Redis is an open source, fast, and advanced key-value store that also
    | provides a richer set of commands than a typical key-value systems
    | such as APC or Memcached. Laravel makes it easy to dig right in.
    |
    */

    'redis' => [

        'cluster' => false,

        'default' => [
            'host'     => '127.0.0.1',
            'port'     => 6379,
            'database' => 0,
        ],

    ],

];
