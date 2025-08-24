<?php

namespace Kcfbricks\PhpBricklinkSdk\Order;

use Kcfbricks\PhpBricklinkSdk\ApiObject;
use Kcfbricks\PhpBricklinkSdk\Item\Item;

class OrderItem extends ApiObject {
	/**
	 * The ID of the inventory that includes the item
	 */
	protected int $inventoryId;

	/**
	 * An object representation of the item
	 */
	protected Item $item;

	/**
	 * The ID of the color of the item
	 */
	protected int $colorId;

	/**
	 * Color name of the item
	 */
	protected string $colorName;

	/**
	 * The number of items purchased in this order
	 */
	protected int $quantity;

	/**
	 * Indicates whether the item is new or used
	 */
	protected string $newOrUsed;

	/**
	 * Indicates whether the set is complete or incomplete
	 */
	protected string $completeness;

	/**
	 * The original price of this item per sale unit
	 */
	protected float $unitPrice;

	/**
	 * The unit price of this item after applying tiered pricing policy
	 */
	protected float $unitPriceFinal;

	/**
	 * The original price of this item per sale unit in display currency of the user
	 */
	protected float $dispUnitPrice;

	/**
	 * The unit price of this item after applying tiered pricing policy in display currency of the user
	 */
	protected float $dispUnitPriceFinal;

	/**
	 * The currency code of the price. ISO 4217
	 */
	protected string $currencyCode;

	/**
	 * The display currency code of the user. ISO 4217
	 */
	protected string $dispCurrencyCode;

	/**
	 * User remarks of the order item
	 */
	protected string $remarks;

	/**
	 * User description of the order item
	 */
	protected string $description;

	/**
	 * The weight of the item that overrides the catalog weight
	 */
	protected ?float $weight = null;

	public function getInventoryId(): int {
		return $this->inventoryId;
	}

	public function setInventoryId($inventoryId): self {
		$this->setProperty('inventoryId', $inventoryId);

		return $this;
	}

	public function getItem(): Item {
		return $this->item;
	}

	public function setItem(Item $item): self {
		$this->setProperty('item', $item);

		return $this;
	}

	public function getColorId(): int {
		return $this->colorId;
	}

	public function setColorId(int $colorId): self {
		$this->setProperty('colorId', $colorId);

		return $this;
	}

	public function getColorName(): string {
		return $this->colorName;
	}

	public function setColorName(string $colorName): self {
		$this->setProperty('colorName', $colorName);

		return $this;
	}

	public function getQuantity(): int {
		return $this->quantity;
	}

	public function setQuantity(int $quantity): self {
		$this->setProperty('quantity', $quantity);

		return $this;
	}

	public function getNewOrUsed(): string {
		return $this->newOrUsed;
	}

	public function setNewOrUsed(string $newOrUsed): self {
		$this->setProperty('newOrUsed', $newOrUsed);

		return $this;
	}

	public function getCompleteness(): String {
		return $this->completeness;
	}

	public function setCompleteness(String $completeness): self {
		$this->setProperty('completeness', $completeness);

		return $this;
	}

	public function getUnitPrice(): float {
		return $this->unitPrice;
	}

	public function setUnitPrice(float $unitPrice): self {
		$this->setProperty('unitPrice', $unitPrice);

		return $this;
	}

	public function getUnitPriceFinal(): float {
		return $this->unitPriceFinal;
	}

	public function setUnitPriceFinal(float $unitPriceFinal): self {
		$this->setProperty('unitPriceFinal', $unitPriceFinal);

		return $this;
	}

	public function getDispUnitPrice(): float {
		return $this->dispUnitPrice;
	}

	public function setDispUnitPrice(float $dispUnitPrice): self {
		$this->setProperty('dispUnitPrice', $dispUnitPrice);

		return $this;
	}

	public function getDispUnitPriceFinal(): float {
		return $this->dispUnitPriceFinal;
	}

	public function setDispUnitPriceFinal(float $dispUnitPriceFinal): self {
		$this->setProperty('dispUnitPriceFinal', $dispUnitPriceFinal);

		return $this;
	}

	public function getCurrencyCode(): string {
		return $this->currencyCode;
	}

	public function setCurrencyCode(string $currencyCode): self {
		$this->setProperty('currencyCode', $currencyCode);

		return $this;
	}

	public function getDispCurrencyCode(): string {
		return $this->dispCurrencyCode;
	}

	public function setDispCurrencyCode(string $dispCurrencyCode): self {
		$this->setProperty('dispCurrencyCode', $dispCurrencyCode);

		return $this;
	}

	public function getRemarks(): string {
		return $this->remarks;
	}

	public function setRemarks(string $remarks): self {
		$this->setProperty('remarks', $remarks);

		return $this;
	}

	public function getDescription(): string {
		return $this->description;
	}

	public function setDescription(string $description): self {
		$this->setProperty('description', $description);

		return $this;
	}
}
