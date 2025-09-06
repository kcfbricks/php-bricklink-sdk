# php-bricklink-sdk
PHP SDK for the BrickLink API

## Features

- Complete BrickLink API integration
- OAuth1 authentication
- Order management (fetch, update, status changes)
- Inventory operations
- **Mock testing system** for development and testing without real API calls

## Mock Testing

This SDK includes a comprehensive mock testing system that allows you to develop and test your BrickLink integration without making real API calls.

```php
use Kcfbricks\PhpBricklinkSdk\Testing\MockClientFactory;
use Kcfbricks\PhpBricklinkSdk\Order\OrderRequest;

// Create mock client with realistic test data
$mockClient = MockClientFactory::createWithRealisticData();

// Use exactly like the real client
$orders = OrderRequest::getOrders($mockClient);
$order = OrderRequest::getOrder($mockClient, 12345);
$orderItems = OrderRequest::getOrderItems($mockClient, 12345);
```

See [MOCK_TESTING.md](MOCK_TESTING.md) for complete documentation and examples.
