<?php

namespace c0013r\GhostAPI\Providers;

class PostProvider extends BaseProvider
{
	protected $entityCode = 'posts';
	protected $entityModelClass = \c0013r\GhostAPI\Models\Post::class;

	private $formats = ['html', 'plaintext'];

	public function includeAuthors()
	{
		return $this->addInclude('authors');
	}

	public function includeTags()
	{
		return $this->addInclude('tags');
	}

	protected function modifyQuery(array $queryData): array
	{
		$queryData['query']['formats'] = $this->formats;

		return $queryData;
	}
}
