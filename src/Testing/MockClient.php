<?php

namespace Kcfbricks\PhpBricklinkSdk\Testing;

use GuzzleHttp\Exception\ClientException;
use GuzzleHttp\Exception\RequestException;
use GuzzleHttp\Psr7\Response;
use Kcfbricks\PhpBricklinkSdk\Client;
use Kcfbricks\PhpBricklinkSdk\Config;
use Psr\Http\Message\ResponseInterface;

/**
 * Mock client for testing BrickLink API without making real requests
 */
class MockClient extends Client {
	private MockResponseProvider $responseProvider;
	private array $requests = [];

	public function __construct(MockResponseProvider $responseProvider) {
		// Create a dummy config since we won't be making real requests
		$dummyConfig = new Config('dummy', 'dummy', 'dummy', 'dummy');
		parent::__construct($dummyConfig);

		$this->responseProvider = $responseProvider;
	}

	/**
	 * Override the parent makeRequest method to use mock responses
	 */
	public function makeRequest(string $url, string $method = "GET", array $options = []): ResponseInterface {
		// Log the request for debugging
		$this->requests[] = [
			'method'    => $method,
			'url'       => $url,
			'options'   => $options,
			'timestamp' => time(),
		];

		// Get mock response data
		$responseData = $this->responseProvider->getResponse($url, $method, $options);

		// Create HTTP response
		$response = new Response(
			$responseData['status']  ?? 200,
			$responseData['headers'] ?? ['Content-Type' => 'application/json'],
			json_encode($responseData['body'] ?? [])
		);

		// Simulate HTTP error responses by throwing exceptions
		$statusCode = $response->getStatusCode();
		if ($statusCode >= 400) {
			$this->throwHttpException($statusCode, $response);
		}

		return $response;
	}

	/**
	 * Throw appropriate exception based on HTTP status code
	 */
	private function throwHttpException(int $statusCode, ResponseInterface $response): void {
		$message = "HTTP {$statusCode} error";

		if ($statusCode >= 400 && $statusCode < 500) {
			throw new ClientException($message, new \GuzzleHttp\Psr7\Request('GET', ''), $response);
		}
		throw new RequestException($message, new \GuzzleHttp\Psr7\Request('GET', ''), $response);
	}

	/**
	 * Get all logged requests
	 */
	public function getRequests(): array {
		return $this->requests;
	}

	/**
	 * Get request log (alias for getRequests for backward compatibility)
	 */
	public function getRequestLog(): array {
		return $this->requests;
	}

	/**
	 * Clear request log
	 */
	public function clearRequests(): void {
		$this->requests = [];
	}

	/**
	 * Get the mock response provider for customization
	 */
	public function getResponseProvider(): MockResponseProvider {
		return $this->responseProvider;
	}
}
