<?php

namespace c0013r\GhostAPI;

use GuzzleHttp\Client;
use GuzzleHttp\Exception\RequestException;
use c0013r\GhostAPI\Providers\PostProvider;
use c0013r\GhostAPI\Providers\TagProvider;
use c0013r\GhostAPI\Providers\UserProvider;

class Ghost
{
	/**
	 * Blog Base Uri
	 * @var string
	 */
	protected $baseUri;

	/**
	 * The username of the API user
	 * @var string
	 */
	protected $username;

	/**
	 * The API user password
	 * @var [type]
	 */
	protected $password;

	/**
	 * Client Id, usually you can use "ghost-frontend" if is hosted
	 * on their server as a XXX.ghost.ui page.
	 * @var string
	 */
	protected $clientId;

	/**
	 * Client secret. It can be found using the inspector
	 * on any page of the blog and looking at the script tags.
	 * @var string
	 */
	protected $clientSecret;

	/**
	 * The Guzzle client
	 * @var Client
	 */
	protected $httpClient;

	/**
	 * API token for authentication
	 * @var string
	 */
	protected $token;

	public function __construct()
	{
		$this->baseUri = config('ghost.base_uri');
		$this->username = config('ghost.username');
		$this->password = config('ghost.password');
		$this->clientId = config('ghost.client_id');
		$this->clientSecret = config('ghost.client_secret');

		$this->httpClient = new Client([
			'base_uri' => $this->baseUri . '/ghost/api/v0.1/'
		]);
	}

	/**
	 * Auth
	 *
	 * @return void
	 *
	 * @throws \GuzzleHttp\Exception\GuzzleException
	 */
	protected function auth(): void
	{
		if ($this->token === null)
		{
			$response = $this->httpClient->request('POST', 'authentication/token', [
				'form_params' => [
					'grant_type' => 'password',
					'username' => $this->username,
					'password' => $this->password,
					'client_id' => $this->clientId,
					'client_secret' => $this->clientSecret
				]
			]);

			// Here we make sure we are getting the token
			$responseData = json_decode($response->getBody()->getContents());

			if (!$responseData->access_token)
			{
				throw new \Exception('Unable to get access token.');

			}

			$this->token = $responseData->access_token;
		}
	}

	/**
	 * Sends an http request
	 *
	 * @param string $endpoint The service to request
	 * @param array $options The options of the request
	 *
	 * @return array
	 *
	 * @throws \GuzzleHttp\Exception\GuzzleException
	 */
	public function request($endpoint, $options): array
	{
		$data = [];

		// $this->auth();

		try
		{
			// default headers
//			$options['headers']['Authorization'] = 'Bearer ' . $this->token;
			$options['headers']['Content-Type'] = 'application/json';

			// auth data for public API
			$options['query']['client_id'] = $this->clientId;
			$options['query']['client_secret'] = $this->clientSecret;

			// do a request
			$response = $this->httpClient->request('GET', $endpoint, $options);
			$data = json_decode($response->getBody()->getContents(), true);
		}
		catch (RequestException $e)
		{

		}

		return $data;
	}

	public function posts(): PostProvider
	{
		return new PostProvider($this);
	}

	public function tags(): TagProvider
	{
		return new TagProvider($this);
	}

	public function users(): UserProvider
	{
		return new UserProvider($this);
	}
}