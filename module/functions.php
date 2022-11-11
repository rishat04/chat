<?php

  function isUserExist($db, $username) {
    $stmt = $db->prepare("select user_id from users where username=:username");
    $stmt->execute([':username' => $username]);
    $row = $stmt->fetch(PDO::FETCH_LAZY);

    return $row ? true : false;
  }

  function getUsers($db) {
    $stmt = $db->prepare("select username, user_id from users");
    $stmt->execute();
    $row = $stmt->fetchAll(PDO::FETCH_ASSOC);

    return $row;
  }

  function getChatId($db, $user1, $user2) {
    $sql = "select b.chat_id from chats as b left join chats as a on a.chat_id=b.chat_id where a.user_id = {$user1} and b.user_id={$user2}";
    $stmt = $db->prepare($sql);
    $stmt->execute();
    return $stmt->fetch(PDO::FETCH_LAZY)->chat_id;
  }

  class GeneratorId {
    private static $chars = ['a','b','c','d','e','f','g','h','i','j','k','l','m','n','o','p','q','r','s','t','u','v','w','x','y','z'];
    private static $ints  = [1,2,3,4,5,6,7,8,9,0];

    private static $types = ['getInt', 'getChar'];

    public static function generate() {
      $id = '';
      for ($i = 0; $i < 4; $i++) {
        $key = array_rand(self::$types);
        $type = self::$types[$key];
        $id .= self::$type();
      }
      return $id;
    }

    public static function getInt() {
      $key = array_rand(self::$chars, 1);
      return self::$chars[$key];
    }

    public static function getChar() {
      $key = array_rand(self::$ints, 1);
      return self::$ints[$key];
    }
  }

?>