<?php

namespace LeadScore\Resource;

use LeadScore\LeadScore;

/**
 * Class Stages
 *
 * @package LeadScore\Resource
 */
class Stages {

	private $LeadScore;

	public function __construct(LeadScore $LeadScore) {
		$this->LeadScore = $LeadScore;
	}

	/**
	 * Get all stages for site, ordered by sorting key
	 *
	 * @return array Stages for site
	 *
	 * @throws \Exception Throws if unhandled Guzzle exception is thrown
	 * @throws \LeadScore\Exception\BadRequestException Throws if request apears malformed
	 * @throws \LeadScore\Exception\UnauthorizedException Throws if API key authorization failed
	 */
	public function view() {
		$options = [];

		return $this->LeadScore->call('/stages', 'get', $options);
	}
}
