<?php

/**
 * Vendimia bootstrap script.
 */

// Project path
define ('Vendimia\\PROJECT_PATH', __DIR__);

// Project environment
define ('Vendimia\\ENVIRONMENT',
    $_ENV['VENDIMIA_ENVIRONMENT'] ?? 'development');

// Base URL path
define ('Vendimia\\WEB_ROOT',
    $_ENV['VENDIMIA_WEB_ROOT'] ?? '/');

// Path for public files reached using PUBLIC_URL
define ('Vendimia\\PUBLIC_PATH',
    $_ENV['VENDIMIA_PUBLIC_PATH'] ?? __DIR__ . '/public');

// URL for public files
define ('Vendimia\\PUBLIC_URL',
    $_ENV['VENDIMIA_PUBLIC_URL'] ?? Vendimia\WEB_ROOT . '/public');

// Composer class autoloader
$autoloader = require __DIR__ . '/vendor/autoload.php';

// '.env' file loader for sensitive parameters
Dotenv\Dotenv::createImmutable(__DIR__)->safeLoad();

// Object repository
$object = new Vendimia\ObjectManager\ObjectManager;

// Config class for interact the configuration
$config = $object->build(Vendimia\Core\Config::class);
$config->addFile(Vendimia\PROJECT_PATH . '/config/default.php');

// Create a constant with the debug value from the configste
define ('Vendimia\\DEBUG', $config->get("debug", false));

// Save project info in the object repository
$project_info = $object->build(Vendimia\Core\ProjectInfo::class);

// ========================================================================== //
//                              LOGGER DEFINITION                             //
// ========================================================================== //

$logger = null;
if ($config->logger) {
    $logger = $object->build(Vendimia\Logger\Logger::class);

    foreach ($config->logger as $name => $defs) {
        if ($name == 'default') {
            $active_logger = $logger;
        } else {
            $active_logger = $logger->createLogger($name);
        }
        foreach ($defs as $def) {
            $active_logger->addTarget(new $def['target'], $def['level']);
        }
    }
}


// ========================================================================== //
//                    DEFAULT ERROR AND EXCEPTION HANDLER                     //
// ========================================================================== //

// By default, CLI exception handler is used, in case there is an error
// at initializing phase.
$exception_handler = new Vendimia\Core\ExceptionHandler\ExceptionHandler(
    new Vendimia\Core\ExceptionHandler\Cli
);
set_exception_handler($exception_handler);

// Treat all error as exceptions
set_error_handler(function($severity, $message, $file, $line) {
    throw new ErrorException($message, 0, $severity, $file, $line);
});

// Adds the default logger to the exception handler.
if ($logger) {
    $exception_handler->setLogger($logger);
}



// Build and save the Vendimia resource locator class
$resource_locator = $object->save(
    $object->new(Vendimia\Core\ResourceLocator::class),
    Vendimia\Interface\Path\ResourceLocatorInterface::class,
);

// Add this resource locator to Ruler class
Vendimia\Routing\Rule::setResourceLocator($resource_locator);

// Session manager
$object->bind(
    Vendimia\Session\Driver\DriverInterface::class,
    $config->session['driver']
);
$session = $object->build(Vendimia\Session\SessionManager::class);

// CSRF token
$object->build(Vendimia\Core\Csrf::class);

// Database
if ($config->database) {
    Vendimia\Database\Setup::init(
        $connector = new $config->database['connector'](
            ...$config->database['options']
        ),
    );

    // Save the connector in the object repository
    $object->save(
        $connector, Vendimia\Database\Driver\ConnectorInterface::class
    );
}



// ========================================================================== //
//                      VENDIMIA INITIALIZATION COMPLETE                      //
// ========================================================================== //

if (PHP_SAPI == 'cli') {
    return;
}

// Create and save the HTTP request in the object repository
$request = $object->save(Vendimia\Http\Request::fromPHP());

// If the request ACCEPTs a application/json, o content-type is application/json,
// use the Json exception handler
if (str_contains(strtolower($request->getHeaderLine('accept')), 'application/json') ||
    $request->getHeaderLine('content-type') == 'application/json') {
    $exception_handler->setHandler(new Vendimia\Core\ExceptionHandler\Json);
} else {
    $exception_handler->setHandler(new Vendimia\Core\ExceptionHandler\Web);
}

if (PHP_SAPI == 'cli-server') {
    $path = trim($request->getUri()->getPath(), ' /');

    // Si la ruta pública está dentro de Vendimia\WEB_ROOT, y es la solicitada,
    // retornamos false para que sea procesado directo por cli-server
    if (str_starts_with(Vendimia\PUBLIC_URL, Vendimia\WEB_ROOT)) {
        $public_url_path = trim(substr(Vendimia\PUBLIC_URL, strlen(Vendimia\WEB_ROOT)), '/');

        if (str_starts_with($path, $public_url_path)) {
            return false;
        }
    }
}

// Begin the middleware queue
$middleware_queue = $object->new(
    Vendimia\Middleware\QueueHandler::class
);
$middleware_queue->setQueue($config->middleware);
$response = $middleware_queue->handle($request);

$response->send();