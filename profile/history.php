<html lang="ru">
<?
session_start();
require_once "../config.php";
require '../imports/user.php';
$user = null;
if($_SESSION['newEmail'] != null && $_SESSION['newPassword'] != null){
  $valid = validUser($_SESSION['newEmail'], $_SESSION['newPassword']);
  if($valid == false){
     header('Location: auth');
  }else{
    $user = getUser($_SESSION['newEmail'], $_SESSION['newPassword'], "history");
  }
}else{
  header('Location: /');
}
?>
<head>
    <title>Mereph Connect</title>
    <link rel="stylesheet" href="../assets/user.css"/>
    <link rel="stylesheet" href="../assets/popout.css"/>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/2.2.0/jquery.min.js"></script>
    <script src="https://unpkg.com/imagesloaded@4/imagesloaded.pkgd.min.js"></script>
    <?php require_once "../modules/metaTags.php"?>
</head>
<body>
  <div class="header">
    <img src="../assets/image/connect.webp" height="60" width="210" class="logo">
    <div class="header_bar">
      <a href="/profile/" >Профиль</a>
      <a style="color: #F07B9C;">Покупки</a>
      <a href="exit">Выйти</a>
    </div>
  </div>

  <div class="middle">
      <div class="middle_left">
        <div class="middle_left_user">
          <h3><?=$user['firstname']." ".$user['surname']?></h3>
          <p><?=$user['email']?></p>
        </div>

        <div class="middle_left_user">
          <h3>На счету⠀<span style="color: #F07B9C;"><?=$user['balance']?>₽</span></h3>
          <p>
            <?
            if($user['status'] == "Verified2"){
              echo 'Verified-2';
            }
            if($user['status'] == "Verified3"){
              echo 'Verified-3';
            }
            else{
              echo $user['status'];
            }
            ?>
          </p>
        </div>

        <div class="middle_left_item">

          <div id="open_pay">
            <img src="../assets/image/svg/add.svg">
            <p>Пополнить счет</p>
          </div>

          <div id="open_client">
            <img src="../assets/image/svg/trasnfer.svg">
            <p>Перевод клиенту</p>
          </div>

          <div id="open_settings">
            <img src="../assets/image/svg/settings.svg">
            <p>Настройка аккаунта</p>
          </div>

        </div>
      </div>
      <div class="middle_right">
          <div class="middle_right_pane">
              <h2>История покупок</h2>
              <hr style="margin-bottom: 1.2em;">

              <?
              $array = explode(";", substr($user['history'], 1));
              if($user['history'] == ""){
                echo "<p>История не обнаружено</p>";
              }
              foreach ($array as $key) {
                $product = explode(":", $key);
                if($product[0] == "text"){
                  ?>
                  <div>
                      <p><?=$product[1]?></p>
                      <h3>приобретен</h3>
                  </div>
                  <?
                }
                if($product[0] == "download"){
                  $link = "storage?link=".md5($_SESSION['newEmail'].$_SESSION['newPassword'].$product[2]);
                  ?>
                  <div>
                      <p><?=$product[1]?></p>

                      <h3><a style="color: #F07B9C; cursor: pointer;" href="<?=$link?>">установить</a></h3>
                  </div>
                  <?
                }

              }

              ?>

          </div>
      </div>
  </div>

  <div class="popout-bg" style="display:none" id="pay">
      <div class="popout">
          <img src="../assets/image/svg/close.svg" width="24" height="24" id="close_pay" class="popout-close">
              <h3><span style="color: #F07B9C;">ME</span>REPH <span style="color: #F07B9C;">Pay</span></h3>
              <p>Введите сумму для пополнение баланса</p>
              <form method="POST" action="../imports/actionScript">
                <input type="hidden" name="type" value="pay">
                  <input type="number" name="data" placeholder="100" class="input-text" autocomplete="off">
                  <input type="submit" name="change_data" value="Пополнить" class="input-submit">
              </form>
      </div>
  </div>

  <div class="popout-bg" style="display:none" id="client">
      <div class="popout">
          <img src="../assets/image/svg/close.svg" width="24" height="24" id="close_client" class="popout-close">
              <h3><span style="color: #F07B9C;">ME</span>REPH <span style="color: #F07B9C;">Pay</span></h3>
              <p>Введите email клиента и сумму отправки</p>
              <form method="POST" action="../imports/actionScript">
                <input type="hidden" name="type" value="transfer">
                  <input type="text" name="client" placeholder="user@example.com" class="input-text" autocomplete="off" autofocus="off" autosave="off" readonly onfocus="this.removeAttribute('readonly');"autocomplete="off">
                  <input type="number" name="summa" placeholder="100" class="input-text" autocomplete="off">
                  <input type="submit" name="change_data" value="Перевести" class="input-submit">
              </form>
      </div>
  </div>


  <div class="popout-bg" style="display:none" id="settings">
      <div class="popout">
          <img src="../assets/image/svg/close.svg" width="24" height="24" id="close_settings" class="popout-close">
              <h3><span style="color: #F07B9C;">ME</span>REPH <span style="color: #F07B9C;">Connect</span></h3>
              <p>Выберите тип изменение данных</p>
              <form method="POST" action="../imports/actionScript">

                    <a id="lock_email" class="select">Email</a>
                    <a id="lock_password" class="select">Пароль</a>

                  <input type="hidden" name="type" value="changer">
                  <input type="email" name="data1" placeholder="Новый Email" class="input-text" autocomplete="off" autofocus="off" autosave="off" readonly onfocus="this.removeAttribute('readonly');" id="newEmail">
                  <input type="password" name="data2" placeholder="Новый пароль" class="input-text" autocomplete="off" autofocus="off" autosave="off" readonly onfocus="this.removeAttribute('readonly');" id="newPassword">
                  <input type="submit" name="change_data" value="Изменить" class="input-submit">
              </form>
      </div>
  </div>

  <script type="text/javascript">
  $('#newPassword').hide();
  $('#open_pay').click(e => {
      $('#pay').show();
  });
  $('#close_pay').click(e => {
      $('#pay').hide();
  });

  $('#lock_email').click(e => {
      $('#newPassword').hide();
      $('#newEmail').show();
  });

  $('#lock_password').click(e => {
      $('#newEmail').hide();
      $('#newPassword').show();
  });

      $('#open_client').click(e => {
          $('#client').show();
      });
      $('#close_client').click(e => {
          $('#client').hide();
      });

      $('#open_settings').click(e => {
          $('#settings').show();
      });
      $('#close_settings').click(e => {
          $('#settings').hide();
      });
  </script>


</body>
</html>
