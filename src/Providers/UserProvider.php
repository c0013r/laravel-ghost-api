<?php

namespace c0013r\GhostAPI\Providers;

class UserProvider extends BaseProvider
{
	protected $entityCode = 'users';
	protected $entityModelClass = \c0013r\GhostAPI\Models\User::class;

	public function includePostsCount()
	{
		return $this->addInclude('count.posts');
	}
}
