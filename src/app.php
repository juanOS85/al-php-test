<?php
require_once __DIR__ . '/../vendor/autoload.php';

/**
 * Silex and Symfony2 services
 */
use Silex\Application;
use Silex\Provider\FormServiceProvider;
use Silex\Provider\ServiceControllerServiceProvider;
use Silex\Provider\SessionServiceProvider;
use Silex\Provider\TranslationServiceProvider;
use Silex\Provider\TwigServiceProvider;

$app = new Application();
// Set true for development
$app['debug'] = true;

/**
 * Registered services
 */
$app->register(new ServiceControllerServiceProvider());
// Handle user sessions
$app->register(new SessionServiceProvider());
// Handle Twig template engine
$app->register(new TwigServiceProvider(), array(
    'twig.path'    => __DIR__ . '/../views',
    'twig.options' => array('cache' => __DIR__ . '/../cache')
));
// Handle Forms
$app->register(new FormServiceProvider());
$app->register(new TranslationServiceProvider());

/**
 * Routing definitions
 */
$app->get('/',           'TMDb\Controller\TMDbController::indexAction');
$app->get('/search',     'TMDb\Controller\TMDbController::searchAction');
$app->get('/results',    'TMDb\Controller\TMDbController::resultsAction');
$app->get('/actor/{id}', 'TMDb\Controller\TMDbController::actorAction');
$app->get('/movie/{id}', 'TMDb\Controller\TMDbController::movieAction');

return $app;
