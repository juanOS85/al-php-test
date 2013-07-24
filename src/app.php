<?php
require_once __DIR__ . '/../vendor/autoload.php';

$app = new Silex\Application();
$app['debug'] = true;

// Registered serives
$app->register(new Silex\Provider\TwigServiceProvider(), array(
    'twig.path' => __DIR__ . '/../views',
    'twig.options' => array('cache' => __DIR__ . '/../cache')
));
$app->register(new Silex\Provider\FormServiceProvider());
$app->register(new Silex\Provider\TranslationServiceProvider());

// definitions
$app->get('/', function () use ($app) {
    $form = $app['form.factory']->createBuilder('form')
        ->add('keyword', null, array(
            'label' => false,
            'attr'  => array('class' => 'span8')
        ))
        ->add('criteria', 'choice', array(
            'choices' => array(
                'actor' => 'Actor',
                'movie' => 'Movie'
            ),
            'label' => false,
            'attr'  => array('class' => 'span2')
        ))
        ->getForm();

    return $app['twig']->render('index.html.twig', array('form' => $form->createView()));
});

return $app;
