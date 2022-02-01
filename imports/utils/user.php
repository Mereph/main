<?php

function nameFormat(object $user): string {
	return $user->firstName." ".$user->lastName;
}
