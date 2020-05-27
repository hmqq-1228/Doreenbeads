<?php

/**
 * Super-simple, minimum abstraction MailChimp API v3 wrapper
 * MailChimp API v3: http://developer.mailchimp.com
 * This wrapper: https://github.com/drewm/mailchimp-api
 *
 * @author Drew McLellan <drew.mclellan@gmail.com>
 * @version 2.2
 */
class MailChimp
{
    private $api_key;
    private $api_endpoint = 'https://<dc>.api.mailchimp.com/3.0';

    /*  SSL Verification
        Read before disabling:
        http://snippets.webaware.com.au/howto/stop-turning-off-curlopt_ssl_verifypeer-and-fix-your-php-config/
    */
    public $verify_ssl = false;

    private $request_successful = false;
    private $last_error         = '';
    private $last_response      = array();
    private $last_request       = array();

    /**
     * Create a new instance
     * @param string $api_key Your MailChimp API key
     * @throws \Exception
     */
    public function __construct($api_key)
    {
        $this->api_key = $api_key;

        if (strpos($this->api_key, '-') === false) {
            throw new \Exception("Invalid MailChimp API key `{$api_key}` supplied.");
        }

        list(, $data_center) = explode('-', $this->api_key);
        $this->api_endpoint  = str_replace('<dc>', $data_center, $this->api_endpoint);

        $this->last_response = array('headers' => null, 'body' => null);
    }

    /**
     * Create a new instance of a Batch request. Optionally with the ID of an existing batch.
     * @param string $batch_id Optional ID of an existing batch, if you need to check its status for example.
     * @return Batch            New Batch object.
     */
    public function new_batch($batch_id = null)
    {
        return new Batch($this, $batch_id);
    }

    /**
     * Convert an email address into a 'subscriber hash' for identifying the subscriber in a method URL
     * @param   string $email The subscriber's email address
     * @return  string          Hashed version of the input
     */
    public function subscriberHash($email)
    {
        return md5(strtolower($email));
    }

    /**
     * Was the last request successful?
     * @return bool  True for success, false for failure
     */
    public function success()
    {
        return $this->request_successful;
    }

    /**
     * Get the last error returned by either the network transport, or by the API.
     * If something didn't work, this should contain the string describing the problem.
     * @return  array|false  describing the error
     */
    public function getLastError()
    {
        return $this->last_error ?: false;
    }

    /**
     * Get an array containing the HTTP headers and the body of the API response.
     * @return array  Assoc array with keys 'headers' and 'body'
     */
    public function getLastResponse()
    {
        return $this->last_response;
    }

    /**
     * Get an array containing the HTTP headers and the body of the API request.
     * @return array  Assoc array
     */
    public function getLastRequest()
    {
        return $this->last_request;
    }

    /**
     * Make an HTTP DELETE request - for deleting data
     * @param   string $method URL of the API request method
     * @param   array $args Assoc array of arguments (if any)
     * @param   int $timeout Timeout limit for request in seconds
     * @return  array|false   Assoc array of API response, decoded from JSON
     */
    public function delete($method, $args = array(), $timeout = 10)
    {
        return $this->makeRequest('delete', $method, $args, $timeout);
    }

    /**
     * Make an HTTP GET request - for retrieving data
     * @param   string $method URL of the API request method
     * @param   array $args Assoc array of arguments (usually your data)
     * @param   int $timeout Timeout limit for request in seconds
     * @return  array|false   Assoc array of API response, decoded from JSON
     */
    public function get($method, $args = array(), $timeout = 10)
    {
        return $this->makeRequest('get', $method, $args, $timeout);
    }

    /**
     * Make an HTTP PATCH request - for performing partial updates
     * @param   string $method URL of the API request method
     * @param   array $args Assoc array of arguments (usually your data)
     * @param   int $timeout Timeout limit for request in seconds
     * @return  array|false   Assoc array of API response, decoded from JSON
     */
    public function patch($method, $args = array(), $timeout = 10)
    {
        return $this->makeRequest('patch', $method, $args, $timeout);
    }

    /**
     * Make an HTTP POST request - for creating and updating items
     * @param   string $method URL of the API request method
     * @param   array $args Assoc array of arguments (usually your data)
     * @param   int $timeout Timeout limit for request in seconds
     * @return  array|false   Assoc array of API response, decoded from JSON
     */
    public function post($method, $args = array(), $timeout = 10)
    {
        return $this->makeRequest('post', $method, $args, $timeout);
    }

    /**
     * Make an HTTP PUT request - for creating new items
     * @param   string $method URL of the API request method
     * @param   array $args Assoc array of arguments (usually your data)
     * @param   int $timeout Timeout limit for request in seconds
     * @return  array|false   Assoc array of API response, decoded from JSON
     */
    public function put($method, $args = array(), $timeout = 10)
    {
        return $this->makeRequest('put', $method, $args, $timeout);
    }

