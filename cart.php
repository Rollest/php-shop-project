<?php
include "connection.php";
?>

<?php




if ($_POST["order"]) {
  $all_prices_are_right = true;
  $all_amounts_are_right = true;
  foreach ($_SESSION['cart'] as $k => $v) {
    $sql_s = "SELECT price,amount FROM products WHERE id={$k}";
    $result = $conn->query($sql_s);

    while ($row = $result->fetch_assoc()) {
      if ($row['price'] != $v["price"]) {
        $all_prices_are_right = false;
        $_SESSION['cart'][$k]["price"] = $row['price'];
      }
      if ((int)$v['amount'] > (int)$row["amount"]) {
        $all_amounts_are_right = false;
        $_SESSION['cart'][$k]["amount"] = $row['amount'];
      }
    }
  }
  if ($all_prices_are_right && $all_amounts_are_right) {
    $counter = false;
    $order_id = crc32(uniqid());
    $sql_s = "INSERT INTO orders(order_id, user_id,product_id,name,amount,product_price,order_sum,image,order_date) VALUES";
    foreach ($_SESSION['cart'] as $k => $v) {
      $order_sum +=  $v['price'] * $v['amount'];
    }
    foreach ($_SESSION['cart'] as $k => $v) {
      $sql_s .= " ({$order_id},{$_SESSION['user_id']}, $k,'{$v['name']}', {$v['amount']},{$v['price']}, {$order_sum},'{$v['image']}', NOW()),";
    }
    if (substr($sql_s, -1) === ',') {
      $sql_s = rtrim($sql_s, ',');
      $sql_s .= ";";
    }
    $result = $conn->query($sql_s);
    if (!$result) {
      echo '<script language="javascript">';
      echo 'alert("Произошла ошибка при оформлении заказа.")';
      echo '</script>';
    } else {
      foreach ($_SESSION['cart'] as $k => $v) {
        unset($_SESSION['cart']["$k"]);
        $sql_s = "SELECT amount FROM products WHERE id={$k}";
        $result = $conn->query($sql_s);
        $set_val = $result->fetch_assoc()["amount"] - $v["amount"];
        $sql_s = "UPDATE products SET amount={$set_val} WHERE id={$k}";
        $result = $conn->query($sql_s);
      }
    }
  } else {
    echo '<script language="javascript">';
    echo 'alert("Произошла ошибка. Мы обновили данные корзины, попробуйте снова.")';
    echo '</script>';
  }
}
?>


<head>
  <title>Корзина</title>
  <link rel="stylesheet" href="index.css" />
</head>

<?php include "navbar.php"; ?>

<div class="cart-body">
  <form class="contents" method="post" action="delete_obr.php" style="text-align: right;">
    <table border="1" align="center">
      <tr>
        <th></th>
        <th>№</th>
        <th></th>
        <th>Название</th>
        <th>Количество</th>
        <th>Сумма</th>
      </tr>
      <?php
      if ($_SESSION['cart'] && count(array_keys($_SESSION['cart'])) > 0) {
        $count = 1;
        $order_sum = 0;
        foreach ($_SESSION['cart'] as $k => $v) {
          $order_sum +=  $v['price'] * $v['amount'];
        }
        foreach ($_SESSION['cart'] as $k => $v) {
          echo "<tr>
        <td><input type='checkbox' name='id_del[]' value='{$k}'></td>
        <td>" . $count . "</td>
        <td>" . "<img src='./images/{$v["image"]}' alt='prod_img' width='128' height='128'>" . "</td>
        <td style='word-break: break-all; table-layout: fixed; width: 500px;'>" . $v["name"] . "</td>
        <td>" .
            "
        <input type='number' name='prod_amount[]' value={$v["amount"]}>
        <input type='hidden' name='prod_id[]' value='$k'>
        <input type='submit' value='✓'>
        " .
            "<br>" . $v["amount"] . " x " . $v["price"] . "₽/шт</td>
        <td>" . $v["price"] * $v["amount"] . "₽</td>
        </tr>";
          $count++;
        }
        echo "<tr>
        <td><input class='tocart-btn' type='submit' value='Удалить'></td>
        <td></td>
        <td></td>
        <td></td>
        <td></td>
        <td>Сумма заказа: {$order_sum} ₽</td>
        </tr>";
      } else {
        echo "<tr><td colspan='6'>Ваша корзина пуста</td></tr>";
      }
      ?>
    </table>

  </form>

  <form method="post" action="" style="text-align: right; margin:30px;">
    <input type='hidden' name='order' value='yes'>
    <input class='tocart-btn' type="submit" value="Заказать">
  </form>
</div>