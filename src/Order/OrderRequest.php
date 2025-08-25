<?php

namespace Kcfbricks\PhpBricklinkSdk\Order;

use JsonMapper;
use Kcfbricks\PhpBricklinkSdk\Client;

class OrderRequest {
	public static function getOrder(Client $client, int $orderId): Order {
		$response = $client->makeRequest("orders/{$orderId}");

		$decodedJson = json_decode($response->getBody()->getContents(), null, 512, JSON_THROW_ON_ERROR);

		//return the order as an Order object, or null if it does not exist
		//if there's an error, an exception will have been thrown
		if (!isset($decodedJson->data)) {
			return null;
		}

		$mapper = new JsonMapper();
		$mapper->bStrictObjectTypeChecking = false;
		$order  = $mapper->map($decodedJson->data, new Order());
		$order->setHydrated();

		return $order;
	}

	public static function getOrderItems($client, int $orderId): array {
		$response = $client->makeRequest("orders/{$orderId}/items");

		$decodedJson = json_decode($response->getBody()->getContents(), null, 512, JSON_THROW_ON_ERROR);

		//return the order items as an array of OrderItem objects, or an empty array if none exist
		//if there's an error, an exception will have been thrown
		if (!isset($decodedJson->data)) {
			return [];
		}

		$orderItems = [];

		$mapper = new JsonMapper();
		$mapper->bStrictObjectTypeChecking = false;
		foreach ($decodedJson->data as $thisBatchKey => $thisBatch) {
			$orderItems[$thisBatchKey] = $mapper->mapArray($thisBatch, [], OrderItem::class);
		}

		return $orderItems;
	}
}