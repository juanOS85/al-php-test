<?php
namespace TMDb\API;

use Guzzle\Http\Client;

/**
 * @author juanchopx2
 */
class TMDbAPI {
    const API_SCHEME = 'http://';
    const API_URL = 'api.themoviedb.org';
    const API_VERSION = '3';

    protected $apiKey;
    protected $restClient;
    protected $headers;

    /**
     *
     */
    function __construct($apiKey) {
        $this->apiKey = array('api_key' => $apiKey);

        $this->restClient = new Client(TMDbAPI::API_SCHEME . TMDbAPI::API_URL . '/' . TMDbAPI::API_VERSION);

        $this->headers = array(
            'Accept' => 'application/json'
        );
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
    private function apiRequest($uri, $params = array()) {
        return $this->restClient->get($uri . '?' . http_build_query($params) . '&' . http_build_query($this->apiKey), $this->headers)->send()->getBody();
    }
}
