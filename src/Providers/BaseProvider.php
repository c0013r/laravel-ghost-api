<?php

namespace c0013r\GhostAPI\Providers;

use c0013r\GhostAPI\Exceptions\DataException;
use Illuminate\Support\Collection;

abstract class BaseProvider
{
	private $client;

	protected $entityCode;
	protected $entityModelClass;

	protected $fields = [];

	protected $limit = 'all';
	protected $page = 1;

	protected $filter;
	protected $simpleFilterDelimeter = '+';

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

	public function addFilter($filterData)
	{
		if (\is_array($filterData) || \is_string($filterData))
		{
			$this->filter = $filterData;
		}
		else
		{
			throw new \InvalidArgumentException('Filter data is invalid. Use array for simple filter or string for custom filter.');
		}

		return $this;
	}

	public function filterAndMode()
	{
		$this->simpleFilterDelimeter = '+';

		return $this;
	}

	public function filterOrMode()
	{
		$this->simpleFilterDelimeter = ',';

		return $this;
	}

	private function request(string $url): Collection
	{
		$results = new Collection();

		$queryData = $this->modifyQuery($this->buildBaseQuery());
		$data = $this->client->request($url, $queryData);

		if (array_key_exists($this->entityCode, $data) && \is_array($data[$this->entityCode]))
		{
			foreach ($data[$this->entityCode] as $postData)
			{
				$results->push(new $this->entityModelClass($postData));
			}

			return $results;
		}

		throw DataException::noResultsFound($this->entityCode);
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

		// set filtering for results
		if ($this->filter !== null)
		{
			$readyFilter = null;

			if (\is_array($this->filter))
			{
				$readyFilter = [];

				foreach ($this->filter as $filterParameter => $filterValue)
				{
					$readyFilter[] = $filterParameter . ':' . $this->prepareFilterValue($filterValue);
				}

				$readyFilter = implode($this->simpleFilterDelimeter, $readyFilter);
			}
			else if (\is_string($this->filter))
			{
				$readyFilter = $this->filter;
			}

			if ($readyFilter !== null)
			{
				$options['query']['filter'] = $readyFilter;
			}
		}

		// filtering the fields we want to get
		if (\count($this->fields) > 0)
		{
			$options['query']['fields'] = $this->fields;
		}

		return $options;
	}

	private function prepareFilterValue($value)
	{
		$resultValues = [];

		if (\is_array($value))
		{
			foreach ($value as $singleValue)
			{
				$resultValues[] = $this->prepareFilterValue($singleValue);
			}
		}
		else if (\is_bool($value))
		{
			$resultValues[] = $value ? 'true' : 'false';
		}
		else if ($value === null)
		{
			$resultValues[] = 'null';
		}
		else
		{
			$resultValues[] = "'$value'";
		}

		return \count($resultValues) === 1
					? $resultValues[0]
					: sprintf('[%s]', implode(',', $resultValues));
	}

	protected function addInclude(string $include)
	{
		$this->includes[] = $include;

		return $this;
	}
}
