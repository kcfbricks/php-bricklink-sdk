<?php

namespace Kcfbricks\PhpBricklinkSdk\Order;

use JsonMapper;
use Kcfbricks\PhpBricklinkSdk\Client;

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
		$orders                            = $mapper->mapArray($decodedJson->data, [], Order::class);

		foreach ($orders as $thisOrder) {
			$thisOrder->setHydrated();
		}

		return $orders;
	}

	public static function getOrder(Client $client, int $orderId): Order {
		$response = $client->makeRequest("orders/{$orderId}");

		$decodedJson = json_decode($response->getBody()->getContents(), null, 512, JSON_THROW_ON_ERROR);

		//return the order as an Order object, or null if it does not exist
		//if there's an error, an exception will have been thrown
		if (!isset($decodedJson->data)) {
			return null;
		}

		$mapper                            = new JsonMapper();
		$mapper->bStrictObjectTypeChecking = false;
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
		foreach ($decodedJson->data as $thisBatchKey => $thisBatch) {
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
