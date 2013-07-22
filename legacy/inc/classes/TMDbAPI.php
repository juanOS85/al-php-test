<?php
/**
 * @author juanchopx2
 */
class TMDbAPI {
    const POST = 'post';
    const GET = 'get';
    const API_SCHEME = 'http://';
    const API_URL = 'api.themoviedb.org';
    const API_VERSION = '3';

    /**
     * TMDb API Key
     */
    private $_apiKey;

    /**
     * constructor
     */
    function __construct($apiKey) {
        $this->_apiKey = (string) $apiKey;
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

        return $this->_apiRequest('search/person', $params);
    }

    /**
     *
     */
    public function getPersonGeneralInfo($personId) {
        return $this->_apiRequest('person/' . $personId);
    }

    /**
     *
     */
    public function searchPersonCredits($personId) {
        return $this->_apiRequest('person/' . $personId . '/credits');
    }

    /**
     *
     */
    private function _apiRequest($apiFunction, $params = array(), $method = TMDbAPI::GET) {
        $api_auth = array('api_key' => $this->_apiKey);
        $headers = array('Accept: application/json');

        $url = TMDbAPI::API_SCHEME . TMDbAPI::API_URL . '/' . TMDbAPI::API_VERSION . '/' . $apiFunction . '?' . http_build_query($api_auth, '', '&') ;

        if ($method === TMDbAPI::GET) {
            $url .= empty($params) ? '' : '&' . http_build_query($params, '', '&');
        }

        // echo $url;

        $ch = curl_init();

        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);

        $apiResponseJSON = curl_exec($ch);

        // print_r($apiResponseJSON);

        curl_close($ch);

        return $apiResponseJSON;
    }
}
?>