    /**
     * Get the list of interest groupings for a given list, including the label, form information, and included groups for each
     * @param string $id
     * @param bool $counts
     * @return array array of structs of the interest groupings for the list
     *     - id int The id for the Grouping
     *     - name string Name for the Interest groups
     *     - form_field string Gives the type of interest group: checkbox,radio,select
     *     - groups array Array structs of the grouping options (interest groups) including:
     *         - bit string the bit value - not really anything to be done with this
     *         - name string the name of the group
     *         - display_order string the display order of the group, if set
     *         - subscribers int total number of subscribers who have this group if "counts" is true. otherwise empty
     */
    public function interestGroupings($list_id, $args = array(), $timeout = 10) {
        return $this->makeRequest('get','lists/'.$list_id.'/interest-categories', $args);
    }

    /**
     * Get information about members in all list
     * @param   string $list_id The unique id for the list.
     * @param   string $email list member’s email address.
     * @param   array $args Assoc array of arguments (usually your data)
     * @param   int $timeout Timeout limit for request in seconds
     * @return  array|false   Assoc array of API response, decoded from JSON
     */
    public function getAllMembers($args=array(), $timeout = 10) 
    {
        return $this->makeRequest('get','lists', $args);
    }

    /**
     * Get information about members in a list
     * @param   string $list_id The unique id for the list.
     * @param   string $email list member’s email address.
     * @param   array $args Assoc array of arguments (usually your data)
     * @param   int $timeout Timeout limit for request in seconds
     * @return  array|false   Assoc array of API response, decoded from JSON
     */
    public function getMembers($list_id, $email='', $args=array(), $timeout = 10) 
    {
        if ($email != '') 
        {
            $email = $this->subscriberHash($email);
        }
        return $this->makeRequest('get','lists/'.$list_id.'/members/'.$email, $args);
    }

    /**
     * Post information about members in a list / Subscribe
     * @param   string $list_id The unique id for the list.
     * @param   string $email list member’s email address.
     * @param   array $args Assoc array of arguments (usually your data)
     * @param   int $timeout Timeout limit for request in seconds
     * @return  array|false   Assoc array of API response, decoded from JSON
     */
    public function subscribe($list_id, $email, $args=array(), $timeout = 10) 
    {
        $args['email_address'] = $email;
        $args['merge_fields'] = $args;
        $args['status'] = 'subscribed';
        $args['timestamp_signup'] = date('Y-m-d H:i:s');
        return $this->makeRequest('put','lists/'.$list_id.'/members/'. md5($email), $args);
    }

    /**
     * Post information about members in a list / Unsubscribe
     * @param   string $list_id The unique id for the list.
     * @param   string $email list member’s email address.
     * @param   array $args Assoc array of arguments (usually your data)
     * @param   int $timeout Timeout limit for request in seconds
     * @return  array|false   Assoc array of API response, decoded from JSON
     */
    public function unsubscribe($list_id, $email, $args=array(), $timeout = 10) 
    {
        $args['email_address'] = $email;
        if(!empty($args)) $args['merge_fields'] = $args;
        $args['status'] = 'unsubscribed';
        return $this->makeRequest('patch','lists/'.$list_id.'/members/'.$this->subscriberHash($email), $args);
    }

    /**
     * get information about store 
     * @param   string $store_id store id
     * @return  array|false   Assoc array of API response, decoded from JSON
     */
    public function getEcommerceStore($store_id) 
    {
        return $this->makeRequest('get','ecommerce/stores/'.$store_id);
    }

    /**
     * get information about Campaigns 
     * @param   string $campaigns_id Campaigns id
     * @return  array|false   Assoc array of API response, decoded from JSON
     */
    public function getCampaigns($campaigns_id) 
    {
        return $this->makeRequest('get','campaigns');
    }

    /**
     * create Store
     * @param   string $campaigns_id Campaigns id
     * @return  array|false   Assoc array of API response, decoded from JSON
     */
    public function createEcommerceStore($args) 
    {
        return $this->makeRequest('post','ecommerce/stores', $args);
    }

    /**
     * add orders to store
     * @param   array $args 
     * @return  array|false   Assoc array of API response, decoded from JSON
     */
    public function addEcommerceOrder($store_id, $args) 
    {
        return $this->makeRequest('post','ecommerce/stores/'.$store_id.'/orders', $args);
    }

    /**
     * add,post,patch products to Store
     * @param   array $args
     * @return  array|false   Assoc array of API response, decoded from JSON
    */
    public function operateEcommerceProducts($method, $store_id, $products_id, $args) 
    {   
        if ($products_id != '') {
           $products_id = '/'.$products_id;
        }
        return $this->makeRequest($method,'ecommerce/stores/'.$store_id.'/products'.$products_id, $args);
    }

