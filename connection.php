<?php
session_start();
$conn = new mysqli("localhost", "root", "", "ShopDB");
mysqli_set_charset($conn, "utf8");
if ($conn->connect_error) {
  die("Соединение не установлено");
}
