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
        $r = array();
        $r['data'] = array();

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
                    $r['path'] = 'actor';
                    // var_dump($a);

                    for ($i = 0; $i < $numResults; $i++) {
                        $r['data'][$i]['id']    = $a->results[$i]->id;
                        $r['data'][$i]['title'] = $a->results[$i]->name;
                        $r['data'][$i]['img']   = $a->results[$i]->profile_path;
                    }
                }
            }
        } else {
            $m = json_decode($this->tmdbApi->searchMovie($request->get('keyword')));
            $numResults = count($m->results);

            if (0 < $numResults) {
                if (1 === $numResults) {
                    return $app->redirect('/movie/' . $m->results[0]->id);
                } else {
                    $r['path'] = 'movie';

                    for ($i = 0; $i < $numResults; $i++) {
                        $r['data'][$i]['id'] = $m->results[$i]->id;
                        $r['data'][$i]['title'] = $m->results[$i]->title;
                        $r['data'][$i]['img']   = $m->results[$i]->poster_path;
                    }
                }
            }
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

        return $app['twig']->render('results.html.twig', array(
            'form'    => $form->createView(),
            'results' => $r
        ));
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

        $this->tmdbApi = new TMDbAPI('6425ff98fc0c954273045edc360b9e77');
        $actorInfo = json_decode($this->tmdbApi->getPersonGeneralInfo($id));
        $actorCredits = json_decode($this->tmdbApi->searchPersonCredits($id));

        // echo '<pre>';
        // print_r($actorCredits);
        // echo '</pre>';

        return $app['twig']->render('actor.html.twig', array(
            'form'    => $form->createView(),
            'actor'   => $actorInfo,
            'credits' => $actorCredits
        ));
    }

    /**
     *
     */
    public function movieAction($id, Request $request, Application $app) {
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

        $this->tmdbApi = new TMDbAPI('6425ff98fc0c954273045edc360b9e77');
        $movieInfo = json_decode($this->tmdbApi->getMovieBasicInfo($id));
        $movieInfo->release_date = date('F j, Y', strtotime($movieInfo->release_date));

        // echo '<pre>';
        // print_r($movieInfo);
        // echo '</pre>';

        return $app['twig']->render('movie.html.twig', array(
            'form'  => $form->createView(),
            'movie' => $movieInfo
        ));
    }
}
