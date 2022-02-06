<?php
/* @var mysqli $db */
require_once "../../config.php";
require_once "../../imports/db.php";
require_once "../utils/IO.php";

$fields_description = [
	(object) [
		"name" => "login",
		"aliases" => ["login", "l"],
		"regex" => "/^[^@]+$/",
		"minlength" => 3,
		"maxlength" => 24,
	],
	(object) [
		"name" => "firstName",
		"aliases" => ["firstname", "fn"],
		"maxlength" => 32,
	],
	(object) [
		"name" => "lastName",
		"aliases" => ["lastname", "ln"],
		"maxlength" => 32,
	],
	(object) [
		"name" => "email",
		"aliases" => ["email", "e"],
		"regex" => "/^[^@]+@[^@]+$/",
		"maxlength" => 64,
	],
	(object) [
		"name" => "password",
		"aliases" => ["password", "pw"],
		"minlength" => 8,
	],
	(object) [
		"name" => "TOS_agreement",
		"aliases" => ["tos"],
		"min" => 0,
		"max" => 1,
	]
];

$fields = (object) fields_parse($fields_description, "POST");

if (
	$fields->login == null || $fields->firstName == null || $fields->lastName == null || $fields->email == null
	|| $fields->password == null || $fields->TOS_agreement == null
) {
	throwError("Одно из полей не задано", 400, [
		"required_fields" => array_filter((array) $fields, function($fld){return $fld == null;}),
	]);
}

$fields = (object) [
	"login" => $db->escape_string($fields->login),
	"firstName" => $db->escape_string($fields->firstName),
	"lastName" => $db->escape_string($fields->lastName),
	"email" => $db->escape_string($fields->email),
	"password" => md5($fields->password),
	"TOS_agreement" => (bool) $fields->TOS_agreement,
];

if (!$fields->TOS_agreement) {
	throwError("Вы не приняли пользовательское соглашение", 451, [
		"TOS_agreement" => "https://mereph.ru/terms.php",
	]);
}

$uniqueCheck = $db->query("
	SELECT COUNT(`id`) as `count` 
	FROM `".sql_database."`.`".db_users."`
	WHERE `login` = '".$fields->login."' OR `email` = '".$fields->email."'
");

if ($uniqueCheck->fetch_object()->count != 0) {
	throwError("Логин или почта уже заняты", 409, [
		"login" => $fields->login,
		"email" => $fields->email,
	]);
}

$values_array = array_map(function($field){
	return "'$field'";
}, array_values([
	$fields->login,
	$fields->firstName,
	$fields->lastName,
	$fields->email,
	$fields->password,
]));

$values = join(", ", $values_array);

$insert = $db->query("
	INSERT INTO `".sql_database."`.`".db_users."`(`login`, `firstName`, `lastName`, `email`, `password`)
	VALUES ($values)
");

if (!$insert) {
	throwError("Внутренняя SQL ошибка", 520, [
		"values" => $values
	]);
}

if ($_SERVER["HTTP_ACCEPT"] == "application/json") {
	closeJSON(200, (object) [
		"success" => [
			"login" => $fields->login,
			"timestamp" => time(),
		],
	]);
}

header("Location: ".route."/auth.php");
exit(201);
