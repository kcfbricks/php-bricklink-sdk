<?php

namespace Kcfbricks\PhpBricklinkSdk\Item;

use Kcfbricks\PhpBricklinkSdk\ApiObject;
use JsonSerializable;

class Item extends ApiObject implements JsonSerializable {
	/**
	 * Item's identification number in BrickLink catalog
	 */
	protected string $no;

	/**
	 * The name of the item
	 */
	protected string $name;

	/**
	 * The type of the item
	 */
	protected string $type;

	/**
	 * The main category of the item
	 */
	protected int $categoryId;

	/**
	 * Alternate item number
	 */
	protected ?string $alternateNo = null;

	/**
	 * Image link for this item
	 */
	protected ?string $imageUrl = null;

	/**
	 * Image thumbnail link for this item
	 */
	protected ?string $thumbnailUrl = null;

	/**
	 * The weight of the item in grams with 2 decimal places
	 */
	protected ?float $weight = null;

	/**
	 * Length of the item with 2 decimal places
	 */
	protected ?string $dimX = null;

	/**
	 * Width of the item with 2 decimal places
	 */
	protected ?string $dimY = null;

	/**
	 * Height of the item with 2 decimal places
	 */
	protected ?string $dimZ = null;

	/**
	 * Item year of release
	 */
	protected int $yearReleased;

	/**
	 * Short description for this item
	 */
	protected ?string $description = null;

	/**
	 * Indicates whether the item is obsolete
	 */
	protected bool $isObsolete = false;

	/**
	 * Item language code
	 */
	protected ?string $languageCode = null;

	public function getNo(): string {
		return $this->no;
	}

	public function setNo(string $no): self {
		$this->setProperty('no', $no);

		return $this;
	}

	public function getName(): string {
		return $this->name;
	}

	public function setName(string $name): self {
		$this->setProperty('name', $name);

		return $this;
	}

	public function getType(): string {
		return $this->type;
	}

	public function setType(string $type): self {
		$this->setProperty('type', $type);

		return $this;
	}

	public function getCategoryId(): int {
		return $this->categoryId;
	}

	public function setCategoryId(int $categoryId): self {
		$this->setProperty('categoryId', $categoryId);

		return $this;
	}

	public function getAlternateNo(): ?string {
		return $this->alternateNo;
	}

	public function setAlternateNo(string $alternateNo): self {
		$this->setProperty('alternateNo', $alternateNo);

		return $this;
	}

	public function getImageUrl(): string {
		return $this->imageUrl;
	}

	public function setImageUrl(string $imageUrl): self {
		$this->setProperty('imageUrl', $imageUrl);

		return $this;
	}

	public function getThumbnailUrl(): ?string {
		return $this->thumbnailUrl;
	}

	public function setThumbnailUrl(?string $thumbnailUrl): self {
		$this->setProperty('thumbnailUrl', $thumbnailUrl);

		return $this;
	}

	public function getWeight(): ?float {
		return $this->weight;
	}

	public function setWeight(float $weight): self {
		$this->setProperty('weight', $weight);

		return $this;
	}

	public function getDimX(): ?string {
		return $this->dimX;
	}

	public function setDimX(string $dimX): self {
		$this->setProperty('dimX', $dimX);

		return $this;
	}

	public function getDimY(): ?string {
		return $this->dimY;
	}

	public function setDimY(string $dimY): self {
		$this->setProperty('dimY', $dimY);

		return $this;
	}

	public function getDimZ(): ?string {
		return $this->dimZ;
	}

	public function setDimZ(string $dimZ): self {
		$this->setProperty('dimZ', $dimZ);

		return $this;
	}

	public function getYearReleased(): int {
		return $this->yearReleased;
	}

	public function setYearReleased(int $yearReleased): self {
		$this->setProperty('yearReleased', $yearReleased);

		return $this;
	}

	public function getDescription(): ?string {
		return $this->description;
	}

	public function setDescription(string $description): self {
		$this->setProperty('description', $description);

		return $this;
	}

	public function getIsObsolete(): bool {
		return $this->isObsolete;
	}

	public function setIsObsolete(bool $isObsolete): self {
		$this->setProperty('isObsolete', $isObsolete);

		return $this;
	}

	public function getLanguageCode(): ?string {
		return $this->languageCode;
	}

	public function setLanguageCode(?string $languageCode): self {
		$this->setProperty('languageCode', $languageCode);

		return $this;
	}

	/**
	 * @return array{no: string, name: string, type: string, categoryId: int, alternateNo: string|null, imageUrl: string|null, thumbnailUrl: string|null, weight: float|null, dimX: string|null, dimY: string|null, dimZ: string|null, yearReleased: int, description: string|null, isObsolete: bool, languageCode: string|null}
	 */
	public function jsonSerialize(): array {
		return [
			'no'           => $this->no,
			'name'         => $this->name,
			'type'         => $this->type,
			'categoryId'   => $this->categoryId,
			'alternateNo'  => $this->alternateNo,
			'imageUrl'     => $this->imageUrl,
			'thumbnailUrl' => $this->thumbnailUrl,
			'weight'       => $this->weight,
			'dimX'         => $this->dimX,
			'dimY'         => $this->dimY,
			'dimZ'         => $this->dimZ,
			'yearReleased' => $this->yearReleased,
			'description'  => $this->description,
			'isObsolete'   => $this->isObsolete,
			'languageCode' => $this->languageCode,
		];
	}
}
