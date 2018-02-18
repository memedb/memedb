<?php
require('sql.php');

$server = "localhost";
$user = $GLOBALS['sql_user'];
$pass = $GLOBALS['sql_pass'];
$db = "zerentha_meme";

$GLOBALS['conn'] = new mysqli($server, $user, $pass, $db);

if ($GLOBALS['conn']->connect_error) {
  die("Database connection failed: " . $conn->connect_error);
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

}

$img = image::loadFromId(1);

echo $img->tags[0];
$img->printImage();
 ?>
