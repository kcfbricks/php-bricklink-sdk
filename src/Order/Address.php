<?php

namespace Kcfbricks\PhpBricklinkSdk\Order;

use Kcfbricks\PhpBricklinkSdk\ApiObject;

class Address extends ApiObject {
	/**
	 * An object representation of a person's name
	 */
	protected Name $name;

	/**
	 * The full address, not well-formatted
	 */
	protected string $full;

	/**
	 * The first line of the address. It is provided only if a buyer updated his/her address and name as a normalized form
	 */
	protected string $address1;

	/**
	 * The second line of the address. It is provided only if a buyer updated his/her address and name as a normalized form
	 */
	protected string $address2;

	/**
	 * The ISO 3166-1 alpha-2 country code (exception: UK instead of GB)
	 */
	protected string $countryCode;

	/**
	 * The city. It is provided only if a buyer updated his/her address and name as a normalized form
	 */
	protected string $city;

	/**
	 * The state. It is provided only if a buyer updated his/her address and name as a normalized form
	 */
	protected string $state;

	/**
	 * The postal code 	It is provided only if a buyer updated his/her address and name as a normalized form
	 */
	protected string $postalCode;

	public function getName(): Name {
		return $this->name;
	}

	public function setName(Name $name): self {
		$this->setProperty('name', $name);

		return $this;
	}

	public function getFull(): string {
		return $this->full;
	}

	public function setFull(string $full): self {
		$this->setProperty('full', $full);

		return $this;
	}

	public function getAddress1(): string {
		return $this->address1;
	}

	public function setAddress1(string $address1): self {
		$this->address1 = $address1;

		return $this;
	}

	public function getAddress2(): string {
		return $this->address2;
	}

	public function setAddress2(string $address2): self {
		$this->address2 = $address2;

		return $this;
	}

	public function getCountryCode(): string {
		return $this->countryCode;
	}

	public function setCountryCode(string $countryCode): self {
		$this->setProperty('countryCode', $countryCode);

		return $this;
	}

	public function getCity(): string {
		return $this->city;
	}

	public function setCity(string $city): self {
		$this->setProperty('city', $city);

		return $this;
	}

	public function getState(): string {
		return $this->state;
	}

	public function setState(string $state): self {
		$this->setProperty('state', $state);

		return $this;
	}

	public function getPostalCode(): string {
		return $this->postalCode;
	}

	public function setPostalCode(string $postalCode): self {
		$this->setProperty('postalCode', $postalCode);

		return $this;
	}
}
