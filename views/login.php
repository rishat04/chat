<?php 

  include ('module/functions.php');

  if (!$_POST['username'] || !$_POST['password']) {
    $warnText = 'Заполните поля';
  }
  else {
    $username = $_POST['username'];
    $password = $_POST['password'];

    if (!isUserExist($db, $username)) {
      $warnText = 'Такого пользователя не существует';
    }
    else {
      $stmt = $db->prepare('select password, user_id from users where username = :username');
      $stmt->execute([':username' => $username]);
      $row = $stmt->fetch(PDO::FETCH_LAZY);

      if ($row->password != $password) {
        $warnText = 'Неверный пароль';
      }
      else {
        $_SESSION['username'] = $username;
        $_SESSION['user_id']  = $row->user_id;
        header('Location: /');
      }
    }
  }

  if ($_GET['action'] and $_GET['action'] == 'logout') {
    if ($_SESSION['username']) {
      session_unset();
      session_destroy();
      header('Location: /');
    }
  }

?>

<? include ('base/header.php') ?>

<form action="" method="POST">
  <label for="username">Username:</label>
  <input type="text" name="username">
  <br>
  <label for="password">Password:</label>
  <input type="password" name="password">
  <br>
  <input type="submit" name="submit" value="Login">
</form>

<?= $warnText ? $warnText : null ?>

<? include ('base/footer.php') ?>