<header>
  <div class="navbar">
    <form style="margin: 0 0;" name='index' method='get' action='index.php'>
      <input type='image' src='.\site_images\logo.png' alt='logo' style="max-width:50px; max-height:50px;" onclick='document.forms[" index"].submit();' />
    </form>
    <?php if ($_SESSION["user_id"]) {
      $user_name = $conn->query("SELECT login FROM users WHERE id = {$_SESSION["user_id"]}")->fetch_assoc()["login"];
      $products_in_cart = 0;
      $sum_in_cart = 0;
      if ($_SESSION['cart']) {
        foreach ($_SESSION['cart'] as $k => $v) {
          $products_in_cart += $v['amount'];
          $sum_in_cart +=  $v['price'] * $v['amount'];
        }
      }
      $sum_in_cart > 0 ? $sum_in_cart = "<br>" . $sum_in_cart . " ₽" : $sum_in_cart = "";
      echo "
    <div class='dropdown'>
      <button class='dropbtn'>{$user_name}</button>
      <div class='dropdown-content'>
        <a href='cart.php'>Корзина " . ($products_in_cart > 0 ? $products_in_cart . $sum_in_cart : "") . "</a>
        <a href='orders.php'>Заказы</a>
        <a href='logout.php'>Выйти</a>
      </div>
    </div>";
    } else {
      echo "
    <div class='dropdown'>
      <button class='dropbtn'>Войдите в аккаунт</button>
      <div class='dropdown-content'>
        <a href='login.php'>Войти</a>
        <a href='registration.php'>Регистрация</a>
      </div>
    </div>";
    }
    ?>
  </div>
</header>