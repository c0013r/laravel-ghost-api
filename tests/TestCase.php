<?php

namespace c0013r\GhostAPI\Tests;

use Dotenv\Dotenv;
use Orchestra\Testbench\TestCase as Orchestra;

abstract class TestCase extends Orchestra
{
	public function setUp()
	{
		$this->loadEnvironmentVariables();

		parent::setUp();
	}

	protected function loadEnvironmentVariables()
	{
		if (!file_exists(__DIR__ . '/../.env'))
		{
			return;
		}

		$dotenv = new Dotenv(__DIR__ . '/..');
		$dotenv->load();
	}


	/**
	 * @param \Illuminate\Foundation\Application $app
	 *
	 * @return array
	 */
	protected function getPackageProviders($app)
	{
		return [
			\c0013r\GhostAPI\ServiceProvider::class,
		];
	}
}
