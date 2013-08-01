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

    /**
     * @var mixed
     */
    protected $restClient;

    /**
     * @var string HTTP headers for request to TMDb API
     */
    protected $headers;

    /**
     * @var TMDbAPI
     */
    private static $instance;

    /**
     * Constructor
     */
    private function __construct() {
        $this->apiKey = array('api_key' => TMDbAPI::API_KEY);

        $this->restClient = new Client(TMDbAPI::API_SCHEME . TMDbAPI::API_URL . '/' . TMDbAPI::API_VERSION);

        $this->headers = array(
            'Accept' => 'application/json'
        );
    }

    /**
     * Singleton pattern to get instance this class just once
     *
     * @return TMDb instance
     */
    public static function getInstance() {
        if (self::$instance === null) {
            self::$instance = new TMDbAPI();
        }

        return self::$instance;
    }

    /**
     * Search actor/actress by his/her name
     *
     * @param string $query name of the actor/actress
     * @param integer $page
     * @param bool $adult Filter query for adult content
     * @return string API JSON response with actors/actresses information
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
     * Get actor/actress basic information
     *
     * @param integer $personId Actor/actress TMDb ID
     * @return string API JSON response with actor/actress base information
     */
    public function getPersonGeneralInfo($personId) {
        return $this->apiRequest('person/' . $personId);
    }

    /**
     * Search actor/actress credits
     *
     * @param integer $personId Actor/actress TMDb ID
     * @return string API JSON response with actor/actress credits list
     */
    public function searchPersonCredits($personId) {
        return $this->apiRequest('person/' . $personId . '/credits');
    }

    /**
     * Search movie by its name.
     *
     * @param string $query movie name
     * @param integer $page
     * @param bool $adult Filter query for adult content
     * @return string API JSON response with movie information
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
     * Get movie information
     *
     * @param integer $movieId Movie TMDb ID
     * @return string API JSON response with movie information
     */
    public function getMovieBasicInfo($movieId) {
        return $this->apiRequest('movie/' . $movieId);
    }

    /**
     * Petition thorugh GET method to retreive information from TMDb API.
     *
     * @param string $url TMDb function
     * @param mixed $params TMDb functions params
     * @return string API JSON with requested data
     */
    private function apiRequest($uri, $params = array()) {
        return $this->restClient->get($uri . '?' . http_build_query($params) . '&' . http_build_query($this->apiKey), $this->headers)->send()->getBody();
    }
}
