<?php
require_once __DIR__ . '/../vendor/autoload.php';

$app = new Silex\Application();
$app['debug'] = true;

$app->register(new Silex\Provider\TwigServiceProvider(), array(
    'twig.path' => __DIR__ . '/../views',
    'twig.options' => array('cache' => __DIR__ . '/../cache')
));

// definitions
$app->get('/', function () use ($app) {
    return $app['twig']->render('index.html.twig');
});

return $app;
