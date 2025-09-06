<?php
declare(strict_types=1);

namespace Kcfbricks\PhpBricklinkSdk\Testing;

/**
 * Provides mock responses for BrickLink API endpoints
 */
class MockResponseProvider {
	private array $customResponses = [];
	private bool $useRealisticData = true;

	public function __construct(bool $useRealisticData = true) {
		$this->useRealisticData = $useRealisticData;
	}

	/**
	 * Get a mock response for a given API endpoint
	 */
	public function getResponse(string $url, string $method = 'GET', array $options = []): array {
		// Check for custom responses first
		$key = strtoupper($method) . ' ' . $url;
		if (isset($this->customResponses[$key])) {
			return $this->customResponses[$key];
		}

		// Generate default responses based on endpoint
		return $this->generateDefaultResponse($url, $method, $options);
	}

	/**
	 * Set a custom response for a specific endpoint
	 */
	public function setCustomResponse(string $url, array $response, string $method = 'GET'): void {
		$key                         = strtoupper($method) . ' ' . $url;
		$this->customResponses[$key] = $response;
	}

	/**
	 * Clear all custom responses
	 */
	public function clearCustomResponses(): void {
		$this->customResponses = [];
	}

	/**
	 * Generate default mock responses based on URL patterns
	 */
	private function generateDefaultResponse(string $url, string $method, array $options): array {
		// Orders list endpoint
		if (preg_match('/^orders(\?.*)?$/', $url)) {
			return $this->getOrdersListResponse();
		}

		// Single order endpoint
		if (preg_match('/^orders\/(\d+)$/', $url, $matches)) {
			$orderId = (int)$matches[1];
			return $this->getSingleOrderResponse($orderId);
		}

		// Order items endpoint
		if (preg_match('/^orders\/(\d+)\/items$/', $url, $matches)) {
			$orderId = (int)$matches[1];
			return $this->getOrderItemsResponse($orderId);
		}

		// Order status update
		if (preg_match('/^orders\/(\d+)\/status$/', $url) && $method === 'PUT') {
			return $this->getSuccessResponse();
		}

		// Order update
		if (preg_match('/^orders\/(\d+)$/', $url) && $method === 'PUT') {
			return $this->getSuccessResponse();
		}

		// Drive thru
		if (preg_match('/^orders\/(\d+)\/drive_thru$/', $url) && $method === 'POST') {
			return $this->getSuccessResponse();
		}

		// Default response for unknown endpoints
		return [
			'status' => 404,
			'body'   => [
				'meta' => [
					'description' => 'Resource not found',
					'code'        => 404,
				],
			],
		];
	}

	/**
	 * Generate mock orders list response
	 */
	private function getOrdersListResponse(): array {
		if (!$this->useRealisticData) {
			return [
				'status' => 200,
				'body'   => [
					'meta' => [
						'description' => 'OK',
						'code'        => 200,
					],
					'data' => [],
				],
			];
		}

		return [
			'status' => 200,
			'body'   => [
				'meta' => [
					'description' => 'OK',
					'code'        => 200,
				],
				'data' => [
					[
						'order_id'            => 12345,
						'date_ordered'        => '2024-01-15T10:30:00.000Z',
						'date_status_changed' => '2024-01-15T10:30:00.000Z',
						'seller_name'         => 'TestSeller',
						'store_name'          => 'Test Store',
						'buyer_name'          => 'TestBuyer',
						'buyer_email'         => 'buyer@example.com',
						'buyer_order_count'   => 5,
						'status'              => 'RECEIVED',
						'total_count'         => 25,
						'unique_count'        => 15,
						'total_weight'        => '150.5',
						'base_grand_total'    => '45.50',
						'grand_total'         => '52.75',
						'cost'                => [
							'subtotal'    => '45.50',
							'grand_total' => '52.75',
							'etc1'        => '0.00',
							'etc2'        => '0.00',
							'insurance'   => '2.25',
							'shipping'    => '5.00',
							'credit'      => '0.00',
							'coupon'      => '0.00',
						],
						'disp_cost' => [
							'subtotal'    => 'US $45.50',
							'grand_total' => 'US $52.75',
							'etc1'        => 'US $0.00',
							'etc2'        => 'US $0.00',
							'insurance'   => 'US $2.25',
							'shipping'    => 'US $5.00',
							'credit'      => 'US $0.00',
							'coupon'      => 'US $0.00',
						],
						'payment' => [
							'method'        => 'PayPal',
							'currency_code' => 'USD',
							'date_paid'     => '2024-01-15T11:00:00.000Z',
							'status'        => 'Received',
						],
						'shipping' => [
							'method'       => 'Standard Mail',
							'date_shipped' => null,
							'tracking_no'  => '',
							'address'      => [
								'name' => [
									'full'  => 'Test Buyer',
									'first' => 'Test',
									'last'  => 'Buyer',
								],
								'full'         => '123 Test Street\nTestville, TS 12345\nNew Zealand',
								'address1'     => '123 Test Street',
								'address2'     => '',
								'city'         => 'Testville',
								'state'        => 'TS',
								'postal_code'  => '12345',
								'country_code' => 'NZ',
							],
						],
					],
				],
			],
		];
	}

