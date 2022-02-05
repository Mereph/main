<?php

$db = mysqli_connect(sql_host, sql_user, sql_password, sql_database);

if (mysqli_connect_errno()) {
	echo json_encode(["error" => "SQL connection error"]);
	exit(500);
}

