<?php

require_once __DIR__ . '/../vendor/autoload.php';

use Kcfbricks\PhpBricklinkSdk\Order\OrderRequest;
use Kcfbricks\PhpBricklinkSdk\Testing\MockClientFactory;

echo "=== BrickLink SDK Mock API Test ===\n\n";

// Create a mock client with normal, realistic responses
$client = MockClientFactory::createForKcfBricksOrder(12345);

// Test getting orders
echo "1. Testing mock order retrieval...\n";
$order = OrderRequest::getOrder($client, 12345);
if ($order) {
	echo "✓ Order {$order->getOrderId()} retrieved successfully\n";
	echo "  Status: {$order->getStatus()->value}\n";
	echo "  Buyer: {$order->getBuyerName()}\n";
	echo "  Total: \${$order->getCost()->getGrandTotal()}\n";
} else {
	echo "✗ Failed to retrieve order\n";
}

echo "\n2. Testing mock order items...\n";
$items = OrderRequest::getOrderItems($client, 12345);
echo "✓ Retrieved " . count($items) . " order items\n";
foreach (array_slice($items, 0, 3) as $i => $item) {
	if (is_object($item)) {
		echo "  - {$item->getItem()->getName()} ({$item->getQuantity()}x)\n";
	} else {
		echo "  - Item " . ($i + 1) . " (array format)\n";
	}
}

echo "\n3. Testing error scenario...\n";
try {
	$errorClient = MockClientFactory::createWithErrors();
	$order       = OrderRequest::getOrder($errorClient, 12345);
	echo "✗ Should have thrown an error\n";
} catch (Exception $e) {
	echo "✓ Error correctly thrown: " . get_class($e) . "\n";
}

echo "\n=== Mock API Test Complete ===\n";
echo "The SDK can now be tested without making real API calls!\n";
