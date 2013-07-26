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

        if ('actor' === $request->get('criteria')) {
            $result = $this->searchActor($app, $request->get('keyword'));
        } else {
            $result = $this->searchMovie($request->get('keyword'));
        }

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

        // return $app['twig']->render('results.html.twig', array('form' => $form->createView()));

        return $app['twig']->render('results.html.twig');
    }

    /**
     *
     */
    public function actorAction(Request $request, Application $app) {
        return $app['twig']->render('results.html.twig');
    }

    /**
     *
     */
    private function searchActor(Application $app, $c) {
        $a = json_decode($this->tmdbApi->searchPerson($c));
        $numResults = count($a->results);

        if ($numResults > 0) {
            if ($numResults > 1) {

            } else {
            }
        } else {

        }
    }

    /**
     *
     */
    private function searchMovie() {
    }
}
