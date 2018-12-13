<?php

namespace c0013r\GhostAPI\Tests\Unit\Models;

use c0013r\GhostAPI\Models\User;
use c0013r\GhostAPI\Tests\TestCase;

class UserTest extends TestCase
{
	public function testUserCreation(): void
	{
		$user = new User([
			'id' => 'test-id'
		]);

		$this->assertEquals('test-id', $user->id);
	}
}