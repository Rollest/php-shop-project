<?php
include "connection.php";


$res = $conn->query("SELECT id, is_admin FROM users WHERE id = {$_SESSION['user_id']}")->fetch_assoc();
if (!$res["is_admin"]) {
  header('Location: http://shop-project/index.php');
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
  <title>Изменение товаров</title>
  <link rel="stylesheet" href="index.css" />
</head>


<?php include "navbar.php"; ?>

<body>

  <table style="margin-top: 90px;" border="1" align="center">
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

        echo "<form method='post' action='change_form.php'><input type='hidden' name='change_id' value={$row['id']}><input type='submit' value='Изменить'></form>";
        echo "</tr>";
        $count++;
      }
    } else {
      echo "<tr><td colspan='4'>0 товаров</td></tr>";
    }
    ?>
  </table>

  <a href="index.php">На главную</a>
</body>

</html>


<?php
$conn->close();
?>