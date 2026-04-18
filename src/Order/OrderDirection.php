<?php

declare(strict_types=1);

namespace Kcfbricks\PhpBricklinkSdk\Order;

enum OrderDirection: string {
	case Received = 'in';
	case Sent     = 'out';
}
