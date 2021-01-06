<?php

namespace LeadScore\Resource;

use LeadScore\LeadScore;

/**
 * Class Lead
 *
 * @package LeadScore\Resource
 */
class Lead {

	private $LeadScore;

	public function __construct(LeadScore $LeadScore) {
		$this->LeadScore = $LeadScore;
	}

	/**
	 * Get all lead- and customfields for site, customfields are ordered by sorting key
	 *
	 * @return array Lead- and customfields
	 *
	 * @throws \Exception Throws if unhandled Guzzle exception is thrown
	 * @throws \LeadScore\Exception\BadRequestException Throws if request apears malformed
	 * @throws \LeadScore\Exception\UnauthorizedException Throws if API key authorization failed
	 */
	public function fields() {
		$options = [];

		return $this->LeadScore->call('/lead/fields', 'get', $options);
	}

	/**
	 * Add lead with key-value paired fields, stage ID, owner ID, segment ID and whether or not to sync with 3rd party services, lead key is returned
	 *
	 * ```
	 * $fields = [
	 *     'email'       => 'name@example.com', // Email address
	 *     'full_name'   => 'John Doe',         // Full name (Converts the name into first and last name)
	 *     'first_name'  => 'John',             // First name
	 *     'last_name'   => 'Doe',              // Last name
	 *     'title'       => 'Customer',         // Title
	 *     'company'     => 'LeadScore App',    // Company
	 *     'address'     => 'Bredgade 1',       // Address
	 *     'zip'         => '7400',             // Zip code
	 *     'city'        => 'Herning',          // City
	 *     'country'     => 'Denmark',          // Country
	 *     'phone'       => '12345678',         // Phone
	 *     'description' => 'Lorem ipsum',      // Description
	 *     '42'          => '1.000,- DKK'       // Customfield "Budget" with customfield ID '42'
	 * ];
	 * ```
	 *
	 * @param array $fields Fields
	 * @param int $stage_id Stage ID
	 * @param int $owner_id Owner ID
	 * @param int $segment_id Segment ID
	 * @param int $sync Sync, 1 to enable sync with 3rd party services, 0 for disabled
	 *
	 * @return array Lead key
	 *
	 * @throws \Exception Throws if unhandled Guzzle exception is thrown
	 * @throws \LeadScore\Exception\BadRequestException Throws if request apears malformed
	 * @throws \LeadScore\Exception\UnauthorizedException Throws if API key authorization failed
	 */
	public function add($fields, $stage_id = null, $owner_id = null, $segment_id = null, $sync = null) {
		$options = [
			'form_params' => [
				'fields' => $fields
			]
		];

		/**
		 * Stage ID
		 */
		if (isset($stage_id)) {
			$options['form_params']['stage_id'] = $stage_id;
		}

		/**
		 * Owner ID
		 */
		if (isset($owner_id)) {
			$options['form_params']['owner_id'] = $owner_id;
		}

		/**
		 * Segment ID
		 */
		if (isset($segment_id)) {
			$options['form_params']['segment_id'] = $segment_id;
		}

		/**
		 * Sync
		 */
		if (isset($sync)) {
			$options['form_params']['sync'] = $sync;
		}

		return $this->LeadScore->call('/lead', 'post', $options);
	}

	/**
	 * Change stage for one or more leads
	 *
	 * ```
	 * $leads = [
	 *     [
	 *         'id' => 42                                   // Lead ID
	 *     ],
	 *     [
	 *         'key' => '8001083940a98db179c0473d9bc75ccf'  // Lead key
	 *     ],
	 *     [
	 *         'email' => 'name@example.com'                // Lead email address
	 *     ],
	 * ];
	 * ```
	 *
	 * @param array $leads Leads
	 * @param int $stage_id Stage ID
	 *
	 * @return array Result of stage change
	 *
	 * @throws \Exception Throws if unhandled Guzzle exception is thrown
	 * @throws \LeadScore\Exception\BadRequestException Throws if request appears malformed
	 * @throws \LeadScore\Exception\UnauthorizedException Throws if API key authorization failed
	 */
	public function stage($leads, $stage_id) {
		$options = [
			'query' => [
				'leads'    => $leads,
				'stage_id' => $stage_id
			]
		];

		return $this->LeadScore->call('/lead/stage', 'put', $options);
	}

