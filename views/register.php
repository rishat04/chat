<?php
  include ('module/functions.php');

  if (!$_POST['username'] or !$_POST['password'] or !$_POST['confirm']) {
    $warnText = 'Заполните все поля';
  }
  else {
    $username = $_POST['username'];
    $password = $_POST['password'];
    $confirm  = $_POST['confirm'];

    if ($password != $confirm) {
      $warnText = 'Пароли не совпадают';
    }

    if(!isUserExist($db, $username)) {
      $stmt = $db->prepare("insert into users(username, password) values(:username, :password)");
      $stmt->execute([':username' => $username, ':password' => $password]);
    }
    else {
      $warnText = 'Пользовтель с таким именем уже существует';
    }

    if(!$warnText)
      header('Location: /login');
    
  }
?>

<? include ('base/header.php') ?>

<form action="" method="POST">
  <label for="username">Username:</label>
  <input type="text" name="username" value="<?= $username ? $username : null ?>">
  <br>
  <label for="password">Password:</label>
  <input type="password" name="password" value="<?= $password ? $password : null ?>">
  <br>
  <label for="confirm">Confirm:</label>
  <input type="password" name="confirm" value="<?= $confirm ? $confirm : null ?>">
  <br>
  <input type="submit" name="submit" value="Registration">
</form>

<?= $warnText ? $warnText : '' ?>

<? include ('base/footer.php') ?>

