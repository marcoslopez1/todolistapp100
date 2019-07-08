<?php

session_start();
require 'dbh.inc.php';

if(isset($_GET['status'], $_GET['item'])){
  $status = $_GET['status'];
  $item = $_GET['item'];

  switch($status) {
      case 'done':
        $doneQuery = $db->prepare("
          UPDATE items SET done = '1'
          WHERE id = :item AND userid = :user
          ");

        $doneQuery->execute([
          'item' => $item,
          'user' => $_SESSION['userid']
        ]);

        break;
  }

}

header('Location: ../todos.php');

 ?>
