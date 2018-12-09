<?php

namespace c0013r\GhostAPI\Providers;

class TagProvider extends BaseProvider
{
	protected $entityCode = 'tags';
	protected $entityModelClass = \c0013r\GhostAPI\Models\Tag::class;

	public function includePostsCount()
	{
		return $this->addInclude('count.posts');
	}
}
