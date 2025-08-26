<?php
declare(strict_types=1);

namespace Kcfbricks\PhpBricklinkSdk\Order;

enum PaymentStatus: string {
	case None      = 'None';
	case Sent      = 'Sent';
	case Received  = 'Received';
	case Paid      = 'Paid';
	case Clearing  = 'Clearing';
	case Returned  = 'Returned';
	case Bounced   = 'Bounced';
	case Completed = 'Completed';
}
