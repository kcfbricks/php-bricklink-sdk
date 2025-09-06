# BrickLink SDK Mock Testing

This SDK includes a comprehensive mock testing system that allows you to test your BrickLink integration without making real API calls.

## Basic Usage

### Create a Mock Client

```php
use Kcfbricks\PhpBricklinkSdk\Testing\MockClientFactory;

// Create a mock client with realistic test data
$mockClient = MockClientFactory::createWithRealisticData();

// Create a mock client with empty/minimal responses
$mockClient = MockClientFactory::createWithEmptyData();

// Create a mock client that simulates API errors
$mockClient = MockClientFactory::createWithErrors();
```

### Use Mock Client in Your Tests

```php
use Kcfbricks\PhpBricklinkSdk\Order\OrderRequest;
use Kcfbricks\PhpBricklinkSdk\Testing\MockClientFactory;

// Create mock client
$mockClient = MockClientFactory::createWithRealisticData();

// Use exactly like the real client
$orders = OrderRequest::getOrders($mockClient);
$order = OrderRequest::getOrder($mockClient, 12345);
$orderItems = OrderRequest::getOrderItems($mockClient, 12345);

// Verify requests were made (for testing)
$requestLog = $mockClient->getRequestLog();
assert($mockClient->wasRequestMade('orders'));
assert($mockClient->getRequestCount('orders') === 1);
```

## Specific Scenarios

### KCF Bricks Order Testing
```php
// Create a mock client with KCF Bricks specific test data
$mockClient = MockClientFactory::createForKcfBricksOrder(12345);

$order = OrderRequest::getOrder($mockClient, 12345);
// Will return realistic NZ-based order data with NZD currency
```

### Purged Order Testing
```php
// Test handling of purged orders that return 404
$mockClient = MockClientFactory::createWithPurgedOrder(99999);

try {
    $order = OrderRequest::getOrder($mockClient, 99999);
} catch (\Exception $e) {
    // Handle purged order scenario
}
```

## Custom Responses

### Set Custom Response
```php
use Kcfbricks\PhpBricklinkSdk\Testing\MockClient;
use Kcfbricks\PhpBricklinkSdk\Testing\MockResponseProvider;

$provider = new MockResponseProvider();
$provider->setCustomResponse('orders/12345', [
    'status' => 200,
    'body' => [
        'meta' => ['description' => 'OK', 'code' => 200],
        'data' => [
            'order_id' => 12345,
            'status' => 'RECEIVED',
            // ... your custom order data
        ]
    ]
]);

$mockClient = new MockClient($provider);
```

### Create Complex Test Scenarios
```php
// Create a provider with multiple custom responses
$provider = new MockResponseProvider();

// Successful order fetch
$provider->setCustomResponse('orders/12345', [
    'status' => 200,
    'body' => ['meta' => ['description' => 'OK', 'code' => 200], 'data' => [...]]
]);

// Failed order items fetch
$provider->setCustomResponse('orders/12345/items', [
    'status' => 500,
    'body' => ['meta' => ['description' => 'Internal Error', 'code' => 500]]
]);

$mockClient = MockClientFactory::createCustom($provider);
```

## Integration with Your App

### In composer.json
To use mock responses in development/testing, you can modify your app's dependency injection:

```php
// In your service configuration or bootstrap
$client = $_ENV['APP_ENV'] === 'test'
    ? MockClientFactory::createWithRealisticData()
    : new Client($consumerKey, $consumerSecret, $token, $tokenSecret);
```

### In CakePHP Application
```php
// In your OrderService or wherever you use the BrickLink client
public function __construct(?Client $brickLinkClient = null)
{
    $this->brickLinkClient = $brickLinkClient ?? $this->createClient();
}

private function createClient(): Client
{
    if (Configure::read('App.environment') === 'test') {
        return MockClientFactory::createForKcfBricksOrder();
    }

    return new Client(
        Configure::read('BrickLink.consumer_key'),
        Configure::read('BrickLink.consumer_secret'),
        Configure::read('BrickLink.token'),
        Configure::read('BrickLink.token_secret')
    );
}
```

## Request Logging and Assertions

The mock client logs all requests for testing assertions:

```php
$mockClient = MockClientFactory::createWithRealisticData();

// Make some requests
OrderRequest::getOrders($mockClient);
OrderRequest::getOrder($mockClient, 12345);

// Check what requests were made
$log = $mockClient->getRequestLog();
// $log contains: [['url' => 'orders', 'method' => 'GET', 'options' => [], 'timestamp' => ...], ...]

// Convenient assertion methods
assert($mockClient->wasRequestMade('orders')); // true
assert($mockClient->wasRequestMade('orders/12345')); // true
assert($mockClient->getRequestCount('orders') === 1); // true

// Clear log for next test
$mockClient->clearRequestLog();
```

## Default Mock Data

The mock system provides realistic default responses for:

- **Orders list**: Returns sample orders with realistic BrickLink data structure
- **Single order**: Returns detailed order information with costs, shipping, payment details
- **Order items**: Returns batched order items with part details, colours, quantities
- **Order updates**: Returns success responses for status changes, updates, drive-thru

All mock data follows the exact same structure as the real BrickLink API responses.
