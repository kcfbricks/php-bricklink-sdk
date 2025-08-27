<?php

namespace Kcfbricks\PhpBricklinkSdk\Feedback;

use JsonMapper;
use Kcfbricks\PhpBricklinkSdk\Client;
use Kcfbricks\PhpBricklinkSdk\Order\Order;

class FeedbackRequest {
	public static function getFeedbackForOrder(Client $client, Order $order): ?array {
		$response = $client->makeRequest("orders/{$order->getOrderId()}/feedback");
		$decodedJson = json_decode($response->getBody()->getContents(), null, 512, JSON_THROW_ON_ERROR);

		if (!isset($decodedJson->data)) {
			return null;
		}

		//return the list of feedback as decoded JSON
		//if there's an error, an exception will have been thrown
		$mapper = new JsonMapper();
		$mapper->bStrictObjectTypeChecking = false;
		$feedback = $mapper->mapArray($decodedJson->data, [], Feedback::class);

		foreach ($feedback as $thisFeedback) {
			$thisFeedback->setHydrated();
		}

		return $feedback;
	}

	public static function placeFeedback(Client $client, Order $order, Feedback $feedback): bool {
		$client->makeRequest("feedback", "POST", [
			'json' => [
				'order_id' => $order->getOrderId(),
				'rating' => $feedback->getRating(),
				'comment' => $feedback->getComment(),
			],
		]);

		//if there's an error, an exception will have been thrown
		return true;
	}
}
