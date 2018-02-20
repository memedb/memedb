<?php
session_start();

require('sql.php');

if($_SERVER["HTTPS"] != "on") {
  header("Location: https://" . $_SERVER["HTTP_HOST"] . $_SERVER["REQUEST_URI"]);
  exit();
}

$server = "localhost";
$user = $GLOBALS['sql_user'];
$pass = $GLOBALS['sql_pass'];
$db = "zerentha_meme";

$GLOBALS['conn'] = new mysqli($server, $user, $pass, $db);

if ($GLOBALS['conn']->connect_error) {
  die("Database connection failed: " . $conn->connect_error);
}

function imports() {
  ?>
    <script src="../js/jquery-3.3.1.min.js"></script>
    <script src="../js/main.js"></script>
    <link href="https://fonts.googleapis.com/css?family=Roboto:300,400,500,700,400italic|Roboto+Mono:400|Material+Icons" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css?family=Lato:400,900,400italic,700italic" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css?family=Roboto|Roboto+Slab:700" rel="stylesheet">
    <meta charset="utf-8">
    <link rel="stylesheet" href="../style/main.css">
  <?php
}

function loadDBObject($table, $selector, $classname) {
  $conn = $GLOBALS['conn'];
  $stmt = $conn->prepare("SELECT * FROM $table WHERE $selector");
  $stmt->execute();
  $result = $stmt->get_result();
  if ($result->num_rows > 0) {
    return $result->fetch_object("image");
  }
  return null;
}

class image {

  public static function loadFromId($id) {
    $img = loadDBObject("images", "id=$id", "image");
    if ($img != null) {
      $img->tags = explode(",",$img->tags);
    }
    return $img;
  }

  public function printImage() {
    echo "<img src=\"/images/id-" . $this->id . "." . $this->type . "\" />";
  }

}

class user {

  public static function loadFromId($id) {
    $usr = loadDBObject("users", "id=$id", "user");
    if ($usr != null) {
      $usr->favorites = explode(",",$usr->favorites);
      $usr->following = explode(",",$usr->following);
    }
    return $usr;
  }

  public static function create($name, $email, $password) {
    $conn = $GLOBALS['conn'];
    $stmt = $conn->prepare("INSERT INTO `users`
      (`id`, `name`, `email`, `pwd`, `salt`, `confirmed`, `priv`, `joined`, `lastSeen`, `favorites`, `karma`, `rank`, `following`)
      VALUES (NULL, '?', '?', '?', '?', 0, 1, '?', '?', '', 0, 0, '')");
    $stmt->bind_param("ssssss", $name, $email, $hPass, $salt, $now, $now);
    $salt = uniqid();
    $hPass = hash("sha256", $password.$salt);
    $now = gmdate(DATE_ATOM);
    $stmt->execute();

    $subject = 'MemeDB Confirmation';
    $message = "<html>
    <head>
      <title>MemeDB Confirmation</title>
    </head>
    <body>
      <p>Hi $name! Thank you for registering on MemeDB! To complete the registration click the link below.</p>

      <a href='http://memed-db.com/confirm.php?token=$token'>
        <div>
          Confirm
        </div>
      </a>
      <br>
    </body>
    </html>";

    $headers[] = 'MIME-Version: 1.0';
    $headers[] = 'Content-type: text/html; charset=iso-8859-1';

    $headers[] = 'To: '.$name.' <'.$email.'>';
    $headers[] = 'From: MemeDB Confirmation <support@meme-db.com>';

    mail($email, $subject, $message, implode("\r\n", $headers));

    echo "Thank you for registering! We've sent an email to confirm your account!";
  }

}
 ?>
