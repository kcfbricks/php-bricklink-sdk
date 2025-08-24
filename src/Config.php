<?php

namespace Kcfbricks\PhpBricklinkSdk;

class Config {
	public function __construct(
		public readonly string $consumerKey,
		public readonly string $consumerSecret,
		public readonly string $tokenValue,
		public readonly string $tokenSecret,
	) {}
}
