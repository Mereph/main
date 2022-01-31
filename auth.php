<html lang="ru">
<?
session_start();
require_once "config.php";
require 'imports/user.php';
if ($_SESSION['backAuth'] == true) {
  header('Location: /');
}
?>
<head>
    <title>Mereph Connect</title>
    <link rel="stylesheet" href="assets/auth.css"/>
  <?php require_once "modules/metaTags.php" ?>
</head>
<body>
<center>
    <div class="center_div">
        <img src="assets/image/connect.webp">
        <div class="box">
            <h2>Авторизация</h2>
          <?
          if (isset($_POST['auth'])) {
            $check = authUser($_POST['email'], $_POST['password'], "profile");
            echo '<h3>Ошибка входа<br>' . $check . '</h3>';
          }
          ?>
            <form method="POST">
                <p>Введите email</p>
                <input type="email" name="email" placeholder="user@example.com" autocomplete="off" autofocus="off"
                       autosave="off" readonly onfocus="this.removeAttribute('readonly');">
                <p>Введите пароль</p>
                <input type="password" name="password" placeholder="••••••••" autocomplete="off" autofocus="off"
                       autosave="off" readonly onfocus="this.removeAttribute('readonly');">
                <button name="auth" class="auth_box_submit">Войти</button>
            </form>
            <a href="register">Создать новый аккаунт</a>
        </div>
        <p class="use">Нажимая кнопку «Войти» вы соглашаетесь с <span
                    style="color: #EE6C90;">Условиями использования</span> сервиса.</p>
    </div>
</center>
</body>
</html>
