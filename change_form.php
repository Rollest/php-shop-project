<?php
session_start();
include "connection.php";
$change_id = $_POST["change_id"];
$result = $conn->query("SELECT * FROM products WHERE id='$change_id'");
$prod = $result->fetch_assoc()
?>

<head>
  <title>Изменение товаров</title>
</head>

<?php include "navbar.php"; ?>
<form method="post" action="change_obr.php">
  <table style="margin-top: 90px;">
    <tr>
      <td><label>Название:</label></td>
      <td><input required type="text" name="product_name" value=<?php echo $prod["name"]; ?>></td>
    </tr>
    <tr>
      <td><label>Количество:</label></td>
      <td><input required type="number" name="product_quantity" value=<?php echo $prod["amount"]; ?>></td>
    </tr>
    <tr>
      <td><label>Цена:</label></td>
      <td>
        <input required type="number" name="product_price" value=<?php echo $prod["price"]; ?>>
      </td>
    </tr>
    <tr>
      <td><label>Описание:</label></td>
      <td>
        <input required type="text" name="description" value=<?php echo $prod["description"]; ?>>
      </td>
    </tr>
    <tr>
    <tr>
      <td><label>Изображение:</label></td>
      <td>
        <input required type="text" name="image" value=<?php echo $prod["image"]; ?>>
      </td>
    </tr>
    <?php $user_id = $_SESSION["user_id"];
    echo '<td><input type="hidden" name="user" value=$user_id ></td>'; ?>
    </tr>
    <tr>
      <?php
      echo "<td><input type='hidden' name='change_id' value='$change_id' ></td>"; ?>
    </tr>
    <tr>
      <td colspan="2"><input type="submit" value="Изменить"></td>
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