	/**
	 * Add one or more leads to a segment
	 *
	 * ```
	 * $leads = [
	 *     [
	 *         'id' => 42                                   // Lead ID
	 *     ],
	 *     [
	 *         'key' => '8001083940a98db179c0473d9bc75ccf'  // Lead key
	 *     ],
	 *     [
	 *         'email' => 'name@example.com'                // Lead email address
	 *     ],
	 * ];
	 * ```
	 *
	 * @param array $leads Leads
	 * @param int $segment_id Segment ID
	 *
	 * @return array Result of adding to segment
	 *
	 * @throws \Exception Throws if unhandled Guzzle exception is thrown
	 * @throws \LeadScore\Exception\BadRequestException Throws if request appears malformed
	 * @throws \LeadScore\Exception\UnauthorizedException Throws if API key authorization failed
	 */
	public function addToSegment($leads, $segment_id) {
		$options = [
			'query' => [
				'leads'    => $leads,
				'segment_id' => $segment_id
			]
		];

		return $this->LeadScore->call('/lead/segment', 'post', $options);
	}

	/**
	 * Remove one or more leads from a segment
	 *
	 * ```
	 * $leads = [
	 *     [
	 *         'id' => 42                                   // Lead ID
	 *     ],
	 *     [
	 *         'key' => '8001083940a98db179c0473d9bc75ccf'  // Lead key
	 *     ],
	 *     [
	 *         'email' => 'name@example.com'                // Lead email address
	 *     ],
	 * ];
	 * ```
	 *
	 * @param array $leads Leads
	 * @param int $segment_id Segment ID
	 *
	 * @return array Result of adding to segment
	 *
	 * @throws \Exception Throws if unhandled Guzzle exception is thrown
	 * @throws \LeadScore\Exception\BadRequestException Throws if request appears malformed
	 * @throws \LeadScore\Exception\UnauthorizedException Throws if API key authorization failed
	 */
	public function removeFromSegment($leads, $segment_id) {
		$options = [
			'query' => [
				'leads'    => $leads,
				'segment_id' => $segment_id
			]
		];

		return $this->LeadScore->call('/lead/segment', 'delete', $options);
	}

	/**
	 * @param array       $leads Leads
	 * @param string      $note  Note content
	 * @param int|null    $score Score to adjust lead by
	 * @param string|null $type  Note type ('mail', 'phone' or 'meeting')
	 *
	 * @return array Result of adding note to one or more leads
	 *
	 * @throws \Exception Throws if unhandled Guzzle exception is thrown
	 * @throws \LeadScore\Exception\BadRequestException Throws if request appears malformed
	 * @throws \LeadScore\Exception\UnauthorizedException Throws if API key authorization failed
	 */
	public function addNote($leads, $note, $score = null, $type = null) {
		$options = [
			'form_params' => [
				'leads' => $leads,
				'note'  => $note
			]
		];

		/**
		 * Score
		 */
		if (isset($score)) {
			$options['form_params']['score'] = $score;
		}

		/**
		 * Type
		 */
		if (isset($type)) {
			$options['form_params']['type'] = $type;
		}

		return $this->LeadScore->call('/lead/note', 'post', $options);
	}

	/**
	 * Applies Leadscore App tracking code, also supports adding of Google Analytics campaign name
	 *
	 * @param string $html HTML content
	 * @param array $domains Domains as numeric array
	 * @param string $key Lead key
	 * @param string|null $GAcampaign Google Analytics campaign name
	 *
	 * @return string HTML content
	 *
	 * @throws \Exception Throws if unhandled Guzzle exception is thrown
	 * @throws \LeadScore\Exception\BadRequestException Throws if request apears malformed
	 * @throws \LeadScore\Exception\UnauthorizedException Throws if API key authorization failed
	 */
	public function applyTrackingCodes($html, array $domains, $key, $GAcampaign = null) {
		preg_match_all('#href=\"(.*?)\"#', $html, $matches);

		/**
		 * Check if we have any href's to match
		 */
		if (isset($matches[1]) && is_array($matches)) {
			/**
			 * LeadScore App tracking parameter
			 */
			$tracking[] = "__lsk=$key";

			/**
			 * Google Analytics campaign tracking parameters
			 */
			if (!empty($GAcampaign)) {
				$tracking[] = 'utm_source=leadscoreapp';
				$tracking[] = 'utm_medium=e-mail';
				$tracking[] = "utm_campaign=$GAcampaign";
			}

			/**
			 * Go though all href matches
			 */
			foreach ($matches[1] as $match) {
				/**
				 * Skip mailto
				 */
				if (strstr($match, 'mailto:')) {
					continue;
				}

				/**
				 * Skip other domains then those added as site hosts
				 */
				$ownDomain = false;

				foreach ($domains as $domain) {
					if (strstr($match, $domain)) {
						$ownDomain = true;

						break;
					}
				}

				if ($ownDomain) {
					/**
					 * Detect querystring
					 */
					$operator = strstr($match, '?') ? '&' : '?';

					/**
					 * Perform replacement
					 */
					$html = str_replace(sprintf('"%s"', $match), sprintf('"%s%s%s"', $match, $operator, implode('&', $tracking)), $html);
				}
			}
		}

		return $html;
	}
}
