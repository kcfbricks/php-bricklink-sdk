<?php

namespace Kcfbricks\PhpBricklinkSdk\Order;

use Kcfbricks\PhpBricklinkSdk\ApiObject;

class Name extends ApiObject {
	/**
	 * The full name of this person, including middle names, suffixes, etc.
	 */
	protected string $full;

	/**
	 * The family name (last name) of this person. It is provided only if a buyer updated his/her address and name as a normalized form
	 */
	protected string $first;

	/**
	 * The given name (first name) of this person. It is provided only if a buyer updated his/her address and name as a normalized form
	 */
	protected string $last;

	public function getFull(): string {
		return $this->full;
	}

	public function setFull(string $full): self {
		$this->setProperty('full', $full);

		return $this;
	}

	public function getFirst(): string {
		return $this->first;
	}

	public function setFirst(string $first): self {
		$this->setProperty('first', $first);

		return $this;
	}

	public function getLast(): string {
		return $this->last;
	}

	public function setLast(string $last): self {
		$this->setProperty('last', $last);

		return $this;
	}
}
