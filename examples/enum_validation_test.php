<?php
/**
 * Test script to verify enum validation works correctly
 *
 * Run this from the php-bricklink-sdk directory:
 * php examples/enum_validation_test.php
 */

require_once __DIR__ . '/../vendor/autoload.php';

use Kcfbricks\PhpBricklinkSdk\Feedback\FeedbackRequest;
use Kcfbricks\PhpBricklinkSdk\Inventory\InventoryRequest;
use Kcfbricks\PhpBricklinkSdk\Item\ItemRequest;
use Kcfbricks\PhpBricklinkSdk\Order\OrderRequest;
use Kcfbricks\PhpBricklinkSdk\Testing\MockClientFactory;

echo "=== BrickLink SDK Enum Validation Test ===\n\n";

// Create mock client with invalid enum values
$mockClient = MockClientFactory::createWithInvalidEnums(12345);

echo "1. Testing Order with invalid status...\n";
try {
	$order = OrderRequest::getOrder($mockClient, 12345);

	// Check that invalid enum values were converted to default values
	$status = $order->getStatus();
	if ($status && $status->value === 'PENDING') {
		echo "✓ Invalid order status correctly handled (defaulted to PENDING)\n";
	} else {
		echo "✗ Invalid order status not handled correctly: " . ($status ? $status->value : 'null') . "\n";
	}

	// Check payment status
	$payment = $order->getPayment();
	if ($payment && $payment->getStatus() && $payment->getStatus()->value === 'None') {
		echo "✓ Invalid payment status correctly handled (defaulted to None)\n";
	} else {
		echo "✗ Invalid payment status not handled correctly\n";
	}
} catch (Exception $e) {
	echo "✗ Exception thrown for invalid order status: " . $e->getMessage() . "\n";
}

echo "\n2. Testing Order Items with invalid enums...\n";
try {
	$orderItems = OrderRequest::getOrderItems($mockClient, 12345);

	if (!empty($orderItems) && !empty($orderItems['0'])) {
		$firstItem = $orderItems['0'][0];

		// Check condition
		$condition = $firstItem->getNewOrUsed();
		if ($condition && $condition->value === 'N') {
			echo "✓ Invalid condition correctly handled (defaulted to New)\n";
		} else {
			echo "✗ Invalid condition not handled correctly: " . ($condition ? $condition->value : 'null') . "\n";
		}

		// Check completeness
		$completeness = $firstItem->getCompleteness();
		if ($completeness === null) {
			echo "✓ Invalid completeness correctly handled (set to null)\n";
		} else {
			echo "✗ Invalid completeness not handled: " . $completeness->value . "\n";
		}

		// Check item type
		$itemType = $firstItem->getItem()->getType();
		if ($itemType && $itemType->value === 'PART') {
			echo "✓ Invalid item type correctly handled (defaulted to PART)\n";
		} else {
			echo "✗ Invalid item type not handled correctly: " . ($itemType ? $itemType->value : 'null') . "\n";
		}
	} else {
		echo "✗ No order items returned\n";
	}
} catch (Exception $e) {
	echo "✗ Exception thrown for invalid order items: " . $e->getMessage() . "\n";
}

echo "\n3. Testing Inventory Item with invalid enums...\n";
try {
	$inventoryItem = InventoryRequest::getInventoryItem($mockClient, 111111);

	if ($inventoryItem) {
		// Check condition
		$condition = $inventoryItem->getNewOrUsed();
		if ($condition && $condition->value === 'N') {
			echo "✓ Invalid inventory condition correctly handled (defaulted to New)\n";
		} else {
			echo "✗ Invalid inventory condition not handled correctly: " . ($condition ? $condition->value : 'null') . "\n";
		}

		// Check completeness
		$completeness = $inventoryItem->getCompleteness();
		if ($completeness === null) {
			echo "✓ Invalid inventory completeness correctly handled (set to null)\n";
		} else {
			echo "✗ Invalid inventory completeness not handled: " . $completeness->value . "\n";
		}
	} else {
		echo "✗ No inventory item returned\n";
	}
} catch (Exception $e) {
	echo "✗ Exception thrown for invalid inventory item: " . $e->getMessage() . "\n";
}

echo "\n4. Testing Catalogue Item with invalid type...\n";
try {
	$catalogueItem = ItemRequest::getCatalogueItem($mockClient, '3001');

	if ($catalogueItem) {
		// Check item type
		$itemType = $catalogueItem->getType();
		if ($itemType && $itemType->value === 'PART') {
			echo "✓ Invalid catalogue item type correctly handled (defaulted to PART)\n";
		} else {
			echo "✗ Invalid catalogue item type not handled correctly: " . ($itemType ? $itemType->value : 'null') . "\n";
		}
	} else {
		echo "✗ No catalogue item returned\n";
	}
} catch (Exception $e) {
	echo "✗ Exception thrown for invalid catalogue item: " . $e->getMessage() . "\n";
}

echo "\n5. Testing Feedback with invalid ratings...\n";
try {
	$order    = OrderRequest::getOrder($mockClient, 12345);
	$feedback = FeedbackRequest::getFeedbackForOrder($mockClient, $order);

	if (!empty($feedback)) {
		$firstFeedback = $feedback[0];

		// Check rating
		$rating = $firstFeedback->getRating();
		if ($rating && $rating->value === 1) {
			echo "✓ Invalid rating correctly handled (defaulted to Neutral)\n";
		} else {
			echo "✗ Invalid rating not handled correctly: " . ($rating ? $rating->value : 'null') . "\n";
		}

		// Check rating of bs
		$ratingOfBs = $firstFeedback->getRatingOfBs();
		if ($ratingOfBs && $ratingOfBs->value === 'B') {
			echo "✓ Invalid rating of bs correctly handled (defaulted to Buyer)\n";
		} else {
			echo "✗ Invalid rating of bs not handled correctly: " . ($ratingOfBs ? $ratingOfBs->value : 'null') . "\n";
		}
	} else {
		echo "✗ No feedback returned\n";
	}
} catch (Exception $e) {
	echo "✗ Exception thrown for invalid feedback: " . $e->getMessage() . "\n";
}

echo "\n=== Enum Validation Test Complete ===\n";
echo "All enum validation checks completed. Invalid enum values should be set to sensible defaults rather than throwing exceptions.\n";
echo "Nullable enum properties are set to null, while non-nullable properties get reasonable default values.\n";
