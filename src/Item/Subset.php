<?php

namespace Kcfbricks\PhpBricklinkSdk\Item;

use Kcfbricks\PhpBricklinkSdk\ApiObject;

class Subset extends ApiObject {
	protected int $matchNo;

	protected array $entries;

	public function getMatchNo(): int {
		return $this->matchNo;
	}

	public function setMatchNo(int $matchNo): self {
		$this->matchNo = $matchNo;

		return $this;
	}

	public function getEntries(): array {
		return $this->entries;
	}

	public function setEntries(array $entries): self {
		$this->entries = $entries;

		return $this;
	}
}
