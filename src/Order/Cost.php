<?php

namespace Kcfbricks\PhpBricklinkSdk\Order;

use Kcfbricks\PhpBricklinkSdk\ApiObject;

class Cost extends ApiObject {
	/**
	 * The ISO 4217 currency code of the transaction
	 */
	protected string $currencyCode;

	/**
	 * The total price for the order exclusive of shipping and other costs
	 */
	protected float $subtotal;

	/**
	 * The total price for the order inclusive of tax, shipping and other costs
	 */
	protected float $grandTotal;

	/**
	 * Extra charge for this order (tax, packing, etc.)
	 */
	protected float $etc1;

	/**
	 * Extra charge for this order (tax, packing, etc.)
	 */
	protected float $etc2;

	/**
	 * Insurance cost
	 */
	protected float $insurance;

	/**
	 * Shipping cost
	 */
	protected float $shipping;

	/**
	 * Credit applied to this order
	 */
	protected float $credit;

	/**
	 * Amount of coupon discount
	 */
	protected float $coupon;

	/**
	 * VAT percentage (GST) applied to this order. Currently not implemented by the BrickLink API
	 */
	protected float $vatRate;

	/**
	 * Total amount of VAT (GST) included in the grand total price. Currently not implemented by the BrickLink API
	 */
	protected float $vatAmount;

	public function getCurrencyCode(): string {
		return $this->currencyCode;
	}

	public function setCurrencyCode(string $currencyCode): self {
		$this->setProperty('currencyCode', $currencyCode);

		return $this;
	}

	public function getSubtotal(): float {
		return $this->subtotal;
	}

	public function setSubtotal(float $subtotal): self {
		$this->setProperty('subtotal', $subtotal);

		return $this;
	}

	public function getGrandTotal(): float {
		return $this->grandTotal;
	}

	public function setGrandTotal(float $grandTotal): self {
		$this->setProperty('grandTotal', $grandTotal);

		return $this;
	}

	public function getEtc1(): float {
		return $this->etc1;
	}

	public function setEtc1(float $etc1): self {
		$this->etc1 = $etc1;

		return $this;
	}

	public function getEtc2(): float {
		return $this->etc2;
	}

	public function setEtc2(float $etc2): self {
		$this->etc2 = $etc2;

		return $this;
	}

	public function getInsurance(): float {
		return $this->insurance;
	}

	public function setInsurance(float $insurance): self {
		$this->setProperty('insurance', $insurance);

		return $this;
	}

	public function getShipping(): float {
		return $this->shipping;
	}

	public function setShipping(float $shipping): self {
		$this->setProperty('shipping', $shipping);

		return $this;
	}

	public function getCredit(): float {
		return $this->credit;
	}

	public function setCredit(float $credit): self {
		$this->setProperty('credit', $credit);

		return $this;
	}

	public function getCoupon(): float {
		return $this->coupon;
	}

	public function setCoupon(float $coupon): self {
		$this->setProperty('coupon', $coupon);

		return $this;
	}

	public function getVatRate(): float {
		return $this->vatRate;
	}

	public function setVatRate(float $vatRate): self {
		$this->setProperty('vatRate', $vatRate);

		return $this;
	}

	public function getVatAmount(): float {
		return $this->vatAmount;
	}

	public function setVatAmount(float $vatAmount): self {
		$this->setProperty('vatAmount', $vatAmount);

		return $this;
	}
}
