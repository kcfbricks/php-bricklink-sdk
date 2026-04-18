<?php

declare(strict_types=1);

namespace Kcfbricks\PhpBricklinkSdk\Inventory;

enum Completeness: string {
	case Complete   = "C";
	case Incomplete = "B";
	case Sealed     = "S";
}
