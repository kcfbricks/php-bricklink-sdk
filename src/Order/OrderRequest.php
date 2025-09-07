<?php

namespace Kcfbricks\PhpBricklinkSdk\Order;

use JsonMapper;
use Kcfbricks\PhpBricklinkSdk\Client;
use Kcfbricks\PhpBricklinkSdk\Inventory\Completeness;
use Kcfbricks\PhpBricklinkSdk\Inventory\Condition;
use Kcfbricks\PhpBricklinkSdk\Item\ItemType;

class OrderRequest {
	public static function getOrders(
		Client $client,
		?OrderDirection $direction = null,
		?string $status = null,
		?bool $filed = null
	): ?array {
		$queryStringParameters = [];

		if ($direction) {
			$queryStringParameters['direction'] = $direction->value;
		}

		if ($status) {
			$queryStringParameters['status'] = $status;
		}

		if ($filed !== null) {
			$queryStringParameters['filed'] = $filed ? "true" : "false";
		}

		$url = "orders";

		if ($queryStringParameters) {
			$url .= "?" . http_build_query($queryStringParameters);
		}

		$response    = $client->makeRequest($url);
		$decodedJson = json_decode($response->getBody()->getContents(), null, 512, JSON_THROW_ON_ERROR);

		if (!isset($decodedJson->data)) {
			return null;
		}

		//return the list of orders as decoded JSON
		//if there's an error, an exception will have been thrown
		$mapper                            = new \JsonMapper();
		$mapper->bStrictObjectTypeChecking = false;

		// Validate enum values before mapping
		$orderStatusValues   = array_map(fn ($case) => $case->value, OrderStatus::cases());
		$paymentStatusValues = array_map(fn ($case) => $case->value, PaymentStatus::cases());

		foreach ($decodedJson->data as $thisOrderData) {
			// Validate main order status - use PENDING as default for invalid values
			if (property_exists($thisOrderData, 'status') && !in_array($thisOrderData->status, $orderStatusValues)) {
				$thisOrderData->status = OrderStatus::Pending->value;
			}

			// Validate payment status if payment object exists - use None as default
			if (property_exists($thisOrderData, 'payment') && is_object($thisOrderData->payment)) {
				if (property_exists($thisOrderData->payment, 'status') && !in_array($thisOrderData->payment->status, $paymentStatusValues)) {
					$thisOrderData->payment->status = PaymentStatus::None->value;
				}
			}
		}

		$orders                            = $mapper->mapArray($decodedJson->data, [], Order::class);

		foreach ($orders as $thisOrder) {
			$thisOrder->setHydrated();
		}

		return $orders;
	}

	public static function getOrder(Client $client, int $orderId): ?Order {
		$response = $client->makeRequest("orders/{$orderId}");

		$decodedJson = json_decode($response->getBody()->getContents(), null, 512, JSON_THROW_ON_ERROR);

		//return the order as an Order object, or null if it does not exist
		//if there's an error, an exception will have been thrown
		if (!isset($decodedJson->data)) {
			return null;
		}

		$mapper                            = new JsonMapper();
		$mapper->bStrictObjectTypeChecking = false;

		// Validate enum values before mapping
		$orderStatusValues   = array_map(fn ($case) => $case->value, OrderStatus::cases());
		$paymentStatusValues = array_map(fn ($case) => $case->value, PaymentStatus::cases());

		// Validate main order status - use PENDING as default for invalid values
		if (property_exists($decodedJson->data, 'status') && !in_array($decodedJson->data->status, $orderStatusValues)) {
			$decodedJson->data->status = OrderStatus::Pending->value;
		}

		// Validate payment status if payment object exists - use None as default
		if (property_exists($decodedJson->data, 'payment') && is_object($decodedJson->data->payment)) {
			if (property_exists($decodedJson->data->payment, 'status') && !in_array($decodedJson->data->payment->status, $paymentStatusValues)) {
				$decodedJson->data->payment->status = PaymentStatus::None->value;
			}
		}

		$order                             = $mapper->map($decodedJson->data, new Order());
		$order->setHydrated();

		return $order;
	}

	public static function getOrderItems(Client $client, int $orderId): array {
		$response = $client->makeRequest("orders/{$orderId}/items");

		$decodedJson = json_decode($response->getBody()->getContents(), null, 512, JSON_THROW_ON_ERROR);

		//return the order items as an array of OrderItem objects, or an empty array if none exist
		//if there's an error, an exception will have been thrown
		if (!isset($decodedJson->data)) {
			return [];
		}

		$orderItems = [];

		$mapper                            = new JsonMapper();
		$mapper->bStrictObjectTypeChecking = false;

		// Validate enum values for order items before mapping
		$conditionValues    = array_map(fn ($case) => $case->value, Condition::cases());
		$completenessValues = array_map(fn ($case) => $case->value, Completeness::cases());
		$itemTypeValues     = array_map(fn ($case) => $case->value, ItemType::cases());

		foreach ($decodedJson->data as $thisBatchKey => $thisBatch) {
			// Validate each item in the batch
			foreach ($thisBatch as $thisItemData) {
				// Validate order item enums - use defaults for non-nullable properties
				if (property_exists($thisItemData, 'new_or_used') && !in_array($thisItemData->new_or_used, $conditionValues)) {
					$thisItemData->new_or_used = Condition::New->value; // Default to New condition
				}
				if (property_exists($thisItemData, 'completeness') && !in_array($thisItemData->completeness, $completenessValues)) {
					$thisItemData->completeness = null; // Nullable property
				}

				// Validate nested item object enums
				if (property_exists($thisItemData, 'item') && is_object($thisItemData->item)) {
					if (property_exists($thisItemData->item, 'type') && !in_array($thisItemData->item->type, $itemTypeValues)) {
						$thisItemData->item->type = ItemType::Part->value; // Default to PART
					}
				}
			}

			$orderItems[$thisBatchKey] = $mapper->mapArray($thisBatch, [], OrderItem::class);
		}

		return $orderItems;
	}

	public static function setOrderStatus(Client $client, Order $order): bool {
		$client->makeRequest("orders/{$order->getOrderId()}/status", "PUT", [
			'json' => [
				'field' => 'status',
				'value' => $order->getStatus()->value,
			],
		]);

		//if there's an error, an exception will have been thrown
		$order->clearDirtyField('status');
		return true;
	}

	public static function setPaymentStatus(Client $client, Order $order): bool {
		$orderPayment = $order->getPayment();
		$client->makeRequest("orders/{$order->getOrderId()}/payment_status", "PUT", [
			'json' => [
				'field' => 'status',
				'value' => $orderPayment->getStatus()->value,
			],
		]);

		//if there's an error, an exception will have been thrown
		$orderPayment->clearDirtyField('status');
		return true;
	}

	public static function updateOrderDetails(Client $client, Order $order): bool {
		$submitFields = $order->getSubmitFields();

		$client->makeRequest("orders/{$order->getOrderId()}", "PUT", [
			'json' => $submitFields,
		]);

		//if there's an error, an exception will have been thrown
		$order->clearDirtyField();
		return true;
	}

	public static function sendDriveThru(Client $client, Order $order): bool {
		$client->makeRequest("orders/{$order->getOrderId()}/drive_thru", "POST");

		//if there's an error, an exception will have been thrown
		return true;
	}
}
