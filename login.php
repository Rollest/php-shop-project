<head>
  <title>Вход</title>
  <link rel="stylesheet" href="login-registration.css" />
</head>

<form method="post" action="login_obr.php">
  <table>
    <tr>
      <td><label>Логин:</label></td>
      <td><input type="text" name="login"></td>
    </tr>
    <tr>
      <td><label>Пароль:</label></td>
      <td><input type="password" name="password"></td>
    </tr>
    <tr>
      <td colspan="2"><input type="submit" value="Войти">
        <br><a href="registration.php">Зарегистрироваться</a>
      </td>
    </tr>
  </table>
</form>