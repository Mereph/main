<?

session_start();
$email = $_SESSION['newEmail'];
$password = $_SESSION['newPassword'];
$link = $_GET['link'];

if ($link == md5($email . $password . "2")) {
	header('Location: ../mdwload/MBrute.zip');
}
header('../profile');
?>
