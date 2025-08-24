<?php

namespace Kcfbricks\PhpBricklinkSdk;

abstract class ApiObject {
	/**
	 * An array of dirty fields to be updated
	 */
	protected array $dirtyFields = [];

	protected bool $hydrated = false;

	protected function setProperty(string $property, $value) {
		$this->$property = $value;

		if ($this->hydrated) {
			$this->dirtyFields[$property] = $value;
		}
	}

	public function getDirtyFields(): array {
		$dirtyFields = $this->dirtyFields;

		//include any dirty fields from child API objects
		foreach ($this as $thisProperty => $thisValue) {
			if (!$thisValue instanceof self) {
				continue;
			}

			$objectDirtyFields = $thisValue->getDirtyFields();
			if ($objectDirtyFields !== []) {
				$dirtyFields[$thisProperty] = $objectDirtyFields;
			}
		}

		return $dirtyFields;
	}

	public function clearDirtyField(?string $property = null): void {
		if ($property === null) {
			$this->dirtyFields = [];
		} else {
			unset($this->dirtyFields[$property]);
		}
	}

	public function setHydrated(): self {
		$this->hydrated = true;
		foreach ($this as $thisValue) {
			if ($thisValue instanceof self) {
				$thisValue->setHydrated();
			} elseif (is_array($thisValue)) {
				foreach ($thisValue as $thisObject) {
					if ($thisObject instanceof self) {
						$thisObject->setHydrated();
					}
				}
			}
		}

		return $this;
	}

	public function getSubmitFields(): array {
		return $this->convertKeys($this->getDirtyFields());
	}

	private function convertKeys(array $array): array {
		foreach ($array as $thisKey => $value) {
			if (is_array($value)) {
				$value = $this->convertKeys($value);
			}

			$underscoreKey         = $this->fromCamelCase($thisKey);
			$array[$underscoreKey] = $value instanceof self ? $value->getSubmitFields() : $value;

			if ($underscoreKey != $thisKey) {
				unset($array[$thisKey]);
			}
		}

		return $array;
	}

	private function fromCamelCase(string $string): string {
		$string[0] = strtolower($string[0]);

		return preg_replace_callback('#([A-Z])#', static fn ($c): string => "_" . strtolower($c[1]), $string);
	}
}
