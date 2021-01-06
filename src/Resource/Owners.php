<?php

namespace LeadScore\Resource;

use LeadScore\LeadScore;

/**
 * Class Owners
 *
 * @package LeadScore\Resource
 */
class Owners {

	private $LeadScore;

	public function __construct(LeadScore $LeadScore) {
		$this->LeadScore = $LeadScore;
	}

	/**
	 * Get all owners for site
	 *
	 * @return array Owners for site
	 *
	 * @throws \Exception Throws if unhandled Guzzle exception is thrown
	 * @throws \LeadScore\Exception\BadRequestException Throws if request apears malformed
	 * @throws \LeadScore\Exception\UnauthorizedException Throws if API key authorization failed
	 */
	public function view() {
		$options = [];

		return $this->LeadScore->call('/owners', 'get', $options);
	}
}
