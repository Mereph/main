<?php
function _header(object|null $user): string {
	$userBadge = userBadge($user);
	$main_path = route."/";
	$logo_path = route."/assets/image/dark_logo.webp";
	return <<< HTML
	<header class="header">
		<div class="header__left">
			<a class="button_link" href="${main_path}">
				<img src="${logo_path}" width="100" height="100" alt="logo">
			</a>
		</div>
		<div class="header__right">
			${userBadge}
		</div>
	</header>
	HTML;
}
