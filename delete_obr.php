<?php
include "connection.php";

$ids = $_REQUEST['id_del'];
$prod_id = $_REQUEST['prod_id'];
$prod_amount = $_REQUEST['prod_amount'];
$ids_admin = $_REQUEST['id_del_admin'];
if (isset($prod_id) && isset($prod_amount)) {
  $counter = 0;
  foreach ($prod_id as $id) {
    $_SESSION['cart']["$id"]['amount'] = (int)$prod_amount["$counter"];
    $counter++;
  }
}
if (isset($ids)) {
  for ($i = 0; $i < count($ids); $i++) {
    $id = $ids[$i];

    unset($_SESSION['cart']["$id"]);
  }
}
var_dump($ids_admin);
if (isset($ids_admin) && $_SESSION['is_admin'] == true) {
  foreach ($ids_admin as $id) {
    $q = "DELETE FROM products WHERE id={$id};";
    $res = $conn->query($q);
    if ($res) {
      echo '<script>';
      echo 'alert("Записи успешно удалены");';
      echo 'setTimeout(function() { window.location.href = "http://shop-project/delete.php"; }, 0);';
      echo '</script>';
    } else {
      echo '<script>';
      echo 'alert("Ошибка при удалении записи!");';
      echo 'setTimeout(function() { window.location.href = "http://shop-project/delete.php"; }, 0);';
      echo '</script>';
    }
  }
  header('Location: http://shop-project/delete.php');
  die();
}
header('Location: http://shop-project/cart.php');
die();
