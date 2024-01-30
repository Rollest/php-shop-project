<?php
include "connection.php";
?>

<head>
  <title>Заказы</title>
  <link rel="stylesheet" href="index.css" />
</head>

<?php include "navbar.php"; ?>


<div class="contents">
  <table border="1" align="center">
    <tr>
      <th></th>
      <th>№</th>
      <th>Количество товаров</th>
      <th>Сумма заказа</th>
      <th>Дата заказа</th>
      <th></th>
    </tr>
    <?php
    $sql_s = "SELECT order_id, SUM(amount) AS amount_sum, order_sum, order_date FROM orders WHERE user_id={$_SESSION["user_id"]} GROUP BY order_id, order_sum,order_date;";
    $result = $conn->query($sql_s);
    $count = 1;
    if ($result->num_rows > 0) {
      while ($row = $result->fetch_assoc()) {
        echo "<tr>
      <td>" . $count . "</td>
      <td>{$row["order_id"]}</td>
      <td>{$row["amount_sum"]}</td>
      <td>{$row["order_sum"]} ₽</td>
      <td>{$row["order_date"]}</td>
      <td><a href='order_info.php?action=info&order_id={$row["order_id"]}'>Подробнее</a></td>
      </tr>";
        $count++;
      }
    } else {
      echo "<tr><td colspan='6'>У вас нет заказов</td></tr>";
    }
    ?>
  </table>
</div>