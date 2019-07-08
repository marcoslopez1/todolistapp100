<?php

session_start();
require 'dbh.inc.php';

if(isset($_GET['status'], $_GET['item'])){
  $status = $_GET['status'];
  $item = $_GET['item'];

  switch($status) {
      case 'delete':
        $doneQuery = $db->prepare("
          DELETE from items
          WHERE id= :item
          AND userid = :user
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
