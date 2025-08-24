<?php

namespace Kcfbricks\PhpBricklinkSdk;

use GuzzleHttp\Client as GuzzleClient;
use GuzzleHttp\HandlerStack;
use GuzzleHttp\Subscriber\Oauth\Oauth1;
use Psr\Http\Message\ResponseInterface;

class Client {
	public const API_BASE_URL = 'https://api.bricklink.com/api/store/v1/';

	protected GuzzleClient $client;

	public function __construct(protected Config $config) {
		$stack = HandlerStack::create();

		$middleware = new Oauth1([
			'consumer_key'     => $config->consumerKey,
			'consumer_secret'  => $config->consumerSecret,
			'token'            => $config->tokenValue,
			'token_secret'     => $config->tokenSecret,
			'signature_method' => Oauth1::SIGNATURE_METHOD_HMAC,
		]);
		$stack->push($middleware);

		$this->client = new GuzzleClient([
			'base_uri' => self::API_BASE_URL,
			'handler'  => $stack,
			'auth'     => 'oauth',
		]);
	}

	public function makeRequest(string $url, string $method = "GET", array $options = []): ResponseInterface {
		//TODO: throw exception on BrickLink errors?
		return $this->client->request($method, $url, $options);
	}
}
