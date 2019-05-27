<?php 
session_start();
require_once "db/db.php";
$user_code = $_GET['user_code'];
$code = $_GET['code'];
ini_set('date.timezone', 'Asia/Novosibirsk');
$date = date("H:i:s d-m-Y");
$query ="UPDATE `data` SET `give`= '$user_code' WHERE `code`='$code'";
$result = mysqli_query($link, $query) or die("Ошибка " . mysqli_error($link));
$query ="INSERT `history` (`user_code`, `data_code`, `date`, `mode`) VALUES ('$user_code','$code','$date','Выдан')";
$result = mysqli_query($link, $query) or die("Ошибка " . mysqli_error($link));
echo '<script language="JavaScript"> 
      window.location.href = "index.php"
      </script>';
?>