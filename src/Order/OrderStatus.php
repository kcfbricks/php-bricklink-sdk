<?php
declare(strict_types=1);

namespace Kcfbricks\PhpBricklinkSdk\Order;

enum OrderStatus: string {
	case Pending    = "PENDING";
	case Updated    = "UPDATED";
	case Processing = "PROCESSING";
	case Ready      = "READY";
	case Paid       = "PAID";
	case Packed     = "PACKED";
	case Shipped    = "SHIPPED";
	case Received   = "RECEIVED";
	case Completed  = "COMPLETED";
	case Ocr        = "OCR";
	case Npb        = "NPB";
	case Npx        = "NPX";
	case Nrs        = "NRS";
	case Nss        = "NSS";
	case Cancelled  = "CANCELLED";
	case Purged     = "PURGED";
}
