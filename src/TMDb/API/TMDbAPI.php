<?php
namespace TMDb\API;

use Guzzle\Http\Client;

/**
 * @author juanchopx2
 */
class TMDbAPI {
    const API_SCHEME  = 'https://';
    const API_URL     = 'api.themoviedb.org';
    const API_VERSION = '3';
    const API_KEY     = '6425ff98fc0c954273045edc360b9e77';

    protected $apiKey;
    protected $restClient;
    protected $headers;

    private static $instance;

    /**
     *
     */
    private function __construct() {
        $this->apiKey = array('api_key' => TMDbAPI::API_KEY);

        $this->restClient = new Client(TMDbAPI::API_SCHEME . TMDbAPI::API_URL . '/' . TMDbAPI::API_VERSION);

        $this->headers = array(
            'Accept' => 'application/json'
        );
    }

    /**
     *
     */
    public static function getInstance() {
        if (self::$instance === null) {
            self::$instance = new TMDbAPI();
        }

        return self::$instance;
    }

    /**
     *
     */
    public function searchPerson($query, $page = 1, $adult = FALSE) {
        $params = array(
            'query' => $query,
            'page' => (int) $page,
            'include_adult' => (bool) $adult,
        );

        return $this->apiRequest('search/person', $params);
    }

    /**
     *
     */
    public function getPersonGeneralInfo($personId) {
        return $this->apiRequest('person/' . $personId);
    }

    /**
     *
     */
    public function searchPersonCredits($personId) {
        return $this->apiRequest('person/' . $personId . '/credits');
    }

    /**
     *
     */
    public function searchMovie($query, $page = 1, $adult = FALSE) {
        $params = array(
            'query' => $query,
            'page' => (int) $page,
            'include_adult' => (bool) $adult,
        );

        return $this->apiRequest('search/movie', $params);
    }

    /**
     *
     */
    public function getMovieBasicInfo($movieId) {
        return $this->apiRequest('movie/' . $movieId);
    }

    /**
     *
     */
    private function apiRequest($uri, $params = array()) {
        return $this->restClient->get($uri . '?' . http_build_query($params) . '&' . http_build_query($this->apiKey), $this->headers)->send()->getBody();
    }
}
