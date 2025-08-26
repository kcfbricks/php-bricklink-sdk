<?php

namespace Kcfbricks\PhpBricklinkSdk\Order;

enum OrderDirection: string {
	case Received = 'in';
	case Sent = 'out';
}
