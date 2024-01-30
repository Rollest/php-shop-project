<?php
include "connection.php";

if (!isset($_GET['product_id'])) {
  header("Location: index.php");
  die();
}

$product_id = intval($_GET['product_id']);
$sql = "SELECT * FROM products WHERE id = $product_id";
$result = $conn->query($sql);

if ($result->num_rows == 0) {
  header("Location: index.php");
  die();
}

$product = $result->fetch_assoc();



if (isset($_POST['prod_amount']) && isset($_POST['prod_id'])) {

  $id = intval($_POST['prod_id']);

  if (isset($_SESSION['cart'][$id])) {

    $_SESSION['cart'][$id]['amount'] = $_POST['prod_amount'];
  } else {

    $sql_s = "SELECT * FROM products WHERE id={$id}";
    $query_s = mysqli_query($conn, $sql_s);
    if (mysqli_affected_rows($conn) != 0) {
      $row_s = mysqli_fetch_array($query_s);

      $_SESSION['cart'][$row_s['id']] = array(
        "image" => $row_s['image'],
        "name" => $row_s['name'],
        "amount" => $_POST['prod_amount'],
        "price" => (float)$row_s['price']
      );
    } else {

      $message = "This product id it's invalid!";
    }
  }
}
?>

<!DOCTYPE html>
<html>

<head>
  <title><?php echo $product['name']; ?></title>
  <link rel="stylesheet" href="index.css" /> <!-- You can create a separate CSS file for product styling -->
</head>

<body>

  <?php include "navbar.php"; ?>

  <div class="product-container" style="padding-top:10vh;">
    <div class="product-image">
      <img src="./images/<?php echo $product['image']; ?>" alt="Product Image" width='400' height='400'>
    </div>
    <div class="product-details">
      <h1 style='word-break: break-all; table-layout: fixed; width: 100%;'><?php echo $product['name']; ?></h1>
      <p><?php echo $product['description']; ?></p>
      <p>Цена: <?php echo $product['price']; ?> ₽</p>
      <?php if ($product['amount'] > 0) : ?>
        <form method='post' action=''>
          <input type='number' name='prod_amount' value=<?php echo isset($_SESSION['cart'][$product_id]) ? (int)$_SESSION['cart'][$product_id]['amount'] : (int)1; ?>>
          <input type='hidden' name='prod_id' value=<?php echo $product_id; ?>>
          <input class='tocart-btn' type='submit' value='В Корзину'>
        </form>
      <?php else : ?>
        <p>Нет в наличии</p>
      <?php endif; ?>
    </div>
  </div>

  <footer>
    <!-- Include your footer content here -->
  </footer>

</body>

</html>

<?php
$conn->close();
?>