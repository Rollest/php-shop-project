<?php

include "connection.php";


if (isset($_POST["login"])) {
  if (!$conn->query("SELECT login FROM users WHERE login = '{$_POST['login']}'")->fetch_assoc()["login"]) {
    $conn->query("INSERT INTO users(login, password, active, is_admin) VALUES('{$_POST['login']}','{$_POST['password']}', true, false)");
    echo '<script>';
    echo 'alert("Вы успешно зарегистрировались!");';
    echo 'setTimeout(function() { window.location.href = "http://shop-project/login.php"; }, 0);';
    echo '</script>';
  } else {
    echo '<script>';
    echo 'alert("Пользователь с таким именем уже существует :(");';
    echo 'setTimeout(function() { window.location.href = "http://shop-project/registration.php"; }, 0);';
    echo '</script>';
  }
} else {
  echo '<script>';
  echo 'alert("Что-то пошло не так :(");';
  echo 'setTimeout(function() { window.location.href = "http://shop-project/registration.php"; }, 0);';
  echo '</script>';
}
