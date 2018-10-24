<?php

namespace c0013r\GhostAPI\Tests\Unit\Models;

use c0013r\GhostAPI\Models\Tag;
use c0013r\GhostAPI\Tests\TestCase;

class TagTest extends TestCase
{
	/** @test */
	public function tagCreationTest(): void
	{
		$tag = new Tag([
			'id' => 'test-id'
		]);

		$this->assertEquals('test-id', $tag->id);
	}
}