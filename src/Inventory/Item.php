<?php

namespace Kcfbricks\PhpBricklinkSdk\Inventory;

use Kcfbricks\PhpBricklinkSdk\Item\Item as CatalogueItem;
use DateTime;
use Exception;
use Kcfbricks\PhpBricklinkSdk\ApiObject;
use ReflectionProperty;

class Item extends ApiObject {
	/**
	 * The ID of the inventory
	 */
	protected int $inventoryId;

	/**
	 * An object representation of the item
	 */
	protected CatalogueItem $item;

	/**
	 * The ID of the color of the item
	 */
	protected int $colorId;

	/**
	 * Color name of the item
	 */
	protected string $colorName;

	/**
	 * The number of items included in this inventory
	 */
	protected int $quantity;

	/**
	 * Indicates whether the item is new or used. N: New, U: Used
	 */
	protected ?Condition $newOrUsed = null;

	/**
	 * Indicates whether the set is complete or incomplete (This value is valid only for SET type).
	 */
	protected ?Completeness $completeness = null;

	/**
	 * The original price of this item per sale unit
	 */
	protected float $unitPrice;

	/**
	 * The ID of the parent lot that this lot is bound to
	 */
	protected int $bindId;

	/**
	 * A short description for this inventory
	 */
	protected string $description;

	/**
	 * User remarks on this inventory
	 */
	protected ?string $remarks = null;

	/**
	 * Buyers can buy this item only in multiples of the bulk amount
	 */
	protected int $bulk;

	/**
	 * Indicates whether the item retains in inventory after it is sold out
	 */
	protected bool $isRetain = false;

	/**
	 * Indicates whether the item appears only in owner's inventory
	 */
	protected bool $isStockRoom = false;

	/**
	 * Indicates the stockroom that the item to be placed when the user uses multiple stockroom. A, B or C
	 */
	protected ?string $stockRoomId = null;

	/**
	 * The time this lot is created
	 */
	protected DateTime $dateCreated;

	/**
	 * My Cost value to tracking the cost of item
	 */
	protected float $myCost;

	/**
	 * Sale value to adjust item price	Must be less than 100. 20 for 20% sale
	 */
	protected int $saleRate;

	/**
	 * A parameter for Tiered pricing 	0 for no tier sale option
	 */
	protected int $tierQuantity1;

	/**
	 * A parameter for Tiered pricing	0 for no tier sale option, Must be greater than tier_quantity1
	 */
	protected int $tierQuantity2;

	/**
	 * A parameter for Tiered pricing 	0 for no tier sale option, Must be greater than tier_quantity2
	 */
	protected int $tierQuantity3;

	/**
	 * A parameter for Tiered pricing	0 for no tier sale option. Must be less than unit_price
	 */
	protected float $tierPrice1;

	/**
	 * A parameter for Tiered pricing	0 for no tier sale option, Must be less than tier_price1
	 */
	protected float $tierPrice2;

	/**
	 * A parameter for Tiered pricing	0 for no tier sale option, Must be less than tier_price2
	 */
	protected float $tierPrice3;

	/**
	 * Custom weight of the item (upcoming)
	 */
	protected float $myWeight;

	/**
	 * Keeps track of changes in quantity on this item before calling the API.
	 *
	 * @var integer
	 */
	protected int $quantityChange = 0;

	public function getInventoryId(): int {
		return $this->inventoryId;
	}

	public function setInventoryId(int $inventoryId): self {
		$this->setProperty('inventoryId', $inventoryId);

		return $this;
	}

	public function getItem(): CatalogueItem {
		return $this->item;
	}

