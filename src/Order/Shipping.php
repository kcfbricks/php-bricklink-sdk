<?php

namespace Kcfbricks\PhpBricklinkSdk\Order;

use Kcfbricks\PhpBricklinkSdk\ApiObject;
use DateTime;

class Shipping extends ApiObject {
	/**
	 * Shipping method ID
	 */
	protected ?int $methodId = null;

	/**
	 * Shipping method name
	 */
	protected ?string $method = null;

	/**
	 * Tracking numbers for the shipping
	 */
	protected ?string $trackingNo = null;

	/**
	 * URL for tracking the shipping
	 */
	protected ?string $trackingLink = null;

	/**
	 * Shipping date
	 */
	protected ?DateTime $dateShipped = null;

	/**
	 * The object representation of the shipping address
	 */
	protected ?Address $address = null;

	public function getMethodId(): int {
		return $this->methodId;
	}

	public function setMethodId(int $methodId): self {
		$this->setProperty('methodId', $methodId);

		return $this;
	}

	public function getMethod(): string {
		return $this->method;
	}

	public function setMethod(string $method): self {
		$this->setProperty('method', $method);

		return $this;
	}

	public function getTrackingNo(): ?string {
		return $this->trackingNo;
	}

	public function setTrackingNo(string $trackingNo): self {
		$this->setProperty('trackingNo', $trackingNo);

		return $this;
	}

	public function getTrackingLink(): ?string {
		return $this->trackingLink;
	}

	public function setTrackingLink(string $trackingLink): self {
		$this->setProperty('trackingLink', $trackingLink);

		return $this;
	}

	public function getDateShipped(): ?DateTime {
		return $this->dateShipped;
	}

	public function setDateShipped(?DateTime $dateShipped): self {
		$this->setProperty('dateShipped', $dateShipped);

		return $this;
	}

	public function getAddress(): Address {
		return $this->address;
	}

	public function setAddress(Address $address): self {
		$this->setProperty('address', $address);

		return $this;
	}
}
