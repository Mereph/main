<html lang="ru">
<?
session_start();
require_once "config.php";
require 'imports/user.php';
require 'imports/db.php';
$accountCurrent = false;
$account = null;
if($_SESSION['newEmail'] != null && $_SESSION['newPassword'] != null){
  $account = getUser($_SESSION['newEmail'], $_SESSION['newPassword'], "/");
  $accountCurrent = true;
}

?>
<head>
    <title>Mereph</title>
    <link rel="stylesheet" href="assets/style.css"/>
    <?php require_once "modules/metaTags.php"?>
</head>
<body>
  <script>
  function profile(){
    document.location.href = "https://mereph.ru/profile/";
  }
  </script>
  <div class="header">
      <img src="assets/image/dark_logo.webp" width="100" height="100">
      <?
      if($accountCurrent == true){
        ?>
        <a onclick="profile()" class="header_user"><?echo $account['firstname']." ".$account['surname']?>⠀<span><?=$account['balance']?>₽</span></a>
        <?
      }else{
        ?>
          <a href="auth" class="header_auth">Авторизация</a>
        <?
      }
      ?>
  </div>

  <div class="middle">
      <div class="middle_left">
            <h2><span style="color: EE6C90;">В</span>зломай сервер	мгновенно уже <span style="color: EE6C90;">сегодня</span></h2>
            <p>Мы даем возможность игрокам проектов майнкрафт, получить желаемый донат прямо сейчас без знание навыков программирование</p>
            <a href="https://oxy.cloud/d/uKTe">Установить</a>
      </div>
      <div class="middle_right">
        <img src="assets/image/1.webp">
      </div>
  </div>


<center>

  <div class="central_title">
    <h1>Магазин</h1>
    <p>Найди любой товар на свой вкус</p>
  </div>

    <div class="shop">

      <?
      $products = $db->query("SELECT * FROM `products`");
      foreach ($products as $key) {
        ?>
        <div class="shop_product">
          <div class="ecosystem_support_tab" style="margin-bottom: 2.2em;">
          <h3><?=$key['product_name']?></h3>
          <div class="align_sphere" style="width: 25px;">
            <div class="sphere"></div>
          </div>
        </div>
          <hr>
          <p><?=$key['product_desc']?></p>
          <form method="POST" action="payment_state">
            <input type="hidden" name="product_id" value="<?=$key['id']?>">
            <button>Купить за <?=$key['product_price']?>₽</button>
          </form>
        </div>
        <?
      }
      ?>

    </div>


<div class="central_title">
  <h1>Экосистема</h1>
  <p>Поддерживаемые партнёры нашей системы</p>
</div>

<div class="ecosystem">

  <div class="ecosystem_support">
    <div class="ecosystem_support_tab">
      <h3>TesloudHack</h3>
      <div class="align_sphere">
        <div class="sphere"></div>
        <div class="sphere" style="background: #C4C4C4;"></div>
      </div>
    </div>
    <img src="assets/image/svg/tesloud.svg">
    <a href="https://www.youtube.com/channel/UCd154PLYipdIYNTMVaBxVOg" target="_blank">Продолжить</a>
  </div>

  <div class="ecosystem_support">
      <div class="ecosystem_support_tab">
        <h3>KinalHack</h3>
        <div class="align_sphere">
          <div class="sphere"></div>
          <div class="sphere" style="background: #C4C4C4;"></div>
        </div>
      </div>
      <img src="assets/image/svg/kinal.svg">
      <a href="https://www.youtube.com/channel/UCsft9V97hT5NONxzMv39Slg" target="_blank">Продолжить</a>
  </div>

  <div class="ecosystem_support">
    <div class="ecosystem_support_tab">
      <h3>FlashBullet</h3>
      <div class="align_sphere">
        <div class="sphere"></div>
        <div class="sphere" style="background: #C4C4C4;"></div>
      </div>
    </div>
    <img src="assets/image/svg/flash.svg">
    <a href="https://www.youtube.com/channel/UCOo9S7lkBp0E_7dnXYCIGxQ" target="_blank">Продолжить</a>
  </div>

</div>
<p class="access">© Все права защищены Mereph.ru</p>

</center>

</body
</html>
