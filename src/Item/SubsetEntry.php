<?php

namespace Kcfbricks\PhpBricklinkSdk\Item;

use Kcfbricks\PhpBricklinkSdk\ApiObject;

class SubsetEntry extends ApiObject {
	protected Item $item;

	protected ?int $colorId = null;

	protected int $quantity;

	protected int $extraQuantity;

	protected bool $isAlternate;

	protected bool $isCounterpart;

	public function getItem(): Item {
		return $this->item;
	}

	public function setItem(Item $item): self {
		$this->item = $item;

		return $this;
	}

	public function getColorId(): int {
		return $this->colorId;
	}

	public function setColorId(int $colorId): self {
		$this->colorId = $colorId;

		return $this;
	}

	public function getQuantity(): int {
		return $this->quantity;
	}

	public function setQuantity(int $quantity): self {
		$this->quantity = $quantity;

		return $this;
	}

	public function getExtraQuantity(): int {
		return $this->extraQuantity;
	}

	public function setExtraQuantity(int $extraQuantity): self {
		$this->extraQuantity = $extraQuantity;

		return $this;
	}

	public function getIsAlternate(): bool {
		return $this->isAlternate;
	}

	public function setIsAlternate(bool $isAlternate): self {
		$this->isAlternate = $isAlternate;

		return $this;
	}

	public function getIsCounterpart(): bool {
		return $this->isCounterpart;
	}

	public function setIsCounterpart(bool $isCounterpart): self {
		$this->isCounterpart = $isCounterpart;

		return $this;
	}

	public function getImageUrl(): ?string {
		return "https://img.bricklink.com/ItemImage/" . urlencode($this->getItem()->getType()->value[0]) . "N/" . urlencode($this->getColorId() ?? "0") . "/" . urlencode($this->getItem()->getNo()) . ".png";
	}

	public function getImageThumbnail(): ?string {
		return "https://img.bricklink.com/ItemImage/" . urlencode($this->getItem()->getType()->value[0]) . "T/" . urlencode($this->getColorId() ?? "0") . "/" . urlencode($this->getItem()->getNo()) . ".t1.png";
	}
}
