<?php

namespace c0013r\GhostAPI\Tests\Unit\Models;

use c0013r\GhostAPI\Models\Post;
use c0013r\GhostAPI\Tests\TestCase;
use Carbon\Carbon;

class PostTest extends TestCase
{
	/** @test */
	public function postCreationTest(): void
	{
		$post = new Post([
			'id' => 'test-id',
			'uuid' => 'test-uuid',
			'created_at' => '2018-12-05T10:00:01.000Z',
			'updated_at' => '2018-12-08T11:00:01.000Z',
			'published_at' => '2018-12-09T12:00:01.000Z'
		]);

		$this->assertEquals('test-id', $post->id);
		$this->assertInstanceOf(Carbon::class, $post->createdAt);
		$this->assertInstanceOf(Carbon::class, $post->updatedAt);
		$this->assertInstanceOf(Carbon::class, $post->publishedAt);
	}
}