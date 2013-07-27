<?php
namespace TMDb\Controller;

use Silex\Application;
use Symfony\Component\HttpFoundation\Request;
use TMDb\API\TMDbAPI;

/**
 * @author juanchopx2
 */
class TMDbController {
    /**
     *
     */
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
    public function searchAction(Request $request, Application $app) {
        $this->tmdbApi = new TMDbAPI('6425ff98fc0c954273045edc360b9e77');

        $data = array(
            'keyword'  => $request->get('keyword'),
            'criteria' => $request->get('criteria')
        );

        if ('actor' === $request->get('criteria')) {
            $a = json_decode($this->tmdbApi->searchPerson($request->get('keyword')));
            $numResults = count($a->results);

            if (0 < $numResults) {
                if (1 === $numResults) {
                    return $app->redirect('/actor/' . $a->results[0]->id);
                } else {
                }
            } else {

            }
        } else {
            $result = $this->searchMovie($request->get('keyword'));
        }

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
    public function resultsAction(Request $request, Application $app) {
    }

    /**
     *
     */
    public function actorAction($id, Request $request, Application $app) {
        $this->tmdbApi = new TMDbAPI('6425ff98fc0c954273045edc360b9e77');
        $actorInfo = json_decode($this->tmdbApi->getPersonGeneralInfo($id));

        print_r($actorInfo);

        return $app['twig']->render('actor/actor.html.twig', array('actor' => $actorInfo));
    }
}