	public function setItem(CatalogueItem $item): self {
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

	public function getNewOrUsed(): ?Condition {
		return $this->newOrUsed;
	}

	public function setNewOrUsed(?Condition $newOrUsed): self {
		$this->setProperty('newOrUsed', $newOrUsed);

		return $this;
	}

	public function getCompleteness(): ?Completeness {
		return $this->completeness;
	}

	public function setCompleteness(?Completeness $completeness): self {
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

	public function getBindId(): int {
		return $this->bindId;
	}

	public function setBindId(int $bindId): self {
		$this->setProperty('bindId', $bindId);

		return $this;
	}

	public function getDescription(): string {
		return $this->description;
	}

	public function setDescription(string $description): self {
		$this->setProperty('description', $description);

		return $this;
	}

	public function getRemarks(): ?string {
		return $this->remarks;
	}

	public function setRemarks(?string $remarks): self {
		$this->setProperty('remarks', $remarks);

		return $this;
	}

	public function getBulk(): int {
		return $this->bulk;
	}

	public function setBulk(int $bulk): self {
		$this->setProperty('bulk', $bulk);

		return $this;
	}

	public function getIsRetain(): bool {
		return $this->isRetain;
	}

	public function setIsRetain(bool $isRetain): self {
		$this->setProperty('isRetain', $isRetain);

		return $this;
	}

	public function getIsStockRoom(): bool {
		return $this->isStockRoom;
	}

	public function setIsStockRoom(bool $isStockRoom): self {
		$this->setProperty('isStockRoom', $isStockRoom);

		return $this;
	}

	public function getStockRoomId(): ?string {
		return $this->stockRoomId;
	}

	public function setStockRoomId(?string $stockRoomId): self {
		$this->setProperty('stockRoomId', $stockRoomId);

		return $this;
	}

	public function getDateCreated(): DateTime {
		return $this->dateCreated;
	}

	public function setDateCreated(DateTime $dateCreated): self {
		$this->setProperty('dateCreated', $dateCreated);

		return $this;
	}

	public function getMyCost(): float {
		return $this->myCost;
	}

	public function setMyCost(float $myCost): self {
		$this->setProperty('myCost', $myCost);

		return $this;
	}

	public function getSaleRate(): int {
		return $this->saleRate;
	}

	public function setSaleRate(int $saleRate): self {
		$this->setProperty('saleRate', $saleRate);

		return $this;
	}

	public function getTierQuantity1(): int {
		return $this->tierQuantity1;
	}

	public function setTierQuantity1(int $tierQuantity1): self {
		$this->tierQuantity1 = $tierQuantity1;

		return $this;
	}

	public function getTierQuantity2(): int {
		return $this->tierQuantity2;
	}

	public function setTierQuantity2(int $tierQuantity2): self {
		$this->tierQuantity2 = $tierQuantity2;

		return $this;
	}

	public function getTierQuantity3(): int {
		return $this->tierQuantity3;
	}

	public function setTierQuantity3(int $tierQuantity3): self {
		$this->tierQuantity3 = $tierQuantity3;

		return $this;
	}

	public function getTierPrice1(): float {
		return $this->tierPrice1;
	}

	public function setTierPrice1(float $tierPrice1): self {
		$this->tierPrice1 = $tierPrice1;

		return $this;
	}

	public function getTierPrice2(): float {
		return $this->tierPrice2;
	}

	public function setTierPrice2(float $tierPrice2): self {
		$this->tierPrice2 = $tierPrice2;

		return $this;
	}

	public function getTierPrice3(): float {
		return $this->tierPrice3;
	}

	public function setTierPrice3(float $tierPrice3): self {
		$this->tierPrice3 = $tierPrice3;

		return $this;
	}

	public function getMyWeight(): float {
		return $this->myWeight;
	}

	public function setMyWeight(float $myWeight): self {
		$this->setProperty('myWeight', $myWeight);

		return $this;
	}

	public function changeQuantity(int $quantityChange, bool $decrease = true) {
		if ($decrease) {
			$this->quantityChange -= $quantityChange;
		} else {
			$this->quantityChange += $quantityChange;
		}
	}

	public function getQuantityChange(): int {
		return $this->quantityChange;
	}
}
