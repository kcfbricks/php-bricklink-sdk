<?php

namespace Kcfbricks\PhpBricklinkSdk\Inventory;

enum Completeness: string {
	case Complete   = "C";
	case Incomplete = "B";
	case Sealed     = "S";
}