    /**
     * Performs the underlying HTTP request. Not very exciting.
     * @param  string $http_verb The HTTP verb to use: get, post, put, patch, delete
     * @param  string $method The API method to be called
     * @param  array $args Assoc array of parameters to be passed
     * @param int $timeout
     * @return array|false Assoc array of decoded result
     * @throws \Exception
     */
    private function makeRequest($http_verb, $method, $args = array(), $timeout = 10)
    {
        if (!function_exists('curl_init') || !function_exists('curl_setopt')) {
            throw new \Exception("cURL support is required, but can't be found.");
        }

        $url = $this->api_endpoint . '/' . $method;

        $this->last_error         = '';
        $this->request_successful = false;
        $response                 = array('headers' => null, 'body' => null);
        $this->last_response      = $response;

        $this->last_request = array(
            'method'  => $http_verb,
            'path'    => $method,
            'url'     => $url,
            'body'    => '',
            'timeout' => $timeout,
        );
//echo $url;
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_HTTPHEADER, array(
            'Accept: application/vnd.api+json',
            'Content-Type: application/vnd.api+json',
            'Authorization: apikey ' . $this->api_key
        ));
        curl_setopt($ch, CURLOPT_USERAGENT, 'MailChimp-API/3.0');
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_TIMEOUT, $timeout);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, $this->verify_ssl);
        //curl_setopt($ch, CURLOPT_HTTP_VERSION, CURL_HTTP_VERSION_1_0);
        curl_setopt($ch, CURLOPT_ENCODING, '');
        curl_setopt($ch, CURLINFO_HEADER_OUT, true);

        switch ($http_verb) {
            case 'post':
                curl_setopt($ch, CURLOPT_POST, true);
                $this->attachRequestPayload($ch, $args);
                break;

            case 'get':
                $query = http_build_query($args, '', '&');
                curl_setopt($ch, CURLOPT_URL, $url . '?' . $query);
                break;

            case 'delete':
                curl_setopt($ch, CURLOPT_CUSTOMREQUEST, 'DELETE');
                break;

            case 'patch':
                curl_setopt($ch, CURLOPT_CUSTOMREQUEST, 'PATCH');
                $this->attachRequestPayload($ch, $args);
                break;

            case 'put':
                curl_setopt($ch, CURLOPT_CUSTOMREQUEST, 'PUT');
                $this->attachRequestPayload($ch, $args);
                break;
        }

        $response['body']    = curl_exec($ch);
        $response['headers'] = curl_getinfo($ch);
//print_r($response);
        if (isset($response['headers']['request_header'])) {
            $this->last_request['headers'] = $response['headers']['request_header'];
        }

        if ($response['body'] === false) {
            $this->last_error = curl_error($ch);
        }

        curl_close($ch);

        $formattedResponse = $this->formatResponse($response);

        $this->determineSuccess($response, $formattedResponse);

        return $formattedResponse;
    }
    
    /**
     * @return string The url to the API endpoint
     */
    public function getApiEndpoint()
    {
        return $this->api_endpoint;
    }

    /**
     * Encode the data and attach it to the request
     * @param   resource $ch cURL session handle, used by reference
     * @param   array $data Assoc array of data to attach
     */
    private function attachRequestPayload(&$ch, $data)
    {
        $encoded = json_encode($data);
        $this->last_request['body'] = $encoded;
        curl_setopt($ch, CURLOPT_POSTFIELDS, $encoded);
    }

    /**
     * Decode the response and format any error messages for debugging
     * @param array $response The response from the curl request
     * @return array|false    The JSON decoded into an array
     */
    private function formatResponse($response)
    {
        $this->last_response = $response;

        if (!empty($response['body'])) {
            return json_decode($response['body'], true);
        }

        return false;
    }

    /**
     * Check if the response was successful or a failure. If it failed, store the error.
     * @param array $response The response from the curl request
     * @param array|false $formattedResponse The response body payload from the curl request
     * @return bool     If the request was successful
     */
    private function determineSuccess($response, $formattedResponse)
    {
        $status = $this->findHTTPStatus($response, $formattedResponse);

        if ($status >= 200 && $status <= 299) {
            $this->request_successful = true;
            return true;
        }

        if (isset($formattedResponse['detail'])) {
            $this->last_error = sprintf('%d: %s', $formattedResponse['status'], $formattedResponse['detail']);
            return false;
        }

        $this->last_error = 'Unknown error, call getLastResponse() to find out what happened.';
        return false;
    }

    /**
     * Find the HTTP status code from the headers or API response body
     * @param array $response The response from the curl request
     * @param array|false $formattedResponse The response body payload from the curl request
     * @return int  HTTP status code
     */
    private function findHTTPStatus($response, $formattedResponse)
    {
        if (!empty($response['headers']) && isset($response['headers']['http_code'])) {
            return (int) $response['headers']['http_code'];
        }

        if (!empty($response['body']) && isset($formattedResponse['status'])) {
            return (int) $formattedResponse['status'];
        }

        return 418;
    }

    
}

