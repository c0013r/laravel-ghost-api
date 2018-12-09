<?php

namespace c0013r\GhostAPI\Tests;

use Dotenv\Dotenv;
use Orchestra\Testbench\TestCase as Orchestra;

abstract class TestCase extends Orchestra
{
	public function setUp(): void
	{
		$this->loadEnvironmentVariables();

		parent::setUp();
	}

	protected function loadEnvironmentVariables(): void
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
	protected function getPackageProviders($app): array
	{
		return [
			\c0013r\GhostAPI\ServiceProvider::class,
		];
	}

	protected function callMethod($obj, $name, array $args = [])
	{
		$class = new \ReflectionClass($obj);

		$method = $class->getMethod($name);
		$method->setAccessible(true);

		return $method->invokeArgs($obj, $args);
	}
}
