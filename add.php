<?php
include "connection.php";

$res = $conn->query("SELECT id, is_admin FROM users WHERE id = {$_SESSION['user_id']}")->fetch_assoc();
if ($res["is_admin"]) {
  if (isset($_POST['product_name']) && isset($_POST['product_amount']) && isset($_POST['product_price']) && isset($_POST['product_description']) && isset($_POST['product_image'])) {
    $amount = (int)$_POST['product_amount'];
    $price = (float)$_POST['product_price'];
    $description = $_POST['product_description'];
    $image = $_POST['product_image'];
    $q = "INSERT INTO products(name,price,description,amount,image) VALUES('{$_POST['product_name']}',{$price},'{$description}',{$amount},'{$image}');";
    $res = $conn->query($q);
    if ($res) {
      echo '<script>';
      echo 'alert("Товар успешно добавлен.");';
      echo '</script>';
    } else {
      echo '<script>';
      echo 'alert("Произошла ошибка при добавлении заказа.");';
      echo '</script>';
    }
  }
} else {
  header('Location: http://shop-project/index.php');
}

?>

<head>
  <title>Добаление товара</title>
</head>

<?php include "navbar.php"; ?>


<form style="margin-top: 90px;" method="post" action="">
  <table>
    <tr>
      <td><label>Название:</label></td>
      <td><input type="text" name="product_name"></td>
    </tr>
    <tr>
      <td><label>Количество:</label></td>
      <td><input type="number" name="product_amount"></td>
    </tr>
    <tr>
      <td><label>Цена:</label></td>
      <td><input type="float" name="product_price"></td>
    </tr>
    <tr>
      <td><label>Описание:</label></td>
      <td><input type="text" name="product_description"></td>
    </tr>
    <tr>
      <td><label>Изображение:</label></td>
      <td><input type="text" name="product_image"></td>
    </tr>
    <tr>
      <?php /* $user_id = $_SESSION["user_id"];
      echo '<td><input type="hidden" name="user" value=$user_id ></td>'; */ ?>
    </tr>
    <tr>
      <td colspan="2"><input type="submit" value="Создать"></td>
    </tr>
  </table>
</form>



<style>
  .dropbtn {
    background-color: rgb(106, 106, 106);
    color: rgb(0, 0, 0);
    padding: 16px;
    font-size: 16px;
    border: none;
    min-width: 160px;
  }

  .dropdown {
    position: relative;
    float: right;
    min-width: 160px;
    display: inline-block;
  }

  .dropdown-content {
    display: none;
    position: absolute;
    background-color: #f1f1f1;
    min-width: 160px;
    box-shadow: 0px 8px 16px 0px rgba(0, 0, 0, 0.2);
    z-index: 1;
  }

  .dropdown-content-login {
    display: contents;
    position: absolute;
    background-color: #f1f1f1;
    min-width: 160px;
    box-shadow: 0px 8px 16px 0px rgba(0, 0, 0, 0.2);
    z-index: 1;
  }

  .dropdown-content a {
    color: black;
    padding: 12px 16px;
    text-decoration: none;
    display: block;
  }

  .dropdown-content a:hover {
    background-color: #ddd;
  }

  .dropdown:hover .dropdown-content {
    display: block;
  }

  .dropdown:hover .dropbtn {
    background-color: rgb(169, 169, 169);
  }

  .navbar {
    display: grid;
    grid-template-columns: 1fr 160px;
    justify-content: space-between;
  }

  header {
    margin: 0;
    font-family: Arial;
    background-color: #123;
    color: white;
    min-height: 5vh;
    padding: 10px;
    position: fixed;
    min-width: 100%;
    z-index: 2;
    top: 0;
  }

  form {
    width: 50%;
    /* Ширина формы */
    margin: 0 auto;
    /* Выравнивание по центру */
  }

  table {
    width: 100%;
    /* Ширина таблицы внутри формы */
    border-collapse: collapse;
    /* Сворачивание границ таблицы */
  }

  td {
    padding: 10px;
    /* Поля вокруг содержимого ячейки */
  }

  label {
    display: block;
    /* Отображение меток на новой строке */
    margin-bottom: 5px;
    /* Отступ между меткой и полем ввода */
  }

  input {
    width: 100%;
    /* Ширина полей ввода внутри ячейки */
    box-sizing: border-box;
    /* Учет границ и отступов внутри поля ввода */
  }

  input[type="submit"] {
    cursor: pointer;
    /* Указатель при наведении на кнопку отправки */
    background-color: #4CAF50;
    /* Цвет фона кнопки */
    color: white;
    /* Цвет текста на кнопке */
    padding: 10px;
    /* Поля вокруг текста кнопки */
    border: none;
    /* Удаление границы у кнопки */
  }
</style>