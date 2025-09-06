<?php

namespace Kcfbricks\PhpBricklinkSdk\Item;

use JsonMapper;
use Kcfbricks\PhpBricklinkSdk\Client;

class ItemRequest {
	public static function getCatalogueItem(Client $client, string $itemNumber, ?ItemType $itemType = null): ?Item {
		$itemType = $itemType instanceof ItemType ? $itemType->value : "PART";

		$response    = $client->makeRequest("items/{$itemType}/{$itemNumber}");
		$decodedJson = json_decode($response->getBody()->getContents(), null, 512, JSON_THROW_ON_ERROR);

		//return the item as an Item object, or null if it does not exist
		//if there's an error, an exception will have been thrown
		if (!isset($decodedJson->data)) {
			return null;
		}

		if (count(get_object_vars($decodedJson->data)) == 0) {
			return null;
		}

		$mapper                            = new JsonMapper();
		$mapper->bStrictObjectTypeChecking = false;

		// Validate enum values before mapping
		$itemTypeValues = array_map(fn ($case) => $case->value, ItemType::cases());

		if (property_exists($decodedJson->data, 'type') && !in_array($decodedJson->data->type, $itemTypeValues)) {
			$decodedJson->data->type = ItemType::Part->value; // Default to PART
		}

		$item = $mapper->map($decodedJson->data, new Item());
		$item->setHydrated();

		return $item;
	}

	public static function getCatalogueItemImage(Client $client, string $itemNumber, object $colour, ?ItemType $itemType = null): ?string {
		$itemType = $itemType instanceof ItemType ? $itemType->value : "PART";

		try {
			$response    = $client->makeRequest("items/{$itemType}/{$itemNumber}/images/{$colour->getBricklinkId()}");
			$decodedJson = json_decode($response->getBody()->getContents(), null, 512, JSON_THROW_ON_ERROR);
		} catch (\Exception) {
			return null;
		}

		//return the URL as a string, as we don't need any of the other data
		if (!isset($decodedJson->data)) {
			return null;
		}

		if (!isset($decodedJson->data->thumbnail_url)) {
			return null;
		}

		return $decodedJson->data->thumbnail_url;
	}

	public static function getPartList(Client $client, string $itemNumber, ?ItemType $itemType = null, bool $breakSubsets = true): ?array {
		$subsets = self::getSubsets($client, $itemNumber, $itemType, $breakSubsets);

		if ($subsets === null) {
			return null;
		}

		foreach ($subsets as $thisSubset) {
			//filter out counterpart and alternate items
			$thisSubset->setEntries(array_filter($thisSubset->getEntries(), static fn ($thisEntry): bool => $thisEntry->getQuantity() > 0 && !$thisEntry->getIsAlternate() && !$thisEntry->getIsCounterpart()));
		}

		return array_filter($subsets, static fn ($thisSubset): bool => !empty($thisSubset->getEntries()));
	}

	public static function getSubsets(Client $client, string $itemNumber, ?ItemType $itemType = null, bool $breakSubsets = true): ?array {
		$itemType = $itemType instanceof ItemType ? $itemType->value : "PART";

		$queryString = [];
		if ($breakSubsets) {
			$queryString['break_subsets'] = "true";
		}

		$url = "items/{$itemType}/{$itemNumber}/subsets";
		if ($queryString) {
			$url .= "?" . http_build_query($queryString);
		}

		try {
			$response    = $client->makeRequest($url);
			$decodedJson = json_decode($response->getBody()->getContents(), null, 512, JSON_THROW_ON_ERROR);
		} catch (\Exception) {
			return null;
		}

		$mapper                            = new JsonMapper();
		$mapper->bStrictObjectTypeChecking = false;
		$subsets                           = $mapper->mapArray($decodedJson->data, [], Subset::class);

		//explicitly map the entry list as the mapper above doesn't go into this
		foreach ($subsets as $thisSubset) {
			$thisSubset->setEntries($mapper->mapArray($thisSubset->getEntries(), [], SubsetEntry::class));
		}

		return $subsets;
	}

	public static function getPriceData(Client $client, ItemType $itemType, string $itemNumber, array $parameters): ?\stdClass {
		$queryStringParameters = [];

		if (!empty($parameters['colourId'])) {
			$queryStringParameters['color_id'] = $parameters['colourId'];
		}

		$queryStringParameters['guide_type'] = empty($parameters['useSoldItems']) ? "stock" : "sold";

		$queryStringParameters['new_or_used'] = empty($parameters['useNewParts']) ? "U" : "N";

		if (!empty($parameters['countryCode'])) {
			$queryStringParameters['country_code'] = $parameters['countryCode'];
		}

		if (!empty($parameters['region'])) {
			$queryStringParameters['region'] = $parameters['region'];
		}

		$queryStringParameters['currency_code'] = "NZD";
		$queryStringParameters['va']            = "N";

		try {
			$url         = "items/{$itemType->value}/{$itemNumber}/price?" . http_build_query($queryStringParameters);
			$response    = $client->makeRequest($url);
			$decodedJson = json_decode($response->getBody()->getContents(), null, 512, JSON_THROW_ON_ERROR);

			//if there's an error, an exception will have been thrown
			return $decodedJson->data;
		} catch (\Exception $exception) {
			if ($exception->getCode() == 404) {
				return null;
			}

			throw $exception;
		}
	}
}
