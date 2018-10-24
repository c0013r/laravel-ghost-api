<?php

namespace c0013r\GhostAPI\Models;

use Illuminate\Support\Carbon;
use Illuminate\Support\Str;

/**
 * Class BaseModel
 * @package c0013r\GhostAPI\Models
 *
 * @property-read string $id
 * @property-read string $slug
 * @property-read string $visibility
 * @property-read string $metaTitle
 * @property-read string $metaDescription
 * @property-read Carbon $createdAt
 * @property-read string $createdBy
 * @property-read Carbon $updatedAt
 * @property-read string $updatedBy
 * @property-read string $featureImage
 */
class BaseModel
{
	private $attributes = [];

	protected $casts = [];
	private $castsCache = [];

	/**
	 * @param array $data Data for the object
	 */
	public function __construct(array $data)
	{
		$this->casts = array_merge($this->casts, [
			'createdAt' => 'datetime',
			'updatedAt' => 'datetime',
		]);

		foreach ($data as $key => $value)
		{
			$key = Str::camel($key);
			$this->attributes[$key] = $value;
		}
	}

	/**
	 * Cast an attribute to a native PHP type.
	 *
	 * @param  string  $key
	 * @param  mixed  $value
	 * @return mixed
	 */
	protected function castAttribute($key, $value)
	{
		if ($value === null || !array_key_exists($key, $this->casts))
		{
			return $value;
		}

		switch ($this->casts[$key])
		{
			case 'int':
			case 'integer':
				return (int) $value;

			case 'real':
			case 'float':
			case 'double':
				return (float) $value;

			case 'string':
				return (string) $value;

			case 'bool':
			case 'boolean':
				return (bool) $value;

			case 'object':
				return json_decode($value, true);

			case 'array':
			case 'json':
				return json_decode($value, false);

			case 'collection':
				return collect(json_decode($value, false));

			case 'date':
				return $this->asDateTime($value)->startOfDay();

			case 'datetime':
				return $this->asDateTime($value);

			default:
				return $value;
		}
	}

	/**
	 * Return a timestamp as DateTime object.
	 *
	 * @param  mixed  $value
	 * @return \Illuminate\Support\Carbon
	 */
	protected function asDateTime($value): Carbon
	{
		if ($value instanceof Carbon)
		{
			return $value;
		}

		if ($value instanceof \DateTimeInterface)
		{
			return new Carbon(
				$value->format('Y-m-d H:i:s.u'),
				$value->getTimezone()
			);
		}

		if (is_numeric($value))
		{
			return Carbon::createFromTimestamp($value);
		}

		if (preg_match('/^(\d{4})-(\d{1,2})-(\d{1,2})$/', $value))
		{
			return Carbon::createFromFormat('Y-m-d', $value)->startOfDay();
		}

		return Carbon::createFromFormat(
			str_replace('.v', '.u', $this->getDateFormat()),
			$value
		);
	}

	/**
	 * @param string $propertyName
	 *
	 * @return mixed
	 */
	public function __get($propertyName)
	{
		// check casted cache
		if (!array_key_exists($propertyName, $this->castsCache))
		{
			$this->castsCache[$propertyName] = $this->castAttribute($propertyName, $this->attributes[$propertyName]);
		}

		return $this->castsCache[$propertyName];
	}

	/**
	 * @param string $propertyName
	 * @param mixed $propertyValue
	 */
	public function __set($propertyName, $propertyValue)
	{
		// TODO: throw exception - read only allowed
	}

	/**
	 * @param string $propertyName
	 *
	 * @return bool
	 */
	public function __isset($propertyName)
	{
		return array_key_exists($propertyName, $this->attributes);
	}
}