	/**
	 * Generate mock single order response
	 */
	private function getSingleOrderResponse(int $orderId): array {
		if (!$this->useRealisticData) {
			return [
				'status' => 200,
				'body'   => [
					'meta' => [
						'description' => 'OK',
						'code'        => 200,
					],
					'data' => [
						'order_id' => $orderId,
					],
				],
			];
		}

		// Use the same data as orders list but for single order
		$ordersResponse        = $this->getOrdersListResponse();
		$orderData             = $ordersResponse['body']['data'][0];
		$orderData['order_id'] = $orderId;

		return [
			'status' => 200,
			'body'   => [
				'meta' => [
					'description' => 'OK',
					'code'        => 200,
				],
				'data' => $orderData,
			],
		];
	}

	/**
	 * Generate mock order items response
	 */
	private function getOrderItemsResponse(int $orderId): array {
		if (!$this->useRealisticData) {
			return [
				'status' => 200,
				'body'   => [
					'meta' => [
						'description' => 'OK',
						'code'        => 200,
					],
					'data' => [],
				],
			];
		}

		return [
			'status' => 200,
			'body'   => [
				'meta' => [
					'description' => 'OK',
					'code'        => 200,
				],
				'data' => [
					'0' => [ // Batch 0
						[
							'inventory_id' => 123456,
							'item'         => [
								'no'          => '3001',
								'name'        => 'Brick 2 x 4',
								'type'        => 'PART',
								'category_id' => 5,
							],
							'color_id'              => 5,
							'color_name'            => 'Red',
							'quantity'              => 10,
							'new_or_used'           => 'N',
							'completeness'          => null,
							'unit_price'            => '0.05',
							'unit_price_final'      => '0.05',
							'disp_unit_price'       => 'US $0.05',
							'disp_unit_price_final' => 'US $0.05',
							'currency_code'         => 'USD',
							'description'           => 'Excellent condition',
							'remarks'               => 'From smoke-free home',
						],
						[
							'inventory_id' => 123457,
							'item'         => [
								'no'          => '3002',
								'name'        => 'Brick 2 x 3',
								'type'        => 'PART',
								'category_id' => 5,
							],
							'color_id'              => 1,
							'color_name'            => 'White',
							'quantity'              => 5,
							'new_or_used'           => 'N',
							'completeness'          => null,
							'unit_price'            => '0.07',
							'unit_price_final'      => '0.07',
							'disp_unit_price'       => 'US $0.07',
							'disp_unit_price_final' => 'US $0.07',
							'currency_code'         => 'USD',
							'description'           => 'Like new',
							'remarks'               => '',
						],
					],
					'1' => [ // Batch 1
						[
							'inventory_id' => 123458,
							'item'         => [
								'no'          => '3003',
								'name'        => 'Brick 2 x 2',
								'type'        => 'PART',
								'category_id' => 5,
							],
							'color_id'              => 4,
							'color_name'            => 'Blue',
							'quantity'              => 8,
							'new_or_used'           => 'N',
							'completeness'          => null,
							'unit_price'            => '0.04',
							'unit_price_final'      => '0.04',
							'disp_unit_price'       => 'US $0.04',
							'disp_unit_price_final' => 'US $0.04',
							'currency_code'         => 'USD',
							'description'           => 'Good condition',
							'remarks'               => 'Minor wear',
						],
					],
				],
			],
		];
	}

	/**
	 * Generate generic success response
	 */
	private function getSuccessResponse(): array {
		return [
			'status' => 200,
			'body'   => [
				'meta' => [
					'description' => 'OK',
					'code'        => 200,
				],
			],
		];
	}
}
