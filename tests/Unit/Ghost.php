<?php

namespace c0013r\GhostAPI\Tests\Unit;

use c0013r\GhostAPI\Exceptions\DataException;
use c0013r\GhostAPI\Tests\TestCase;

class Ghost extends TestCase
{
	public function testPostsFetch(): void
	{
		// simple fetch
		$posts = \c0013r\GhostAPI\Facades\Ghost::posts()
			->limit()->get();

		$this->assertNotEmpty($posts);

		// custom limit
		$posts = \c0013r\GhostAPI\Facades\Ghost::posts()
			->limit(1)->get();

		$this->assertCount(1, $posts);

		// with included data
		$posts = \c0013r\GhostAPI\Facades\Ghost::posts()
			->includeAuthors()->includeTags()->limit(1)->get();

		$this->assertNotEmpty($posts[0]->authors);
		$this->assertNotEmpty($posts[0]->tags);
	}

	public function testTagsFetch(): void
	{
		// simple fetch
		$tags = \c0013r\GhostAPI\Facades\Ghost::tags()
			->limit()->get();

		$this->assertNotEmpty($tags);
	}

	public function testUsersFetch(): void
	{
		// simple fetch
		$users = \c0013r\GhostAPI\Facades\Ghost::users()
			->limit()->get();

		$this->assertNotEmpty($users);
	}

	public function testExceptions(): void
	{
		$this->expectException(DataException::class);

		\c0013r\GhostAPI\Facades\Ghost::posts()
			->getById('abracadabra');
	}
}