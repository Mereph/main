<?php

$fields_description = [
	[
		"name" => "firstName",
		"aliases" => ["firstname", "fn"],
		"maxlength" => 32,
	],
	[
		"name" => "lastName",
		"aliases" => ["lastname", "ln"],
		"maxlength" => 32,
	],
	[
		"name" => "email",
		"aliases" => ["email", "e"],
		"maxlength" => 64,
	],
	[
		"name" => "password",
		"aliases" => ["password", "pw"],
		"minlength" => 8,
	],
	[
		"name" => "TOS_agreement",
		"aliases" => ["tos"],
		"min" => 0,
		"max" => 1,
	]
];

$fields = (object) fields_parse($fields_description, "POST");

if (
	$fields->firstName == null || $fields->lastName == null || $fields->email == null
	|| $fields->password == null || $fields->TOS_agreement == null
) {
	throwError("Одно из полей не задано", 400, [
		"required_fields" => array_filter((array) $fields, function($fld){return $fld == null;}),
	]);
}
