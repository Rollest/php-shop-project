<?php
include "connection.php";

if (isset($_GET["order_id"])) {
  $order_id = $_GET["order_id"];
}
?>

<head>
  <title>Заказ номер <?php echo "$order_id"; ?></title>
  <link rel="stylesheet" href="index.css" />
</head>

<?php include "navbar.php"; ?>

<div class="contents">
  <table border="1" align="center">
    <tr>
      <th></th>
      <th>№</th>
      <th>Количество товаров</th>
      <th>Количество</th>
      <th>Сумма</th>
      <th>Дата заказа</th>
      <th>Сумма Заказа</th>
    </tr>


    <?php
    if (isset($_GET['action']) && $_GET['action'] == "info") {
      $order_id = intval($_GET['order_id']);
    }
    ?>

    <?php
    $sql_s = "SELECT order_id, image, name, amount, product_price, order_sum, order_date 
            FROM orders 
            WHERE user_id={$_SESSION["user_id"]} AND order_id={$order_id}";
    $result = $conn->query($sql_s);
    if ($result !== false && $result->num_rows > 0) {
      $count = 1;
      while ($row = $result->fetch_assoc()) {
        echo "<tr>
      <td>" . $count . "</td>
      <td>" . "<img src='./images/{$row["image"]}' alt='prod_img' width='128' height='128'>" . "</td>
      <td>" . $row["name"] . "</td>
      <td>" . $row["amount"] . " x " . $row["product_price"] . "₽/шт</td>
      <td>" . $row["product_price"] * $row["amount"] . "₽</td>
      <td>" . $row["order_date"] . "</td>
      <td>" . ($count == 1 ? $row["order_sum"] . " ₽" : "") . "</td>
      </tr>";
        $count++;
      }
    } else {
      echo "<tr><td colspan='6'>No records found</td></tr>";
    }
    ?>
  </table>
</div>