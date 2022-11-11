<?php 
  if (!$_SESSION['username']) {
    header('Location: /');
  }
  
  include ('module/functions.php');

  $users = getUsers($db);

  if ($_GET['user_id']) {
    $chat_id = getChatId($db, $_GET['user_id'], $_SESSION['user_id']);

    if (!$chat_id) {
      $chat_id = GeneratorId::generate();
      $stmt = $db->prepare('insert into chats(chat_id, user_id) values(:chat_id, :user_id), (:chat_id, :me)');
      $stmt->execute([':user_id' => $_GET['user_id'], ':me' => $_SESSION['user_id'], ':chat_id' => $chat_id]);
    }
    else {
      $stmt = $db->prepare("select message from messages where chat_id = :chat_id");
      $stmt->execute([':chat_id'=>$chat_id]);
      $messages = $stmt->fetchAll();

    }

  if($_POST['message']) {
    $message = $_POST['message'];
    $chat_id = getChatId($db, $_GET['user_id'], $_SESSION['user_id']);
    $stmt = $db->prepare('insert into messages(message, chat_id) values(:message, :chat_id)');
    $stmt->execute([':message'=>$message, ':chat_id'=>$chat_id]);

    header("location: /chat/?user_id={$_GET['user_id']}");
  }


  }

?>

<? include ('base/header.php') ?>

<h1>CHAT</h1>

<div id="container">
  <div id="users">
    <ul>
      <? foreach ($users as $user): ?>
        <? if ($user['user_id'] != $_SESSION['user_id']): ?>
          <li>
            <a href="/chat/?&user_id=<?= $user['user_id'] ?>"><?= $user['username'] ?></a>
          </li>
        <? endif; ?>
      <? endforeach; ?>
    </ul>
  </div>
  <div id="chat">
    <div id="messages">
      <? if($messages): ?>
        <? foreach($messages as $message): ?>
          <div class="message"><?= $message['message'] ?></div>
        <? endforeach; ?>
      <? endif; ?>
    </div>
    <div id="form">
      <form action="" method="post">
        <textarea name="message" id="" cols="30" rows="3"></textarea>
        <button name="send">Send</button>
      </form>
    </div>
  </div>
</div>

<? include ('base/footer.php') ?>