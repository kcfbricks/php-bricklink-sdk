<?php

namespace Kcfbricks\PhpBricklinkSdk\Inventory;

use JsonMapper;
use Kcfbricks\PhpBricklinkSdk\Client;
use Kcfbricks\PhpBricklinkSdk\Item\ItemType;

class InventoryRequest {
	public static function getInventory(
		Client $client,
		ItemType|array|null $itemType = null,
		string|array|null $status = null,
		int|array|null $categoryId = null,
		object|array|null $colour = null
	): ?array {
		$queryStringParameters = [];

		if ($itemType instanceof ItemType) {
			$queryStringParameters['item_type'] = $itemType->value;
		} elseif (is_array($itemType)) {
			$queryStringParameters['item_type'] = implode(",", array_map(fn($thisItemType) => $thisItemType->value, $itemType));
		}

		if (is_string($status)) {
			$queryStringParameters['status'] = $status;
		} elseif (is_array($status)) {
			$queryStringParameters['status'] = implode(",", $status);
		}

		if (is_int($categoryId)) {
			$queryStringParameters['category_id'] = $categoryId;
		} elseif (is_array($categoryId)) {
			$queryStringParameters['category_id'] = implode(",", $categoryId);
		}

		if (is_object($colour) && method_exists($colour, 'getBricklinkId')) {
			$queryStringParameters['color_id'] = $colour->getBricklinkId();
		} elseif (is_array($colour)) {
			$queryStringParameters['color_id'] = implode(",", array_map(fn($thisColour) => $thisColour->getBricklinkId(), $colour));
		}

		$url = "inventories";

		if ($queryStringParameters) {
			$url .= "?" . http_build_query($queryStringParameters);
		}

		$response = $client->makeRequest($url);
		$decodedJson = json_decode($response->getBody()->getContents(), null, 512, JSON_THROW_ON_ERROR);

		if (!isset($decodedJson->data)) {
			return null;
		}

		//return the list of inventory items as decoded JSON
		//if there's an error, an exception will have been thrown
		$mapper = new JsonMapper();
		$mapper->bStrictObjectTypeChecking = false;

		$completenessCases = Completeness::cases();
		//make sure the completeness is a valid value
		foreach ($decodedJson->data as $thisData) {
			if (property_exists($thisData, 'completeness') && !in_array($thisData->completeness, $completenessCases)) {
				unset($thisData->completeness);
			}
		}

		$inventoryItems = $mapper->mapArray($decodedJson->data, [], Item::class);

		foreach ($inventoryItems as $thisItem) {
			$thisItem->setHydrated();
		}

		return $inventoryItems;
	}

	public static function getInventoryItem(Client $client, int $inventoryId): ?Item {
		$response = $client->makeRequest("inventories/{$inventoryId}");
		$decodedJson = json_decode($response->getBody()->getContents(), null, 512, JSON_THROW_ON_ERROR);

		//return the item as an InventoryItem object, or null if it does not exist
		//if there's an error, an exception will have been thrown
		if (!isset($decodedJson->data)) {
			return null;
		}

		if (count(get_object_vars($decodedJson->data)) == 0) {
			return null;
		}

		$mapper = new JsonMapper();
		$mapper->bStrictObjectTypeChecking = false;
		$inventoryItem = $mapper->map($decodedJson->data, new Item());
		$inventoryItem->setHydrated();

		return $inventoryItem;
	}

	public static function updateInventoryItem(Client $client, Item $item): bool {
		$submitFields = $item->getSubmitFields();
		$quantityChange = $item->getQuantityChange();
		if ($quantityChange > 0) {
			//add to the quantity
			$submitFields['quantity'] = "+" . $quantityChange;
		} elseif ($quantityChange < 0) {
			//subtract from the quantity
			//the minus sign is already present here so no need to add it
			$submitFields['quantity'] = strval($quantityChange);
		}

		$client->makeRequest("inventories/{$item->getInventoryId()}", "PUT", [
			'json' => $submitFields,
		]);

		//if there's an error, an exception will have been thrown
		$item->clearDirtyField();
		return true;
	}

	public static function deleteInventoryItem(Client $client, Item $item): bool {
		try {
			$client->makeRequest("inventories/{$item->getInventoryId()}", "DELETE");
			return true;
		} catch (\Exception) {
			return false;
		}
	}
}
