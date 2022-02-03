<?php

function throwError(string $description, int $code = 500, array $payload = []) {
	$json = json_encode([
		"error" => [
			"description" => $description,
		],
		"payload" => $payload,
	]);
	if ($_SERVER["HTTP_ACCEPT"] == "application/json") {
		header("Content-Type: application/json");
		echo $json;
		exit($code);
	}
	$json = str_replace("'", "\'", $json);
	echo $description."<br><a href=\"".route."\">Main page</a>";
	echo "<script>console.log('$json')</script>";
	exit($code);
}

function fields_parse(array $descriptions, string $method = "GET"): array {
	$methodLink = match ($method) {
		"PUT" => json_decode(file_get_contents("php://input")),
		"POST" => $_POST,
		default => $_GET,
	};
	$processed = [];
	foreach ($descriptions as $description) {
		$processed[$description->name] = null;
		foreach ($description->aliases as $alias) {
			if (empty($methodLink[$alias])) {
				continue;
			}
			$processed[$description->name] = $methodLink[$alias];
			break;
		}
		if (!empty($description->minlength) && $description->minlength > strlen($processed[$description->name])) {
			$processed[$description->name] = null;
			continue;
		}
		if (!empty($description->maxlength) && $description->maxlength < strlen($processed[$description->name])) {
			$processed[$description->name] = substr($processed[$description->name], 0, $description->maxlength - 1);
		}
		if (!empty($description->min) && $description->min > (int) $processed[$description->name]) {
			$processed[$description->name] = (string) $description->min;
		}
		if (!empty($description->max) && $description->max < (int) $processed[$description->name]) {
			$processed[$description->name] = (string) $description->max;
		}
	}
	return $processed;
}
