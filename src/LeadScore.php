<?php

namespace LeadScore;

use LeadScore\Resource;
use LeadScore\Exception;
use GuzzleHttp;
use Psr\Http\Message\ResponseInterface;

/**
 * Class LeadScore
 *
 * @package LeadScore
 */
class LeadScore {

	private $api_key;
	private $root = 'https://www.leadscoreapp.dk/2.0';
	private $client;

	/**
	 * @param string $api_key LeadScore App API key
	 */
	public function __construct($api_key) {
		/**
		 * Set API key
		 */
		$this->api_key = $api_key;

		/**
		 * Assign resources
		 */
		$this->deals    = new Resource\Deals($this);
		$this->lead     = new Resource\Lead($this);
		$this->owners   = new Resource\Owners($this);
		$this->segments = new Resource\Segments($this);
		$this->stages   = new Resource\Stages($this);

		/**
		 * Client
		 */
        $this->client = new GuzzleHttp\Client();
	}

	/**
	 * Call API directly
	 *
	 * @param string $resource Resource (Lead, Owners, Segments, Stages etc.)
	 * @param string $method Method (post, get etc.)
	 * @param array $options Guzzle options
	 *
	 * @throws Exception\MethodNotAllowedException Throws if method is not allowed
	 * @throws Exception\BadRequestException Throws if request apears malformed
	 * @throws Exception\UnauthorizedException Throws if API key authorization failed
	 * @throws \Exception Throws if unhandled Guzzle exception is thrown
	 *
	 * @return mixed Response
	 */
	public function call($resource, $method, $options) {
		try {
            $options['headers']['api_key'] = $this->api_key;

            $response = $this->client->request($method, "$this->root$resource.json", $options);
            
			return json_decode($response->getBody());
		} catch (GuzzleHttp\Exception\ClientException $e) {
            /**
             * @var ResponseInterface $response
             */
            $response = $e->getResponse();

			switch ($response->getStatusCode()) {
				case 400:
					throw new Exception\BadRequestException(json_decode($response->getBody(), true)['error']);

				case 401:
					throw new Exception\UnauthorizedException(json_decode($response->getBody(), true)['error']);

				case 405:
					throw new Exception\MethodNotAllowedException(json_decode($response->getBody(), true)['error']);

				default:
					throw new \Exception(json_decode($response->getBody(), true)['error']);
			}
		}
	}
}
