<html lang="ru">
<?
require_once "config.php";
require 'imports/user.php';
session_start();
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
    <div class="center_div" style="margin: -400px 0 0 -190px;">
        <img src="assets/image/connect.webp">
        <div class="box">
            <h2>Регистрация</h2>
          <?
          if (isset($_POST['auth'])) {
            $reply = newUser($_POST['firstname'], $_POST['surname'], $_POST['email'], $_POST['password']);
            echo '<h3>Ошибка входа<br>' . $reply . '</h3>';
          }
          ?>
            <form method="POST">
                <p>Введите имя</p>
                <input type="text" maxlength="22" name="firstname" placeholder="Михаил" autocomplete="off"
                       autofocus="off" autosave="off" readonly onfocus="this.removeAttribute('readonly');">
                <p>Введите фамилию</p>
                <input type="text" maxlength="22" name="surname" placeholder="Смирнов" autocomplete="off"
                       autofocus="off" autosave="off" readonly onfocus="this.removeAttribute('readonly');">
                <p>Введите email</p>
                <input type="email" name="email" placeholder="user@example.com" autocomplete="off" autofocus="off"
                       autosave="off" readonly onfocus="this.removeAttribute('readonly');">
                <p>Новый пароль</p>
                <input type="password" name="password" placeholder="••••••••" autocomplete="off" autofocus="off"
                       autosave="off" readonly onfocus="this.removeAttribute('readonly');">
                <button name="auth" class="auth_box_submit">Продолжить</button>
            </form>
            <a href="auth">Уже есть аккаунт</a>
        </div>
        <p class="use">Нажимая кнопку «Продолжить» вы соглашаетесь с <span style="color: #EE6C90;">Условиями использования</span>
            сервиса.</p>
    </div>
</center>
</body>
</html>
