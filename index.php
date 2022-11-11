<?php

  $url = $_SERVER["REQUEST_URI"];
  $url = ltrim($url, '/');

  if ($url) {
    [$view, $action] = explode('/', $url);
  }

  if (!empty($view)) {
    $template = 'views/' . $view . '.php';
  }
  else {
    $template = 'views/index.php';
  }


  $db = new PDO('mysql:host=localhost;dbname=kiddle', 'root', 'root');

  session_start();
  
  include ($template);


?>