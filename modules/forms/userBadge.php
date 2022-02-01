<?php

function userBadge(object|null $user): string {
	if ($user == null) {
		$auth_path = route."/auth.php";
		return <<< HTML
			<a class="button_link" href="${auth_path}">
				<button>Авторизоваться</button>
			</a>
		HTML;
	}
	$display_name = nameFormat($user);
	$balance = $user->balance;
	$profile_path = route."/profile.php";
	return <<< HTML
		<a class="userBadge" href="${profile_path}">
			<span class="userBadge__name">${display_name}</span>
			<div class="userBadge__balance">${balance}₽</div>
		</a>
	HTML;
}
