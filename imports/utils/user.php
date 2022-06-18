<?php

function nameFormat(object $user): string {
	return $user->firstName." ".$user->lastName;
}

function readCookie(): object|null {
	$token_cookie = $_COOKIE["MC-token"];
	[$token, $hash] = explode('.', $token_cookie);

	$data = openssl_decrypt(
		base64_decode($token),
		crypto_algo,
		token_crypto_key,
		OPENSSL_RAW_DATA,
		crypto_iv
	);

	if (md5($data) != $hash) {
		return null;
	}

	return json_decode($data);
}

function getUser(int $id, array $fields = []): object|null {
	global $db;

	$select_fields = sizeof($fields) == 0 ? '*' : join(",", array_map(function($field){
		return"`$field`";
	}, $fields));

	$select = $db->query("
		SELECT $select_fields
		FROM `".sql_database."`.`".db_users."`
		WHERE `id` = $id
	");

	if ($select->num_rows == 0) {
		return null;
	}

	return $select->fetch_object();
}
