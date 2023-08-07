<?php return [
    'session' => [
        'driver' => Vendimia\Session\Driver\Php::class,
        'options' => [
            'cookie_secure' => true,
            'cookie_httponly' => true,
            'cookie_samesite' => 'strict',
        ],
    ],

    'database' => [
        'connector' => Vendimia\Database\Driver\Sqlite\Connector::class,
        'options' => [
            'filename' => Vendimia\PROJECT_PATH . '/database.sqlite',
        ],
    ],

    /**
     * Simple logger definition. First entry is the default logger (the 'default'
     * name is ignored). Subsequents logger are 'named' loggers.
     *
     * Each logger definition is an array. Target and Formatter entries can be
     * a class name, or an array, with the class name as first element (key 0),
     * and the rest of the entries are "option" => "value" passed to the object.
     *
     * More complex logger configuration can be created editing "bootstrap.php"
     * file, on the logger section.
     */
    'logger' => [
        // This will be the default logger.
        'default' => [
            [
                // Minimun trigger level for this logger
                'level' => Vendimia\Logger\LogLevel::DEBUG,

                // 'ErrorLog' target uses the error_log PHP directive
                'target' => Vendimia\Logger\Target\ErrorLog::class,

                // Each target has its default formatter. ErrorLog for instance
                // uses Vendimia\Logger\Formatter\OneLiner. You can specify here
                // a different formatter and/or options for them.
                /*
                'formatter' => [Vendimia\Logger\Formatter\OneLiner::class,
                    'date_format' => 'Y-m-d H:i:s',
                ],
                */
            ],
            /*
            // Multiple log levels can be added
        'named-logger' => [
                'level' => Vendimia\Logger\LogLevel::WARNING,
                'target' => Vendimia\Logger\Target\PHPMailer::class,
                // ...
            ],*/
        ],
    ],

    'middleware' => [
        Vendimia\Middleware\Routing::class,
    ],
];