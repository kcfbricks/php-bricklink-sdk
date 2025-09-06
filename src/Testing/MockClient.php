<?php
declare(strict_types=1);

namespace Kcfbricks\PhpBricklinkSdk\Testing;

use GuzzleHttp\Psr7\Response;
use Kcfbricks\PhpBricklinkSdk\Client;
use Psr\Http\Message\ResponseInterface;

/**
 * MockClient for testing BrickLink SDK without making real API calls
 */
class MockClient extends Client {
	private MockResponseProvider $responseProvider;
	private array $requestLog = [];

	public function __construct(?MockResponseProvider $responseProvider = null) {
		// Don't call parent constructor to avoid setting up real HTTP client
		$this->responseProvider = $responseProvider ?? new MockResponseProvider();
	}

	/**
	 * Override makeRequest to return mock responses instead of real API calls
	 */
	public function makeRequest(string $url, string $method = 'GET', array $options = []): ResponseInterface {
		// Log the request for testing assertions
		$this->requestLog[] = [
			'url'       => $url,
			'method'    => $method,
			'options'   => $options,
			'timestamp' => time(),
		];

		// Get mock response from provider
		$mockResponse = $this->responseProvider->getResponse($url, $method, $options);

		// Convert mock response to PSR-7 Response
		return new Response(
			$mockResponse['status']  ?? 200,
			$mockResponse['headers'] ?? ['Content-Type' => 'application/json'],
			json_encode($mockResponse['body'])
		);
	}

	/**
	 * Get all requests made to this mock client (for testing assertions)
	 */
	public function getRequestLog(): array {
		return $this->requestLog;
	}

	/**
	 * Clear the request log
	 */
	public function clearRequestLog(): void {
		$this->requestLog = [];
	}

	/**
	 * Check if a specific request was made
	 */
	public function wasRequestMade(string $url, string $method = 'GET'): bool {
		foreach ($this->requestLog as $request) {
			if ($request['url'] === $url && $request['method'] === $method) {
				return true;
			}
		}
		return false;
	}

	/**
	 * Get the number of requests made to a specific endpoint
	 */
	public function getRequestCount(string $url, string $method = 'GET'): int {
		$count = 0;
		foreach ($this->requestLog as $request) {
			if ($request['url'] === $url && $request['method'] === $method) {
				$count++;
			}
		}
		return $count;
	}

	/**
	 * Set a custom response provider
	 */
	public function setResponseProvider(MockResponseProvider $provider): void {
		$this->responseProvider = $provider;
	}
}
