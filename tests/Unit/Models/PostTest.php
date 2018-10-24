<?php

namespace c0013r\GhostAPI\Tests\Unit\Models;

use c0013r\GhostAPI\Models\Post;
use c0013r\GhostAPI\Tests\TestCase;

class PostTest extends TestCase
{
	/** @test */
	public function postCreationTest(): void
	{
		$post = new Post([
			'id' => 'test-id',
			'uuid' => 'test-uuid'
		]);

		$this->assertEquals('test-id', $post->id);
	}
}