<?php
declare(strict_types=1);

namespace Kcfbricks\PhpBricklinkSdk\Testing;

/**
 * Factory for creating pre-configured mock clients for common testing scenarios
 */
class MockClientFactory {
	/**
	 * Create a mock client with realistic test data
	 */
	public static function createWithRealisticData(): MockClient {
		$provider = new MockResponseProvider(true);
		return new MockClient($provider);
	}

	/**
	 * Create a mock client with minimal/empty responses
	 */
	public static function createWithEmptyData(): MockClient {
		$provider = new MockResponseProvider(false);
		return new MockClient($provider);
	}

	/**
	 * Create a mock client that simulates API errors
	 */
	public static function createWithErrors(): MockClient {
		$provider = new MockResponseProvider(false);

		// Set up error responses for common endpoints
		$provider->setCustomResponse('orders', [
			'status' => 500,
			'body'   => [
				'meta' => [
					'description' => 'Internal Server Error',
					'code'        => 500,
					'message'     => 'Simulated API error',
				],
			],
		]);

		$provider->setCustomResponse('orders/12345', [
			'status' => 404,
			'body'   => [
				'meta' => [
					'description' => 'Not Found',
					'code'        => 404,
					'message'     => 'Order not found',
				],
			],
		]);

		return new MockClient($provider);
	}

	/**
	 * Create a mock client for testing the specific order scenario from the app
	 */
	public static function createForKcfBricksOrder(int $orderId = 12345): MockClient {
		$provider = new MockResponseProvider(true);

		// Customize the order response to match KCF Bricks scenario
		$provider->setCustomResponse("orders/{$orderId}", [
			'status' => 200,
			'body'   => [
				'meta' => [
					'description' => 'OK',
					'code'        => 200,
				],
				'data' => [
					'order_id'            => $orderId,
					'date_ordered'        => '2024-01-15T10:30:00.000Z',
					'date_status_changed' => '2024-01-15T10:30:00.000Z',
					'seller_name'         => 'kcfbricks',
					'store_name'          => 'KCF Bricks',
					'buyer_name'          => 'TestCustomer',
					'buyer_email'         => 'customer@example.com',
					'buyer_order_count'   => 1,
					'require_insurance'   => false,
					'status'              => 'RECEIVED',
					'is_invoiced'         => false,
					'is_filed'            => false,
					'drive_thru_sent'     => false,
					'remarks'             => '',
					'total_count'         => 45,
					'unique_count'        => 3,
					'total_weight'        => '15.0',
					'payment' => [
						'method'        => 'None',
						'currency_code' => 'NZD',
						'date_paid'     => null,
						'status'        => 'None',
					],
					'shipping' => [
						'method'       => 'Standard Post',
						'method_id'    => '12345',
						'tracking_no'  => '',
						'tracking_link' => '',
						'date_shipped' => null,
						'address'      => [
							'name' => [
								'full'  => 'Test Customer',
								'last'  => 'Customer',
							],
							'full'         => '123 Queen Street\nAuckland, AUK 1010\nNew Zealand',
							'address1'     => '123 Queen Street',
							'address2'     => '',
							'city'         => 'Auckland',
							'state'        => 'AUK',
							'postal_code'  => '1010',
							'country_code' => 'NZ',
							'phone_number' => '+64 9 123 4567',
						],
					],
					'cost' => [
						'currency_code' => 'NZD',
						'subtotal'      => '4.60',
						'grand_total'   => '12.10',
						'salesTax_collected_by_BL' => '0.00',
						'final_total'   => '12.10',
						'etc1'          => '0.00',
						'etc2'          => '0.00',
						'insurance'     => '0.00',
						'shipping'      => '7.50',
						'credit'        => '0.00',
						'coupon'        => '0.00',
						'vat_rate'      => '0.00',
						'vat_amount'    => '0.00',
					],
					'disp_cost' => [
						'currency_code' => 'NZD',
						'subtotal'      => '4.60',
						'grand_total'   => '12.10',
						'etc1'          => '0.00',
						'etc2'          => '0.00',
						'insurance'     => '0.00',
						'shipping'      => '7.50',
						'credit'        => '0.00',
						'coupon'        => '0.00',
						'vat_rate'      => '0.00',
						'vat_amount'    => '0.00',
					],
				],
			],
		]);

		// Customize order items to include New Zealand-relevant LEGO parts
		$provider->setCustomResponse("orders/{$orderId}/items", [
			'status' => 200,
			'body'   => [
				'meta' => [
					'description' => 'OK',
					'code'        => 200,
				],
				'data' => [
					'0' => [
						[
							'inventory_id' => 111111,
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
							'unit_price'            => '0.15',
							'unit_price_final'      => '0.15',
							'disp_unit_price'       => '0.15',
							'disp_unit_price_final' => '0.15',
							'currency_code'         => 'NZD',
							'disp_currency_code'    => 'NZD',
							'remarks'               => 'Genuine LEGO',
							'description'           => 'Excellent condition',
							'weight'                => '0.8',
						],
						[
							'inventory_id' => 111112,
							'item'         => [
								'no'          => '3794',
								'name'        => 'Plate 1 x 2',
								'type'        => 'PART',
								'category_id' => 26,
							],
							'color_id'              => 1,
							'color_name'            => 'White',
							'quantity'              => 20,
							'new_or_used'           => 'N',
							'completeness'          => null,
							'unit_price'            => '0.08',
							'unit_price_final'      => '0.08',
							'disp_unit_price'       => '0.08',
							'disp_unit_price_final' => '0.08',
							'currency_code'         => 'NZD',
							'disp_currency_code'    => 'NZD',
							'remarks'               => '',
							'description'           => 'Like new',
							'weight'                => '0.2',
						],
					],
					'1' => [
						[
							'inventory_id' => 111113,
							'item'         => [
								'no'          => '3023',
								'name'        => 'Plate 1 x 2',
								'type'        => 'PART',
								'category_id' => 26,
							],
							'color_id'              => 4,
							'color_name'            => 'Blue',
							'quantity'              => 15,
							'new_or_used'           => 'N',
							'completeness'          => null,
							'unit_price'            => '0.10',
							'unit_price_final'      => '0.10',
							'disp_unit_price'       => '0.10',
							'disp_unit_price_final' => '0.10',
							'currency_code'         => 'NZD',
							'disp_currency_code'    => 'NZD',
							'remarks'               => '',
							'description'           => 'Like new',
							'weight'                => '0.2',
						],
					],
				],
			],
		]);

		return new MockClient($provider);
	}

