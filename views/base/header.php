<html>
  <head>
    <title>Index</title>
    <link rel="icon" type="image/svg" href="../images/favicon.svg">
    <link rel="stylesheet" href="../../static/style.css">
  </head>
  <body>
    <header>
      <ul>
        <li><a href="/">Index</a></li>
        <? if (!$_SESSION['username']): ?>
          <li><a href="/login">Login</a></li>
          <li><a href="/register">Register</a></li>
        <? else: ?>
          <li><a href="/login/?&action=logout">Logout</a></li>
        <? endif; ?>
      </ul>
    </header>