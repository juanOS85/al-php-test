<?php
require_once __DIR__ . '/../vendor/autoload.php';

/**
 * Silex and Symfony2 services
 */
use Silex\Application;
use Silex\Provider\FormServiceProvider;
use Silex\Provider\ServiceControllerServiceProvider;
use Silex\Provider\TranslationServiceProvider;
use Silex\Provider\TwigServiceProvider;
use Symfony\Component\HttpFoundation\Request;

/**
 * Third-party Services
 */
use Guzzle\Http\Client;


$app = new Application();
$app['debug'] = true;

/**
 * Registered services
 */
$app->register(new ServiceControllerServiceProvider());
$app->register(new TwigServiceProvider(), array(
    'twig.path' => __DIR__ . '/../views',
    'twig.options' => array('cache' => __DIR__ . '/../cache')
));
$app->register(new FormServiceProvider());
$app->register(new TranslationServiceProvider());

/**
 * Routing definitions
 */
$app->get('/', 'TMDb\TMDbController::indexAction');

/**
 * Routing
 */
// $app->get('/', function () use ($app) {
//     $form = $app['form.factory']->createNamedBuilder(null, 'form', null)
//         ->add('keyword', null, array(
//             'label' => false,
//             'attr'  => array(
//                 'class'       => 'span8',
//                 'placeholder' => 'Search keyword'
//             )
//         ))
//         ->add('criteria', 'choice', array(
//             'choices' => array(
//                 'actor' => 'Actor',
//                 'movie' => 'Movie'
//             ),
//             'label' => false,
//             'attr'  => array('class' => 'span2')
//         ))
//         ->getForm();

//     return $app['twig']->render('index.html.twig', array('form' => $form->createView()));
// });

$app->get('/results', function(Request $request) use ($app) {
    $data = array(
        'keyword'  => $request->get('keyword'),
        'criteria' => $request->get('criteria')
    );

    $form = $app['form.factory']->createNamedBuilder(null, 'form', $data)
        ->add('keyword', null, array(
            'label' => false,
            'attr'  => array(
                'class'       => 'span8',
                'placeholder' => 'Search keyword'
            )
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

    // if ($form->isValid()) {
        $data = $form->getData();

        $params = array(
            'query' => $request->get('keyword'),
            'page' => 1,
            'include_adult' => 1,
            'api_key' => '6425ff98fc0c954273045edc360b9e77'
        );

        $client = new Client('http://api.themoviedb.org/3');
        $person = $client->get('search/person?' . http_build_query($params), array(
            'Accept' => 'application/json'
        ))->send();
    // }

    return $app['twig']->render('results.html.twig', array('form' => $form->createView()));
});

return $app;
