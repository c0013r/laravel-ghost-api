<?php

namespace c0013r\GhostAPI\Providers;

use c0013r\GhostAPI\Tests\TestCase;

class BaseProviderTest extends TestCase
{
	private $providerStub;

	public function setUp(): void
	{
		$this->providerStub = $this->getMockForAbstractClass(BaseProvider::class, [new \GuzzleHttp\Client()]);

		parent::setUp();
	}

	public function testFilterBuilding(): void
	{
		// simple filter
		$this->providerStub->addFilter(['featured' => true]);
		$filterQuery = $this->callMethod($this->providerStub, 'buildBaseQuery')['query']['filter'];
		$this->assertEquals('featured:true', $filterQuery);

		// simple filter by multiple fields
		$this->providerStub->addFilter([
			'featured' => true,
			'feature_image' => null,
			'visibility' => 'public'
		]);
		$filterQuery = $this->callMethod($this->providerStub, 'buildBaseQuery')['query']['filter'];
		$this->assertEquals("featured:true+feature_image:null+visibility:'public'", $filterQuery);

		// change filter mode
		$this->providerStub->filterOrMode();
		$filterQuery = $this->callMethod($this->providerStub, 'buildBaseQuery')['query']['filter'];
		$this->assertEquals("featured:true,feature_image:null,visibility:'public'", $filterQuery);

		// custom filter
		$this->providerStub->addFilter('tags:[tag-1,tag-2,hash-tag3]+id:-5982db374e619c7280060ed0');
		$filterQuery = $this->callMethod($this->providerStub, 'buildBaseQuery')['query']['filter'];
		$this->assertEquals('tags:[tag-1,tag-2,hash-tag3]+id:-5982db374e619c7280060ed0', $filterQuery);
	}
}
