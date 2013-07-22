<?php
/**
* @author juanchopx2
*/
require_once dirname(__FILENAME__) . '/classes/TMDbAPI.php';

$tmdb_api = new TMDbAPI('6425ff98fc0c954273045edc360b9e77');

$person = json_decode($tmdb_api->searchPerson($_GET['name']));
$person_info = $tmdb_api->getPersonGeneralInfo($person->results[0]->id);
$credits = $tmdb_api->searchPersonCredits($person->results[0]->id);

echo '{"info": ' . $person_info . ', "credits": ' . $credits . '}';
?>