	/**
	 * Create a mock client that returns a purged order scenario
	 */
	public static function createWithPurgedOrder(int $orderId = 99999): MockClient {
		$provider = new MockResponseProvider(false);

		$provider->setCustomResponse("orders/{$orderId}", [
			'status' => 404,
			'body'   => [
				'meta' => [
					'description' => 'RESOURCE_NOT_FOUND',
					'code'        => 404,
					'message'     => 'Resource you requested does not exist',
				],
			],
		]);

		$provider->setCustomResponse("orders/{$orderId}/items", [
			'status' => 404,
			'body'   => [
				'meta' => [
					'description' => 'RESOURCE_NOT_FOUND',
					'code'        => 404,
					'message'     => 'Resource you requested does not exist',
				],
			],
		]);

		return new MockClient($provider);
	}

	/**
	 * Create a mock client with invalid enum values to test enum validation
	 */
	public static function createWithInvalidEnums(int $orderId = 12345): MockClient {
		$provider = new MockResponseProvider(false);

		// Order with invalid status
		$provider->setCustomResponse("orders/{$orderId}", [
			'status' => 200,
			'body'   => [
				'meta' => [
					'description' => 'OK',
					'code'        => 200,
				],
				'data' => [
					'order_id'            => $orderId,
					'date_ordered'        => '2024-01-15T10:30:00.000Z',
					'date_status_changed' => '2024-01-15T10:30:00.000Z',
					'seller_name'         => 'testseller',
					'store_name'          => 'Test Store',
					'buyer_name'          => 'TestBuyer',
					'buyer_email'         => 'buyer@example.com',
					'buyer_order_count'   => 1,
					'status'              => 'INVALID_STATUS', // Invalid enum value
					'total_count'         => 5,
					'unique_count'        => 3,
					'total_weight'        => '25.0',
					'base_grand_total'    => '10.00',
					'grand_total'         => '15.00',
					'payment'             => [
						'method'        => 'PayPal',
						'currency_code' => 'USD',
						'date_paid'     => null,
						'status'        => 'INVALID_PAYMENT_STATUS', // Invalid enum value
					],
				],
			],
		]);

		// Order items with invalid enum values
		$provider->setCustomResponse("orders/{$orderId}/items", [
			'status' => 200,
			'body'   => [
				'meta' => [
					'description' => 'OK',
					'code'        => 200,
				],
				'data' => [
					'0' => [
						[
							'inventory_id' => 111111,
							'item'         => [
								'no'          => '3001',
								'name'        => 'Brick 2 x 4',
								'type'        => 'INVALID_TYPE', // Invalid enum value
								'category_id' => 5,
							],
							'color_id'              => 5,
							'color_name'            => 'Red',
							'quantity'              => 10,
							'new_or_used'           => 'INVALID_CONDITION', // Invalid enum value
							'completeness'          => 'INVALID_COMPLETENESS', // Invalid enum value
							'unit_price'            => '0.15',
							'unit_price_final'      => '0.15',
							'disp_unit_price'       => 'US $0.15',
							'disp_unit_price_final' => 'US $0.15',
							'currency_code'         => 'USD',
							'description'           => 'Test item with invalid enums',
							'remarks'               => '',
						],
					],
				],
			],
		]);

		// Inventory item with invalid enum values
		$provider->setCustomResponse("inventories/111111", [
			'status' => 200,
			'body'   => [
				'meta' => [
					'description' => 'OK',
					'code'        => 200,
				],
				'data' => [
					'inventory_id' => 111111,
					'item'         => [
						'no'          => '3001',
						'name'        => 'Brick 2 x 4',
						'type'        => 'PART',
						'category_id' => 5,
					],
					'color_id'              => 5,
					'color_name'            => 'Red',
					'quantity'              => 10,
					'new_or_used'           => 'INVALID_CONDITION', // Invalid enum value
					'completeness'          => 'INVALID_COMPLETENESS', // Invalid enum value
					'unit_price'            => '0.15',
					'unit_price_final'      => '0.15',
					'disp_unit_price'       => 'US $0.15',
					'disp_unit_price_final' => 'US $0.15',
					'currency_code'         => 'USD',
					'description'           => 'Test item with invalid enums',
					'remarks'               => '',
				],
			],
		]);

		// Catalogue item with invalid enum value
		$provider->setCustomResponse("items/PART/3001", [
			'status' => 200,
			'body'   => [
				'meta' => [
					'description' => 'OK',
					'code'        => 200,
				],
				'data' => [
					'no'          => '3001',
					'name'        => 'Brick 2 x 4',
					'type'        => 'INVALID_TYPE', // Invalid enum value
					'category_id' => 5,
				],
			],
		]);

		// Feedback with invalid enum values
		$provider->setCustomResponse("orders/{$orderId}/feedback", [
			'status' => 200,
			'body'   => [
				'meta' => [
					'description' => 'OK',
					'code'        => 200,
				],
				'data' => [
					[
						'order_id'      => $orderId,
						'comment'       => 'Test feedback',
						'comment_reply' => '',
						'rating'        => 999, // Invalid enum value
						'rating_of_bs'  => 'INVALID_RATING', // Invalid enum value
						'date_created'  => '2024-01-15T10:30:00.000Z',
					],
				],
			],
		]);

		return new MockClient($provider);
	}

	/**
	 * Create a custom mock client with your own response provider
	 */
	public static function createCustom(MockResponseProvider $provider): MockClient {
		return new MockClient($provider);
	}
}
