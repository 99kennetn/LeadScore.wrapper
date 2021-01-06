<?php

namespace LeadScore\Resource;

use LeadScore\LeadScore;

/**
 * Class Deals
 *
 * @package LeadScore\Resource
 */
class Deals {

	private $LeadScore;

	public function __construct(LeadScore $LeadScore) {
		$this->LeadScore = $LeadScore;
	}

    /**
     * Add product deal, will skip creation if slug is already existing, returns ID of deal product
     *
     * @param string   $name     Deal product name
     * @param string   $slug     Deal product slug
     * @param int|null $dealMax  Max deals per product
     * @param int|null $statusId Deal product status ID
     *
     * @return array Deal product ID
     *
     * @throws \Exception Throws if unhandled Guzzle exception is thrown
     * @throws \LeadScore\Exception\BadRequestException Throws if request apears malformed
     * @throws \LeadScore\Exception\UnauthorizedException Throws if API key authorization failed
     */
    public function addProduct($name, $slug, $dealMax = null, $statusId = null) {
        $options = [
            'form_params' => [
                'name'     => $name,
                'slug'     => $slug,
                'deal_max'  => $dealMax,
                'status_id' => $statusId
            ]
        ];

        return $this->LeadScore->call('/deals/products', 'post', $options);
    }

    /**
     * Add deal for one or more deal products for one or more leads
     *
     * ```
     * $leads => [
     *     [
     *         'id' => 42,
     *     ],
     *     [
     *         'key' => '8001083940a98db179c0473d9bc75ccf',
     *     ],
     *     [
     *         'email' => 'name@example.com',
     *     ]
     * ];
     *
     * $dealProducts => [
     *     [
     *         'id' => 42,
     *     ],
     *     [
     *         'slug' => 'lorem_ipsum',
     *     ]
     * ];
     * ```
     *
     * @param array       $leads        Leads
     * @param int         $userId       User ID
     * @param array       $dealProducts Deal products
     * @param int         $saleValue    Sale value
     * @param string      $name         Deal name
     * @param string|null $note         Deal note
     * @param string|null $internalNote Deal internal note
     * @param int|null    $statusId     Deal status ID
     * @param array       $fields       Deal field values
     *
     * @return array Status
     *
     * @throws \Exception Throws if unhandled Guzzle exception is thrown
     * @throws \LeadScore\Exception\BadRequestException Throws if request apears malformed
     * @throws \LeadScore\Exception\UnauthorizedException Throws if API key authorization failed
     */
    public function addToLead($leads, $userId, $dealProducts, $saleValue, $name, $note = null, $internalNote = null, $statusId = null, $fields = []) {
        $options = [
            'form_params' => [
                'leads'         => $leads,
                'user_id'       => $userId,
                'deal_products' => $dealProducts,
                'sale_value'    => $saleValue,
                'name'          => $name,
                'note'          => $note,
                'internal_note' => $internalNote,
                'status_id'     => $statusId,
                'fields'        => $fields
            ]
        ];

        return $this->LeadScore->call('/deals/leads', 'post', $options);
    }
}
