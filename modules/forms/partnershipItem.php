<?php
function partnershipItem(string $name, array $image, string $link): string {
	$image = [
		"link" => $image["link"],
		"width" => $image["width"] ?? "",
		"height" => $image["height"] ?? "",
		"alt" => $image["alt"] ?? "",
	];
	return <<< HTML
		<div class="partnerItem">
			<h3 class="partnerItem__title">${name}</h3>
			<img class="partnerItem__logo" src="${image["link"]}" width="${image["width"]}" height="${image["height"]}" alt="${image["alt"]}">
			<a class="partnerItem__link button_link" href="${link}" target="_blank">
				<button>Продолжить</button>
			</a>
		</div>
HTML;

}
