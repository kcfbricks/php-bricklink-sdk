<?php

namespace Kcfbricks\PhpBricklinkSdk\Item;

enum ItemType: string {
	case Minifig      = "MINIFIG";
	case Part         = "PART";
	case Set          = "SET";
	case Book         = "BOOK";
	case Gear         = "GEAR";
	case Catalog      = "CATALOG";
	case Instruction  = "INSTRUCTION";
	case UnsortedLot  = "UNSORTED_LOT";
	case OriginalBox  = "ORIGINAL_BOX";
}
