<?php

$sessionlifetime = 2592000;
session_set_cookie_params($sessionlifetime);
session_start();

require 'includes/dbh.inc.php';

//In case user is not logged in, we are redirecting to index.php:
if (!isset($_SESSION['username'])) {
  header('Location: index.php');
}

$itemsQuery = $db->prepare("
  SELECT id, name, done
  FROM items
  WHERE userid = :user
  ORDER BY done
");

$itemsQuery->execute([
  'user' => $_SESSION['userid']
]);

//Now we get the previous query on a array:
$items = $itemsQuery->rowCount() ? $itemsQuery : [];
//foreach($items as $item) {
//  print_r($item);
//}

 ?>


<!DOCTYPE html>
<html lang="en" dir="ltr">
  <head>
    <meta charset="utf-8">
    <title>List of To Do's</title>
    <link rel="shortcut icon" href="images/favicon.png">

    <link href="http://fonts.googleapis.com/css?family=Open+Sans" rel="stylesheet">
    <link rel="stylesheet" href="https://fonts.googleapis.com/icon?family=Material+Icons">

    <link href="css/style_list.css" rel="stylesheet">

    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <!-- Notificacion pop up -->
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>
    <script>
      $(document).ready(function(){
          $("div.alert-box").delay(1800).fadeOut();
      });
    </script>


  </head>

  <body>


    <?php
      if(isset($_GET['action'])){
      echo "<div class='alert-box'>The item has been deleted.</div>";
      }
    ?>

    <table style="width:100%" class="table">
      <tr>
        <th>
          <?php
            echo "<p align='left'>welcome <strong>@".$_SESSION['username']."</strong></p>";
          ?>
        </th>
        <th>
          <form action="includes/logout.inc.php" method="post">
              <p align="right"><input type="submit" name="logout" value="Sign out"></p>
          </form>
        </th>
      </tr>
    </table>



    <div id="login">
    </div>


    <div class="list">

      <form class="item-add" action="includes/newtask.inc.php" method="post" align="center">
        <input type="text" name="name" id="name" placeholder="Create a new task here." class="input" autocomplete="off" required>
        <input type="submit" value="Add" class="submit">
      </form>

    </div>

    <br/>

    <div class="list">

        <h2 class="header" align="center">My To Do's</h2>

        <?php if(!empty($items)): ?>
        <ul class="items">
          <?php foreach($items as $item): ?>
            <li>
              <!-- There is some php inside the class atribute to evaluate if we have an open_item or an done_item -->
              <span class="item<?php echo $item['done'] ? ' done': '' ?>">
                <?php
                  //Echo and dencryption of the name of the task, which it is encrypted before saving it in the database for security reasons
                  list($item['name'], $enc_iv) = explode("::", $item['name']);;
                  $cipher_method = 'aes-128-ctr';
                  $enc_key = openssl_digest(php_uname(), 'SHA256', TRUE);
                  $item_new['name'] = openssl_decrypt($item['name'], $cipher_method, $enc_key, 0, hex2bin($enc_iv));
                  //unset($crypted_token, $cipher_method, $enc_key, $enc_iv);
                  echo $item_new['name']; ?>
              </span><br/>
              <!-- Display of the Done button only for open tasks -->
              <?php if(!$item['done']): ?>
                <a href="includes/done.inc.php?status=done&item=<?php echo $item['id']; ?>" class="done-button">Mark as done</a>
              <?php endif; ?>
              <!-- Display of the Delete button will always be visible -->
              <a href="includes/delete.inc.php?status=delete&item=<?php echo $item['id']; ?>" class="delete-button">Delete</a>
                  <!-- Notification pop up -->
            </li>
          <?php endforeach; ?>
        </ul>
      <?php else: ?>
        <p>You haven't added any items yet.</p>
      <?php endif; ?>


      </div>




  </body>
</html>
