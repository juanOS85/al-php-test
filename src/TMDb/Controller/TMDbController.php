<?php
namespace TMDb\Controller;

use Silex\Application;
use Symfony\Component\HttpFoundation\Request;
use TMDb\API\TMDbAPI;

/**
 * @author juanchopx2
 */
class TMDbController {
    protected $tmdbApi;

    /**
     *
     */
    public function indexAction(Request $request, Application $app) {
        $form = $app['form.factory']->createNamedBuilder(null, 'form', null)
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

        return $app['twig']->render('index.html.twig', array('form' => $form->createView()));
    }

    /**
     *
     */
    public function resultsAction(Request $request, Application $app) {
        $this->tmdbApi = new TMDbAPI('6425ff98fc0c954273045edc360b9e77');

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
            // $data = $form->getData();

            // $params = array(
            //     'query' => $request->get('keyword'),
            //     'page' => 1,
            //     'include_adult' => 1,
            //     'api_key' => '6425ff98fc0c954273045edc360b9e77'
            // );

            // $client = new Client('http://api.themoviedb.org/3');
            // $person = $client->get('search/person?' . http_build_query($params), array(
            //     'Accept' => 'application/json'
            // ))->send();
        // }

        $this->tmdbApi->searchPerson($request->get('keyword'));

        return $app['twig']->render('results.html.twig', array('form' => $form->createView()));
    }
}
