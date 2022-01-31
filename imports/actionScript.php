<?
require 'user.php';
session_start();

const paymentSystem = "mpay";

if(isset($_POST['change_data'])){
  switch ($_POST['type']) {
    case 'pay':
      $data = http_build_query([
        "p" => paymentSystem, // payment system
        "c" => "web:".$_SESSION["newEmail"], // comment
        "a" => (int) $_POST["data"], // amount
      ]);
      $url = "https://mereph.ru/payment/create.php?$data";
      header("Location: $url");
      exit(302);
      break;
    case 'transfer':
      $bool = privateTransfer($_SESSION['newEmail'], $_POST['client'], $_POST['summa']);
      if($bool == true){
        header('Location: ../profile');
      }
      break;
    case 'changer':
      if(trim($_POST['data2']) == ""){
          changeData("email", $_SESSION['newEmail'], $_SESSION['newPassword'], $_POST['data1']);
          header('Location: ../profile');
          break;
      }
      if(trim($_POST['data1']) == ""){
           changeData("password", $_SESSION['newEmail'], $_SESSION['newPassword'], $_POST['data2']);
           header('Location: ../profile');
           break;
      }
    default:
      header('Location: ../profile');
      break;
  }
}

?>
