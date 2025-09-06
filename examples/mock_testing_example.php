<?php
/**
 * Example script demonstrating BrickLink SDK Mock Testing
 *
 * Run this from the php-bricklink-sdk directory:
 * php examples/mock_testing_example.php
 */

require_once __DIR__ . '/../vendor/autoload.php';

use Kcfbricks\PhpBricklinkSdk\Order\OrderRequest;
use Kcfbricks\PhpBricklinkSdk\Testing\MockClientFactory;
use Kcfbricks\PhpBricklinkSdk\Testing\MockResponseProvider;
use Kcfbricks\PhpBricklinkSdk\Testing\MockClient;

echo "=== BrickLink SDK Mock Testing Example ===\n\n";

// Example 1: Basic Mock Client Usage
echo "1. Creating mock client with realistic data...\n";
$mockClient = MockClientFactory::createWithRealisticData();

$orders = OrderRequest::getOrders($mockClient);
echo "Found " . count($orders) . " orders\n";

if (!empty($orders)) {
    $firstOrder = $orders[0];

    echo "First order ID: " . $firstOrder->getOrderId() . "\n";
    echo "Buyer: " . $firstOrder->getBuyerName() . "\n";
    echo "Total: " . $firstOrder->getDispCost()->getGrandTotal() . "\n";
}

// Example 2: Getting Order Items
echo "\n2. Getting order items...\n";
$orderItems = OrderRequest::getOrderItems($mockClient, 12345);
echo "Found " . count($orderItems) . " batches\n";

foreach ($orderItems as $batchKey => $batch) {
    echo "Batch {$batchKey}: " . count($batch) . " items\n";
    foreach ($batch as $item) {
        echo "  - {$item->getItem()->getName()} x{$item->getQuantity()} ({$item->getColorName()})\n";
    }
}

// Example 3: Request Logging
echo "\n3. Request logging...\n";
$requestLog = $mockClient->getRequestLog();
echo "Total requests made: " . count($requestLog) . "\n";
foreach ($requestLog as $request) {
    echo "  {$request['method']} {$request['url']}\n";
}

// Example 4: KCF Bricks Specific Mock
echo "\n4. KCF Bricks specific mock...\n";
$kcfMockClient = MockClientFactory::createForKcfBricksOrder(12345);
$kcfOrder = OrderRequest::getOrder($kcfMockClient, 12345);

echo "Store: " . $kcfOrder->getStoreName() . "\n";
echo "Currency: " . $kcfOrder->getPayment()->getCurrencyCode() . "\n";
echo "Country: " . $kcfOrder->getShipping()->getAddress()->getCountryCode() . "\n";

// Example 5: Error Simulation
echo "\n5. Error simulation...\n";
$errorClient = MockClientFactory::createWithErrors();
try {
    $orders = OrderRequest::getOrders($errorClient);
    echo "This shouldn't happen - should have thrown an exception\n";
} catch (Exception $e) {
    echo "Caught expected error: HTTP 500 response\n";
}

// Example 6: Custom Responses
echo "\n6. Custom responses...\n";
$provider = new MockResponseProvider();
$provider->setCustomResponse('orders/99999', [
    'status' => 200,
    'body' => [
        'meta' => ['description' => 'OK', 'code' => 200],
        'data' => [
            'order_id' => 99999,
            'seller_name' => 'custom_seller',
            'store_name' => 'Custom Test Store',
            'status' => 'CUSTOM_STATUS'
        ]
    ]
]);

$customClient = new MockClient($provider);
$customOrder = OrderRequest::getOrder($customClient, 99999);
echo "Custom order store: " . $customOrder->getStoreName() . "\n";

// Example 7: Purged Order Testing
echo "\n7. Purged order testing...\n";
$purgedClient = MockClientFactory::createWithPurgedOrder(99999);
try {
    $purgedOrder = OrderRequest::getOrder($purgedClient, 99999);
    echo "This shouldn't happen - should have thrown an exception\n";
} catch (Exception $e) {
    echo "Caught expected purged order error: {$e->getMessage()}\n";
}

echo "\n=== Mock Testing Complete ===\n";
echo "Check the documentation in MOCK_TESTING.md for more details.\n";
