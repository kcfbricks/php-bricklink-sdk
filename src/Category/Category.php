<?php

namespace Kcfbricks\PhpBricklinkSdk\Category;

use Kcfbricks\PhpBricklinkSdk\ApiObject;

class Category extends ApiObject {
	/**
	 * The ID of the category
	 */
	protected int $categoryId;

	/**
	 * The name of the category
	 */
	protected string $categoryName;

	/**
	 * The ID of the parent category in category hierarchies (null if this category is root)
	 */
	protected ?int $parentId = null;

	public function getCategoryId(): int {
		return $this->categoryId;
	}

	public function setCategoryId(int $categoryId): self {
		$this->categoryId = $categoryId;

		return $this;
	}

	public function getCategoryName(): string {
		return $this->categoryName;
	}

	public function setCategoryName(string $categoryName): self {
		$this->categoryName = $categoryName;

		return $this;
	}

	public function getParentId(): ?int {
		return $this->parentId;
	}

	public function setParentId(?int $parentId): self {
		$this->parentId = $parentId;

		return $this;
	}
}
