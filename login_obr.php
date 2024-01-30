<?php
session_destroy();
include "connection.php";


if (isset($_POST["login"])) {
  if (
    $_POST['password'] ==  $conn->query("SELECT password FROM users WHERE login = '{$_POST['login']}'")->fetch_assoc()["password"] &&
    $conn->query("SELECT active FROM users WHERE login = '{$_POST['login']}'")->fetch_assoc()["active"] == true
  ) {
    $res = $conn->query("SELECT id, is_admin FROM users WHERE login = '{$_POST['login']}'")->fetch_assoc();
    $_SESSION["user_id"] = $res["id"];
    $_SESSION["is_admin"] = $res["is_admin"];
    header('Location: http://shop-project/index.php');
    die();
  } else {
    echo '<script>';
    echo 'alert("Пользователя с таким логином и паролем не существует. Проверьте правильность введенных данных и попробуйте снова.");';
    echo 'setTimeout(function() { window.location.href = "http://shop-project/login.php"; }, 0);';
    echo '</script>';
  }
} else {
  echo '<script>';
  echo 'alert("Что-то пошло не так :(");';
  echo 'setTimeout(function() { window.location.href = "http://shop-project/login.php"; }, 0);';
  echo '</script>';
}
