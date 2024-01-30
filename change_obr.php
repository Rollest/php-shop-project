<?php
session_start();
include "connection.php";

$id = $_REQUEST['change_id'];
$name = $_REQUEST['product_name'];
$quantity = $_REQUEST['product_quantity'];
$prod_price = $_REQUEST['product_price'];
$description = $_REQUEST['description'];
$image = $_REQUEST['image'];

$q = mysqli_query($conn, "UPDATE products SET name='$name', price='$prod_price', amount='$quantity', description='$description', image='$image' WHERE id='$id'");

header('Location: http://shop-project/change.php');
die();
