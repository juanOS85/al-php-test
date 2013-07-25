<?php
namespace TMDb;

use Silex\Application;
use Symfony\Component\HttpFoundation\Request;

/**
 * @author juanchopx2
 */
class TMDbController {

    /**
     *
     */
    public function indexAction(Request $request, Application $app) {
        return true;
    }
}
?>