<?php

namespace Kcfbricks\PhpBricklinkSdk\Order;

use Kcfbricks\PhpBricklinkSdk\ApiObject;
use DateTime;

class Payment extends ApiObject {
	/**
	 * The payment method for this order
	 */
	protected string $method;

	/**
	 * The ISO 4217 currency code for this payment
	 */
	protected string $currencyCode;

	/**
	 * The time the buyer paid
	 */
	protected ?DateTime $datePaid;

	/**
	 * Status of the payment
	 */
	protected PaymentStatus $status;

	public function getMethod(): string {
		return $this->method;
	}

	public function setMethod(string $method): self {
		$this->setProperty('method', $method);

		return $this;
	}

	public function getCurrencyCode(): string {
		return $this->currencyCode;
	}

	public function setCurrencyCode(string $currencyCode): self {
		$this->setProperty('currencyCode', $currencyCode);

		return $this;
	}

	public function getDatePaid(): ?DateTime {
		return $this->datePaid;
	}

	public function setDatePaid(?DateTime $datePaid): self {
		$this->setProperty('datePaid', $datePaid);

		return $this;
	}

	public function getStatus(): PaymentStatus {
		return $this->status;
	}

	public function setStatus(PaymentStatus $status): self {
		$this->setProperty('status', $status);

		return $this;
	}
}
