<?php

namespace App\Enums;

class UserType
{
	const CLIENT = 1;
	const DELIVERY_REPRESENTATIVE = 2;
	const SHOP_REPRESENTATIVE = 3;
	const ADMIN = 4;

	public static $types = [
		'Client',
		'Delivery Representative',
		'Shop Representative',
		'Admin'
	];

	public static function getTypeString(int $value)
	{
		if ($value >= count(static::$types))
			return null;

		return static::$types[$value];
	}
}