<?php

namespace c0013r\GhostAPI\Models;

use Carbon\Carbon;

/**
 * Class User
 * @package c0013r\GhostAPI\Models
 *
 * @property-read string $name
 * @property-read string $accessibility
 * @property-read string $email
 * @property-read string $status
 * @property-read string $bio
 * @property-read string $locale
 * @property-read string $location
 * @property-read string $tour
 * @property-read string $website
 * @property-read string $coverImage
 * @property-read string $profileImage
 * @property-read Carbon $lastSeen
 */
class User extends BaseModel
{
	protected $casts = [
		'lastSeen' => 'datetime',
	];
}
