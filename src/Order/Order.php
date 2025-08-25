<?php
declare(strict_types=1);

namespace Kcfbricks\PhpBricklinkSdk\Order;

use DateTime;
use Kcfbricks\PhpBricklinkSdk\ApiObject;

class Order extends ApiObject {
	/**
	 * Unique identifier for this order for internal use
	 */
	protected int $orderId;

	/**
	 * The time the order was created
	 */
	protected DateTime $dateOrdered;

	/**
	 * The time the order status was last modified
	 */
	protected DateTime $dateStatusChanged;

	/**
	 * The username of the seller in BrickLink
	 */
	protected string $sellerName;

	/**
	 * The store name displayed on BrickLink store pages
	 */
	protected string $storeName;

	/**
	 * The username of the buyer in BL
	 */
	protected string $buyerName;

	/**
	 * Email address of the buyer
	 */
	protected string $buyerEmail;

	/**
	 * Total count of all orders placed by the buyer in the seller's store. Includes the order just placed and also purged orders
	 */
	protected int $buyerOrderCount;

	/**
	 * Indicates whether the buyer requests insurance for this order
	 */
	protected bool $requireInsurance = false;

	/**
	 * The status of an order
	 */
	protected string $status;

	/**
	 * Indicates whether the order is invoiced or not
	 */
	protected bool $isInvoiced = false;

	/**
	 * Indicates whether the order is filed
	 */
	protected bool $isFiled = false;

	/**
	 * Indicates whether "Thank You, Drive Thru!" email has been sent
	 */
	protected bool $driveThruSent = false;

	/**
	 * User remarks for this order
	 */
	protected ?string $remarks = null;

	/**
	 * The total number of items included in this order
	 */
	protected int $totalCount;

	/**
	 * The unique number of items included in this order
	 */
	protected int $uniqueCount;

	/**
	 * The total weight of the items ordered
	 *
	 * @var float total weight in grams or 0 if at least one item in the order does not have weight information
	 */
	protected float $totalWeight;

	/**
	 * Information related to the payment of this order
	 */
	protected Payment $payment;

	/**
	 * Information related to the shipping
	 */
	protected Shipping $shipping;

	/**
	 * Cost information for this order, in the seller's currency (NZD for KCF Bricks)
	 */
	protected Cost $cost;

	/**
	 * Cost information for this order, in the buyer's own currency
	 */
	protected Cost $dispCost;

	public function getOrderId(): int {
		return $this->orderId;
	}

	public function setOrderId(int $orderId): self {
		$this->setProperty('orderId', $orderId);

		return $this;
	}

	public function getDateOrdered(): DateTime {
		return $this->dateOrdered;
	}

	public function setDateOrdered(DateTime $dateOrdered): self {
		$this->setProperty('dateOrdered', $dateOrdered);

		return $this;
	}

	public function getDateStatusChanged(): DateTime {
		return $this->dateStatusChanged;
	}

	public function setDateStatusChanged(DateTime $dateStatusChanged): self {
		$this->setProperty('dateStatusChanged', $dateStatusChanged);

		return $this;
	}

	public function getSellerName(): string {
		return $this->sellerName;
	}

	public function setSellerName(string $sellerName): self {
		$this->setProperty('sellerName', $sellerName);

		return $this;
	}

	public function getStoreName(): string {
		return $this->storeName;
	}

	public function setStoreName(string $storeName): self {
		$this->setProperty('storeName', $storeName);

		return $this;
	}

	public function getBuyerName(): string {
		return $this->buyerName;
	}

	public function setBuyerName(string $buyerName): self {
		$this->setProperty('buyerName', $buyerName);

		return $this;
	}

	public function getBuyerEmail(): string {
		return $this->buyerEmail;
	}

	public function setBuyerEmail(string $buyerEmail): self {
		$this->setProperty('buyerEmail', $buyerEmail);

		return $this;
	}

	public function getBuyerOrderCount(): int {
		return $this->buyerOrderCount;
	}

	public function setBuyerOrderCount(int $buyerOrderCount): self {
		$this->setProperty('buyerOrderCount', $buyerOrderCount);

		return $this;
	}

	public function getRequireInsurance(): bool {
		return $this->requireInsurance;
	}

	public function setRequireInsurance(bool $requireInsurance): self {
		$this->setProperty('requireInsurance', $requireInsurance);

		return $this;
	}

	public function getStatus(): string {
		return $this->status;
	}

	public function setStatus(string $status): self {
		$this->setProperty('status', $status);

		return $this;
	}

	public function getIsInvoiced(): bool {
		return $this->isInvoiced;
	}

	public function setIsInvoiced(bool $isInvoiced): self {
		$this->setProperty('isInvoiced', $isInvoiced);

		return $this;
	}

	public function getIsFiled(): bool {
		return $this->isFiled;
	}

	public function setIsFiled(bool $isFiled): self {
		$this->setProperty('isFiled', $isFiled);

		return $this;
	}

	public function getDriveThruSent(): bool {
		return $this->driveThruSent;
	}

	public function setDriveThruSent(bool $driveThruSent): self {
		$this->setProperty('driveThruSent', $driveThruSent);

		return $this;
	}

	public function getRemarks(): ?string {
		return $this->remarks;
	}

	public function setRemarks(?string $remarks): self {
		$this->setProperty('remarks', $remarks);

		return $this;
	}

	public function getTotalCount(): int {
		return $this->totalCount;
	}

	public function setTotalCount(int $totalCount): self {
		$this->setProperty('totalCount', $totalCount);

		return $this;
	}

	public function getUniqueCount(): int {
		return $this->uniqueCount;
	}

	public function setUniqueCount(int $uniqueCount): self {
		$this->setProperty('uniqueCount', $uniqueCount);

		return $this;
	}

	public function getTotalWeight(): float {
		return $this->totalWeight;
	}

	public function setTotalWeight(float $totalWeight): self {
		$this->setProperty('totalWeight', $totalWeight);

		return $this;
	}

	public function getPayment(): Payment {
		return $this->payment;
	}

	public function setPayment(Payment $payment): self {
		$this->setProperty('payment', $payment);

		return $this;
	}

	public function getShipping(): Shipping {
		return $this->shipping;
	}

	public function setShipping(Shipping $shipping): self {
		$this->setProperty('shipping', $shipping);

		return $this;
	}

	public function getCost(): Cost {
		return $this->cost;
	}

	public function setCost(Cost $cost): self {
		$this->setProperty('cost', $cost);

		return $this;
	}

	public function getDispCost(): Cost {
		return $this->dispCost;
	}

	public function setDispCost(Cost $dispCost): self {
		$this->setProperty('dispCost', $dispCost);

		return $this;
	}
}
