<?php

namespace Kcfbricks\PhpBricklinkSdk\Category;

use JsonMapper;
use Kcfbricks\PhpBricklinkSdk\Client;

class CategoryRequest {
	public static function getCategory(Client $client, int $categoryId): ?Category {
		$response = $client->makeRequest("categories/{$categoryId}");
		$decodedJson = json_decode($response->getBody()->getContents(), null, 512, JSON_THROW_ON_ERROR);

		//return the item as a Category object, or null if it does not exist
		//if there's an error, an exception will have been thrown
		if (!isset($decodedJson->data)) {
			return null;
		}

		if (count(get_object_vars($decodedJson->data)) == 0) {
			return null;
		}

		$mapper = new JsonMapper();
		$mapper->bStrictObjectTypeChecking = false;
		$category = $mapper->map($decodedJson->data, new Category());
		$category->setHydrated();

		return $category;
	}

	public static function getCategories(Client $client): ?array {
		$response = $client->makeRequest("categories");
		$decodedJson = json_decode($response->getBody()->getContents(), null, 512, JSON_THROW_ON_ERROR);

		$mapper = new JsonMapper();
		$mapper->bStrictObjectTypeChecking = false;
		return $mapper->mapArray($decodedJson->data, [], Category::class);
	}
}
