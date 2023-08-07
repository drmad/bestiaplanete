<?php

use Vendimia\Routing\Rule;
use Vendimia\Http\{Request, Response};
use Vendimia\Core\AssetManager;

/**
 * Main routing rules.
 */
return [

    // Change this rule for your default view or controller
    Rule::default()->includeFromClass(Inicio\Controller\DefaultController::class),

    // Vendimia CSS and JS asset preprocessors
    Rule::path('assets')->includeFromClass(AssetManager\Controller::class),
];