<?php
include "connection.php";

if (isset($_POST['prod_amount']) && isset($_POST['prod_id'])) {

  $id = intval($_POST['prod_id']);

  if (isset($_SESSION['cart'][$id])) {

    $_SESSION['cart'][$id]['amount'] = $_POST['prod_amount'] > 0 ? $_POST['prod_amount'] : $_SESSION['cart'][$id]['amount'];
  } else {

    $sql_s = "SELECT * FROM products WHERE id={$id}";
    $query_s = mysqli_query($conn, $sql_s);
    if (mysqli_affected_rows($conn) != 0) {
      $row_s = mysqli_fetch_array($query_s);
      $_SESSION['cart'][$row_s['id']] = array(
        "image" => $row_s['image'],
        "name" => $row_s['name'],
        "amount" => $_POST['prod_amount'] > 0 ? $_POST['prod_amount'] : 1,
        "price" => (float)$row_s['price']
      );
    } else {

      $message = "This product id it's invalid!";
    }
  }
}
function getSortOrder($column)
{
  $sortOrder = isset($_GET['sort']) && $_GET['sort'] == $column && isset($_GET['order']) && $_GET['order'] == 'asc' ? 'desc' : 'asc';
  return $sortOrder;
}

$sql = "SELECT id, name, price, image, amount FROM products";
$orderColumn = isset($_GET['sort']) ? $_GET['sort'] : 'id';
$orderDirection = isset($_GET['order']) && $_GET['order'] == 'desc' ? 'DESC' : 'ASC';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
  $minPrice = isset($_POST['min_price']) ? $_POST['min_price'] : null;
  $maxPrice = isset($_POST['max_price']) ? $_POST['max_price'] : null;

  if ($minPrice != null && $maxPrice != null) {
    $sql .= " WHERE price BETWEEN $minPrice AND $maxPrice";
  } elseif ($minPrice != null) {
    $sql .= " WHERE price >= $minPrice";
  } elseif ($maxPrice != null) {
    $sql .= " WHERE price <= $maxPrice";
  }
}

$sql .= " ORDER BY $orderColumn $orderDirection";
$result = $conn->query($sql);
?>

<!DOCTYPE html>
<html>

<head>
  <title>Товары</title>
  <link rel="stylesheet" href="index.css" />
</head>

<?php include "navbar.php"; ?>

<body>

  <div class="main-body">
    <form class="filters" method="post" action="">
      <label style="color:black; margin-top:5px;">Минимальная цена:</label>
      <input style="margin-top:5px;" type="number" name="min_price">
      <label style="color:black; margin-top:5px;" style="color:black">Максимальная цена:</label>
      <input style="margin-top:5px;" type="number" name="max_price">
      <input class="filter-btn" type="submit" value="Фильтровать">
    </form>

    <table border="1" align="center">
      <tr>
        <th style="text-align:center">№</th>
        <th></th>
        <th style="text-align:center"><a class="a-first-td" href="?sort=name&order=<?php echo getSortOrder('name'); ?>">Название</a></th>
        <th style="text-align:center"><a class="a-first-td" href="?sort=price&order=<?php echo getSortOrder('price'); ?>">Цена</a></th>
      </tr>
      <?php
      if ($result->num_rows > 0) {
        $count = 1;
        while ($row = $result->fetch_assoc()) {
          echo "<tr>
        <td>" . $count . "</td>
        <td>" . "<form name='product_info' method='get' action='product_info.php'><input type='hidden' name='product_id' value='{$row["id"]}'>
        <input type='image' src='./images/{$row["image"]}' alt='prod_img' width='250' height='250' onclick='document.forms[\"product_info\"].submit();'/></form>" . "</td>
        <td style='word-break: break-all; table-layout: fixed; width: 350px;'>" . $row["name"] . "</td>
        <td class='price'>" . $row["price"] . " ₽<br>";

          if ($row["amount"] > 0) {
            echo "<form method='post' action=''>
              <input type='number' name='prod_amount' value='" . (isset($_SESSION['cart'][$row["id"]]) ? (int)$_SESSION['cart'][$row["id"]]['amount'] : 1) . "'>
              <input type='hidden' name='prod_id' value='" . $row["id"] . "'>
              <input class='tocart-btn' type='submit' value='В Корзину'>
          </form>";
          } else {
            echo "<h3>Нет в наличии</h3>";
          }

          echo "</td>
      </tr>";
          $count++;
        }
      } else {
        echo "<tr><td colspan='4'>0 товаров</td></tr>";
      }
      ?>
    </table>
    <?php
    if ($_SESSION["is_admin"] == true) {
      echo "<a href='http://shop-project/add.php'>Добавить</a>";
      echo "<a href='http://shop-project/change.php'>Изменить</a>";
      echo "<a href='http://shop-project/delete.php'>Удалить</a>";
      $sql = "SELECT product_id, name, COUNT(*) AS order_count
              FROM orders
              GROUP BY product_id, name
              ORDER BY order_count DESC
              LIMIT 1;";
      $result = $conn->query($sql);
      if ($result) {
        $row = $result->fetch_assoc();
        echo "<h4>Самый популярный товар: {$row['name']} <br>Его заказали {$row['order_count']} раз.</h4>";
      }
    }
    ?>
  </div>
  <?php
  ?>
</body>

</html>

<?php
$conn->close();
?>