<?php

namespace Kcfbricks\PhpBricklinkSdk\Order;

use Kcfbricks\PhpBricklinkSdk\Client;

class OrderRequest {
	public static function getOrder(Client $client, int $orderId): Order {
		$response = $client->makeRequest("orders/{$orderId}");
		var_dump($response->getBody()->getContents(), $client);
		die();

		return new Order($response);
	}
}