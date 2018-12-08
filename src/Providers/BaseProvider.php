<?php

namespace c0013r\GhostAPI\Providers;

use Illuminate\Support\Collection;

abstract class BaseProvider
{
	private $client;

	protected $entityCode;
	protected $entityModelClass;

	protected $fields = [];

	protected $limit = 'all';
	protected $page = 1;

	protected $filter = [];
	protected $filterDelimeter = '+';

	protected $includes = [];

	public function __construct($client)
	{
		$this->client = $client;
	}

	public function get(): Collection
	{
		return $this->request($this->entityCode);
	}

	public function getById(string $id)
	{
		return $this->request(sprintf('%s/%s', $this->entityCode, $id))->first();
	}

	public function getBySlug(string $slug)
	{
		return $this->request(sprintf('%s/slug/%s', $this->entityCode, $slug))->first();
	}

	public function page(int $page)
	{
		$this->page = $page;

		return $this;
	}

	public function limit(int $limit = 15)
	{
		$this->limit = $limit;

		return $this;
	}

	public function filterAndMode()
	{
		$this->filterDelimeter = '+';

		return $this;
	}

	public function filterOrMode()
	{
		$this->filterDelimeter = ',';

		return $this;
	}

	private function request(string $url): Collection
	{
		$results = new Collection();

		$queryData = $this->modifyQuery($this->buildBaseQuery());
		$data = $this->client->request($url, $queryData);

		foreach ($data[$this->entityCode] as $postData)
		{
			$results->push(new $this->entityModelClass($postData));
		}

		return $results;
	}

	protected function modifyQuery(array $queryData): array
	{
		return $queryData;
	}

	private function buildBaseQuery(): array
	{
		$options = [
			'query' => [
				'absolute_urls' => true,
				'limit' => $this->limit,
				'include' => array_unique($this->includes)
			]
		];

		// filtering the fields we want to get
		if (\count($this->fields) > 0)
		{
			$options['query']['fields'] = $this->fields;
		}

		return $options;
	}

	protected function addInclude(string $include)
	{
		$this->includes[] = $include;

		return $this;
	}
}
