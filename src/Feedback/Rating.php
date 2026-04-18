<?php

declare(strict_types=1);

namespace Kcfbricks\PhpBricklinkSdk\Feedback;

enum Rating: int {
	case Praise    = 0;
	case Neutral   = 1;
	case Complaint = 2;
}
