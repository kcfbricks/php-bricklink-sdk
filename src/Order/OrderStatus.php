<?php
declare(strict_types=1);

namespace Kcfbricks\PhpBricklinkSdk\Order;

enum OrderStatus: string {
	case PENDING    = "PENDING";
	case UPDATED    = "UPDATED";
	case PROCESSING = "PROCESSING";
	case READY      = "READY";
	case PAID       = "PAID";
	case PACKED     = "PACKED";
	case SHIPPED    = "SHIPPED";
	case RECEIVED   = "RECEIVED";
	case COMPLETED  = "COMPLETED";
	case OCR        = "OCR";
	case NPB        = "NPB";
	case NPX        = "NPX";
	case NRS        = "NRS";
	case NSS        = "NSS";
	case CANCELLED  = "CANCELLED";
}
