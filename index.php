<!DOCTYPE html>
<html lang="en">
    <head>
        <title>Alert Logic PHP Test</title>

        <!-- Bootstrap -->
        <link href="assets/css/lib/bootstrap.min.css" rel="stylesheet" media="screen">
        <link href="assets/css/lib/bootstrap-responsive.min.css" rel="stylesheet" media="screen">
        <link href="assets/css/al-php-test.css" rel="stylesheet" media="screen">
    </head>
    <body>
        <div id="container" class="container-fluid">
            <div class="row-fluid">
                <div id="search-container" class="span12">
                    <div class="span9 offset3">
                        <input id="search-actor-name" name="n" type="text" class="span6" placeholder="Actor's name">
                        <button id="search-button" class="btn btn-primary btn-large">Search</button>
                    </div>
                </div>
            </div>

            <div id="content" class="row-fluid">
                <div id="actor-credits" class="span12">
                    <div class="span4">
                        <div class="hero-unit"></div>
                    </div>

                    <div class="row-fluid">
                        <div id="credits-list" class="span8"></div>
                    </div>
                </div>
            </div>
        </div>

        <!-- jQuery -->
        <script src="//ajax.googleapis.com/ajax/libs/jquery/2.0.3/jquery.min.js"></script>
        <!-- Bootstrap -->
        <script src="assets/js/lib/bootstrap.min.js"></script>
        <script src="assets/js/al-php-test.js"></script>
    </body>
</html>