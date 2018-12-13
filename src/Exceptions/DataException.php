<?php

namespace c0013r\GhostAPI\Exceptions;

class DataException extends \Exception
{
	public static function noResultsFound(string $entity)
	{
		return new static("No {$entity} found", 404);
	}
}