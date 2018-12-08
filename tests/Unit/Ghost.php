<?php

namespace c0013r\GhostAPI\Tests\Unit;

use c0013r\GhostAPI\Models\Post;
use c0013r\GhostAPI\Models\Tag;
use c0013r\GhostAPI\Models\User;
use c0013r\GhostAPI\Tests\TestCase;
use Carbon\Carbon;

class Ghost extends TestCase
{
	/** @test */
	public function postsFetchTest(): void
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

	/** @test */
	public function tagsFetchTest(): void
	{
		// simple fetch
		$tags = \c0013r\GhostAPI\Facades\Ghost::tags()
			->limit()->get();

		$this->assertNotEmpty($tags);
	}

	/** @test */
	public function usersFetchTest(): void
	{
		// simple fetch
		$users = \c0013r\GhostAPI\Facades\Ghost::users()
			->limit()->get();

		$this->assertNotEmpty($users);
	}

	/** @test */
	public function propertyCastsTest(): void
	{
		/** @var Post $post */
		$post = \c0013r\GhostAPI\Facades\Ghost::posts()
			->limit(1)->get()->first();

		$this->assertInstanceOf(Carbon::class, $post->createdAt);
		$this->assertInstanceOf(Carbon::class, $post->updatedAt);
		$this->assertInstanceOf(Carbon::class, $post->publishedAt);

		/** @var Tag $tag */
		$tag = \c0013r\GhostAPI\Facades\Ghost::tags()
			->limit(1)->get()->first();

		$this->assertInstanceOf(Carbon::class, $tag->createdAt);
		$this->assertInstanceOf(Carbon::class, $tag->updatedAt);

		/** @var User $user */
		$user = \c0013r\GhostAPI\Facades\Ghost::users()
			->limit(1)->get()->first();

		$this->assertInstanceOf(Carbon::class, $user->createdAt);
		$this->assertInstanceOf(Carbon::class, $user->updatedAt);
		$this->assertInstanceOf(Carbon::class, $user->lastSeen);
	}
}