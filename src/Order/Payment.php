<?php

namespace Kcfbricks\PhpBricklinkSdk\Order;

use Kcfbricks\PhpBricklinkSdk\ApiObject;
use DateTime;

class Payment extends ApiObject {
	/**
	 * Payment not yet sent by buyer. This is the default status created when an order is submitted or updated.
	 *
	 * @var string
	 */
	final public const STATUS_NONE = 'None';

	/**
	 * Payment is on its way. The buyer sets the payment status to this on their orders placed page.
	 *
	 * @var string
	 */
	final public const STATUS_SENT = 'Sent';

	/**
	 * Payment has been received by seller but might have not cleared the bank yet.
	 *
	 * @var string
	 */
	final public const STATUS_RECEIVED = 'Received';

	/**
	 * Payment has been received by seller and is clearing.
	 *
	 * @var string
	 */
	final public const STATUS_CLEARING = 'Clearing';

	/**
	 * Seller has returned payment back to buyer without cashing it.
	 *
	 * @var string
	 */
	final public const STATUS_RETURNED = 'Returned';

	/**
	 * Payment failed to clear the bank.
	 *
	 * @var string
	 */
	final public const STATUS_BOUNCED = 'Bounced';

	/**
	 * Payment has been completed.
	 *
	 * @var string
	 */
	final public const STATUS_COMPLETED = 'Completed';

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
	protected DateTime $datePaid;

	/**
	 * Status of the payment
	 */
	protected string $status;

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

	public function getDatePaid(): DateTime {
		return $this->datePaid;
	}

	public function setDatePaid(DateTime $datePaid): self {
		$this->setProperty('datePaid', $datePaid);

		return $this;
	}

	public function getStatus(): string {
		return $this->status;
	}

	public function setStatus(string $status): self {
		$this->setProperty('status', $status);

		return $this;
	}
}
