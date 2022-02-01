<html lang="ru">
<?
session_start();
require_once "config.php";
require 'imports/user.php';
$response = "Не обрабатывается";
if ($_SESSION['newEmail'] != null && $_SESSION['newPassword'] != null) {
	$email = $_SESSION['newEmail'];
	$valid = validUser($_SESSION['newEmail'], $_SESSION['newPassword']);
	if ($valid == false) {
		header('Location: auth');
	} else {

	}
} else {
	header('Location: /');
}
?>
<head>
	<title>Mereph Payment</title>
	<link rel="stylesheet" href="assets/auth.css"/>
	<?php require_once "modules/metaTags.php" ?>
</head>
<body>
<center>
	<div class="center_div">
		<img src="assets/image/connect.webp">
		<div class="box" style="margin-bottom: 1em;">
			<?
			if (isset($_POST['product_id']) && is_numeric($_POST['product_id']) == true && $_POST['product_id'] <= getCountProducts()) {
				$product = getProduct($_POST['product_id']);
				$user = getUser($_SESSION['newEmail'], $_SESSION['newPassword'], "payment_state");
				if ($user['balance'] >= $product['product_price']) {
					$fullBalance = $user['balance'] - $product['product_price'];
					$fullBalanceHistory = $user['history'] . ";" . $product['product_type'] . ":" . $product['product_name'] . ":" . $product['id'];
					$db->query("UPDATE `users` SET `balance`='$fullBalance', `history`='$fullBalanceHistory' WHERE `email` = '$email'");
					$response = date("Y-m-d H:i:s");
					if ($product['id'] == "1") {
						$db->query("UPDATE `users` SET `status`='Verified' WHERE `email` = '$email'");
					}
					if ($product['id'] == "3") {
						$db->query("UPDATE `users` SET `status`='Verified2' WHERE `email` = '$email'");
					}
					?>

					<svg xmlns="http://www.w3.org/2000/svg" x="0px" y="0px"
					     width="96" height="96"
					     viewBox="0 0 172 172"
					     style=" fill:#000000;">
						<g fill="none" fill-rule="nonzero" stroke="none" stroke-width="1" stroke-linecap="butt"
						   stroke-linejoin="miter" stroke-miterlimit="10" stroke-dasharray="" stroke-dashoffset="0"
						   font-family="none" font-weight="none" font-size="none" text-anchor="none"
						   style="mix-blend-mode: normal">
							<path d="M0,172v-172h172v172z" fill="none"></path>
							<g fill="#6cf1a6">
								<path
									d="M86,5.73333c-44.33006,0 -80.26667,35.93661 -80.26667,80.26667c0,44.33006 35.93661,80.26667 80.26667,80.26667c44.33006,0 80.26667,-35.93661 80.26667,-80.26667c-0.0474,-44.31041 -35.95626,-80.21927 -80.26667,-80.26667zM83.14453,17.25599c18.72672,-0.7779 36.96021,6.11803 50.48534,19.09361c13.52513,12.97559 21.17102,30.90753 21.17012,49.6504c-0.04108,37.98016 -30.81984,68.75892 -68.8,68.8c-37.47238,0.04444 -68.089,-29.90761 -68.86678,-67.37194c-0.77777,-37.46433 28.56937,-68.66126 66.01131,-70.17207zM125.70781,51.67839c-1.36135,0.08519 -2.64773,0.65295 -3.62812,1.6013l-53.27969,53.27969l-18.87969,-18.87969c-1.44097,-1.48376 -3.5694,-2.07638 -5.56983,-1.55081c-2.00043,0.52557 -3.56271,2.08785 -4.08828,4.08828c-0.52557,2.00043 0.06705,4.12886 1.55081,5.56983l22.93333,22.93333c2.23891,2.23843 5.86838,2.23843 8.10729,0l57.33333,-57.33333c1.64585,-1.70121 2.07704,-4.23899 1.08542,-6.38832c-0.99162,-2.14933 -3.20217,-3.46832 -5.56459,-3.32027z"></path>
							</g>
						</g>
					</svg>

					<?
				} else {
					?>
					<svg xmlns="http://www.w3.org/2000/svg" x="0px" y="0px"
					     width="96" height="96"
					     viewBox="0 0 172 172"
					     style=" fill:#000000;">
						<g fill="none" fill-rule="nonzero" stroke="none" stroke-width="1" stroke-linecap="butt"
						   stroke-linejoin="miter" stroke-miterlimit="10" stroke-dasharray="" stroke-dashoffset="0"
						   font-family="none" font-weight="none" font-size="none" text-anchor="none"
						   style="mix-blend-mode: normal">
							<path d="M0,172v-172h172v172z" fill="none"></path>
							<g fill="#e74c3c">
								<path
									d="M171.23406,155.99594l-82.25094,-142.47781c-1.23625,-2.12313 -4.73,-2.12313 -5.96625,0l-82.56,143.00187c-0.60469,1.06156 -0.60469,2.37844 0,3.44c0.61812,1.06156 1.76031,1.72 2.98312,1.72h165.12c0.02688,0 0.05375,0 0.06719,0c1.90813,0 3.44,-1.53187 3.44,-3.44c0,-0.86 -0.30906,-1.63937 -0.83312,-2.24406zM80.81313,66.27375c0,-0.73906 0.49719,-1.23625 1.23625,-1.23625h7.90125c0.73906,0 1.22281,0.49719 1.22281,1.23625v49.74563c0,0.73906 -0.48375,1.23625 -1.22281,1.23625h-7.90125c-0.73906,0 -1.23625,-0.49719 -1.23625,-1.23625zM91.42875,137.385c0,0.73906 -0.49719,1.22281 -1.22281,1.22281h-8.39844c-0.73906,0 -1.22281,-0.49719 -1.22281,-1.22281v-9.01656c0,-0.73906 0.49719,-1.22281 1.22281,-1.22281h8.39844c0.73906,0 1.22281,0.48375 1.22281,1.22281z"></path>
							</g>
						</g>
					</svg>
					<?
					$response = "У вас не достаточно средств";
				}
			} else {
				?>
				<svg xmlns="http://www.w3.org/2000/svg" x="0px" y="0px"
				     width="96" height="96"
				     viewBox="0 0 172 172"
				     style=" fill:#000000;">
					<g fill="none" fill-rule="nonzero" stroke="none" stroke-width="1" stroke-linecap="butt"
					   stroke-linejoin="miter" stroke-miterlimit="10" stroke-dasharray="" stroke-dashoffset="0"
					   font-family="none" font-weight="none" font-size="none" text-anchor="none"
					   style="mix-blend-mode: normal">
						<path d="M0,172v-172h172v172z" fill="none"></path>
						<g fill="#e74c3c">
							<path
								d="M171.23406,155.99594l-82.25094,-142.47781c-1.23625,-2.12313 -4.73,-2.12313 -5.96625,0l-82.56,143.00187c-0.60469,1.06156 -0.60469,2.37844 0,3.44c0.61812,1.06156 1.76031,1.72 2.98312,1.72h165.12c0.02688,0 0.05375,0 0.06719,0c1.90813,0 3.44,-1.53187 3.44,-3.44c0,-0.86 -0.30906,-1.63937 -0.83312,-2.24406zM80.81313,66.27375c0,-0.73906 0.49719,-1.23625 1.23625,-1.23625h7.90125c0.73906,0 1.22281,0.49719 1.22281,1.23625v49.74563c0,0.73906 -0.48375,1.23625 -1.22281,1.23625h-7.90125c-0.73906,0 -1.23625,-0.49719 -1.23625,-1.23625zM91.42875,137.385c0,0.73906 -0.49719,1.22281 -1.22281,1.22281h-8.39844c-0.73906,0 -1.22281,-0.49719 -1.22281,-1.22281v-9.01656c0,-0.73906 0.49719,-1.22281 1.22281,-1.22281h8.39844c0.73906,0 1.22281,0.48375 1.22281,1.22281z"></path>
						</g>
					</g>
				</svg>
				<?
				header('Location: /');
			}
			?>
			<h2 style="margin-top: 5%;">Статус платежа</h2>
			<h1 class="box_chek"><?= $response ?></h1>
		</div>
		<a href="/" class="back">Вернуться в меню</a>
	</div>
</center>
</body>
</html>
