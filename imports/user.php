<?

require 'db.php';
session_start();
$reply = "";
$array = null;
$bool = false;


if(isset($_GET['data'])){
  $data = explode("//", urldecode($_GET['data']));
  switch ($data[0]) {
    case 'auth':
      $reply = authUser($data[1], $data[2], "");
      echo $reply;
      break;
    case 'getUser':
      $reply = getUser($data[1], $data[2], "");
      echo $reply['firstname']."//".$reply['surname']."//".$reply['status']."//".$reply['balance']."//".$reply['premium'];
      break;
    default:
      echo "404";
      break;
  }
}


function validUser(String $email, String $password) : bool{
  global $db;
  $select = $db->query("SELECT * FROM `users` WHERE `email` = '$email'");
  $select = $select->fetch_assoc();
  return $select['password'] == $password;
}

function getUser(String $email, String $password, String $toUrl) : Array{
  global $db, $array;
  $valid = validUser($email, $password);
  if($valid == true){
    $select = $db->query("SELECT * FROM `users` WHERE `email` = '$email'");
    $array = $select->fetch_assoc();
  }else{
    header('Location: '.$toUrl);
  }
  return $array;
}

function getProduct(int $id) : Array{
  global $db;
  $select = $db->query("SELECT * FROM `products` WHERE `id` = '$id'");
  return $select->fetch_assoc();
}

function getCountProducts() : int{
  global $db;
  return mysqli_num_rows($db->query("SELECT * FROM `products`"));
}

function newUser(String $firstname, String $surname, String $email, String $password) : String{
  global $db, $reply;

  $review_pass = $password;
  $firstname = $db->escape_string(trim($firstname));
  $surname = $db->escape_string(trim($surname));
  $email = $db->escape_string(trim($email));
  $password = $db->escape_string(trim(md5(md5($password))));

  if($firstname != "" or $surname != "" or $email != "" or $password != ""){
    $select = $db->query("SELECT * FROM `users` WHERE `email` = '$email'");
    $select = $select->fetch_assoc();
    if($select['email'] == $email){
      $reply = "Пользователь существует";
    }else{
      $db->query("INSERT INTO `users`(`firstname`, `surname`, `email`, `password`, `status`) VALUES ('$firstname','$surname','$email','$password','Not Verified')");
      createSession("review_password", $review_pass);
      createSession("newEmail", $email);
      createSession("newPassword", $password);
      createSession("backAuth", false);
      createSession("backReview", true);
      header('Location: review');
    }
  }else{
    $reply = "Вы забыли одно поле";
  }


  return $reply;
}

function authUser(String $email, String $password, String $toUrl) : String{
  global $db, $reply;
  $email = $db->escape_string(trim($email));
  $password = $db->escape_string(trim(md5(md5($password))));

  $valid = validUser($email, $password);
  if($valid == true){
    createSession("newEmail", $email);
    createSession("newPassword", $password);
    createSession("backAuth", true);
    createSession("backReview", false);
    header('Location: https://mereph.ru/'.$toUrl);
  }else{
    $reply = "Неправильный пароль или Email";
  }
  return $reply;
}

function createSession(String $key, String $value){
  $_SESSION[''.$key.''] = $value;
}

function privateTransfer(String $byEmail, String $toEmail, int $balance) : bool{
  global $db, $bool;
  $byUser = privateGetUser($byEmail);
  if($byUser['balance'] >= $balance){
    $fullBalance = $byUser['balance'] - $balance;
    $fullBalanceHistory = $byUser['balance_history']." "."transfer:".$balance;
    $db->query("UPDATE `users` SET `balance`='$fullBalance', `balance_history`='$fullBalanceHistory' WHERE `email` = '$byEmail'");

    $toUser = privateGetUser($toEmail);
    $fullBalance = $toUser['balance'] + $balance;
    $fullBalanceHistory = $toUser['balance_history']." "."addTransfer:".$balance;
    $db->query("UPDATE `users` SET `balance`='$fullBalance', `balance_history`='$fullBalanceHistory' WHERE `email` = '$toEmail'");
    $bool = true;
  }

  return $bool;
}

function addMoney(String $email, int $cash) : void{
  global $db;
  $byUser = privateGetUser($email);
  $balance = $byUser['balance'] +$cash;
  $history = $byUser['balance_history']." add:".$cash;
  $db->query("UPDATE `users` SET `balance`='$balance', `balance_history`='$history' WHERE `email` = '$email'");
}

function privateGetUser(String $email) : Array{
  global $db;
  $select = $db->query("SELECT * FROM `users` WHERE `email` = '$email'");
  return $select->fetch_assoc();
}

function existsUser(String $email) : bool{
  global $db, $bool;
  $select = $db->query("SELECT * FROM `users` WHERE `email` = '$email'");
  $select = $select->fetch_assoc();
  if($select['email'] == $email){
    $bool = true;
  }
  return $bool;
}

function changeData(String $object, String $email, String $password, String $newValue){
  global $db;
  $valid = validUser($email, $password);
  if($valid == true){
    if($object == "email"){
        $newEmail = $db->escape_string(trim($newValue));
        if(existsUser($newEmail) == false){
            $db->query("UPDATE `users` SET `email`='$newEmail' WHERE `email` = '$email'");
            $_SESSION['newEmail'] = $newEmail;
            return;
        }
    }
    if($object == "password"){
        $newValue = $db->escape_string(trim(md5(md5($newValue))));
        $db->query("UPDATE `users` SET `password`='$newValue' WHERE `email` = '$email'");
        $_SESSION['newPassword'] = $newValue;
        return;
    }
  }
}

?>
