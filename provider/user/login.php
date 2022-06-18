<?php
/* @var mysqli $db */
require_once "../../config.php";
require_once "../../imports/db.php";
require_once "../utils/IO.php";

$fields_descriptions = [
	(object) [
		"name" => "user",
		"aliases" => ["user", "u"],
		"minlength" => 3,
		"maxlength" => 64,
	],
	(object) [
		"name" => "password",
		"aliases" => ["password", "pw"],
		"minlength" => 8,
		"maxlength" => 32,
	],
];

$fields = (object) fields_parse($fields_descriptions, "POST");

if ($fields->user == null || $fields->password == null) {
	throwError("Одно из полей не задано", 400, [
		"required_fields" => array_filter((array) $fields, function($fld){return $fld == null;}),
	]);
}

$userSelector = $db->escape_string($fields->user);
$password = md5($fields->password);

$search = $db->query("
	SELECT `id`
	FROM `".sql_database."`.`".db_users."`
	WHERE (`login` = '$userSelector' OR `email` = '$userSelector') AND `password` = '$password'
");

if ($search->num_rows == 0) {
	throwError("Логин/Email или пароль некорректны", 404);
}

$token_object = (object) [
	"userId" => $search->fetch_object()->id,
	"passwordHash" => md5(md5($fields->password).":".password_hash_key)
];

$token_data = json_encode($token_object);

$token = openssl_encrypt(
	$token_data,
	crypto_algo,
	token_crypto_key,
	OPENSSL_RAW_DATA,
	crypto_iv
);

$token = base64_encode($token);

$token .= ".".md5($token_data);

if ($_SERVER["HTTP_ACCEPT"] == "application/json") {
	closeJSON(202, (object) [
		"token" => $token,
		"timestamp" => time(),
	]);
}

setcookie("MC-token", $token, time()+session_expire, route, domain, false, true);

header("Location: ".route."/profile/index.php");
exit(202);

