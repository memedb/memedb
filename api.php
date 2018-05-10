<?php
ini_set('session.gc_maxlifetime', 100000);

session_set_cookie_params(100000);

session_start();

require('sql.php');

$server = "localhost";
$user = $GLOBALS['sql_user'];
$pass = $GLOBALS['sql_pass'];
$db = "zerentha_meme";

$GLOBALS['conn'] = new mysqli($server, $user, $pass, $db);

if ($_SESSION['id']) {
  $GLOBALS['user'] = user::loadFromId($_SESSION['id']);
  $conn = $GLOBALS['conn'];
  $ip = get_client_ip();
  $stmt = $conn->prepare("UPDATE users SET ip = '$ip', session='".session_id()."' WHERE id = ".$user->id);
  $stmt->execute();
} else {
  $GLOBALS['user'] = null;
}

if ($GLOBALS['conn']->connect_error) {
  die("Database connection failed: " . $conn->connect_error);
}

if($_SERVER["HTTPS"] != "on") {
  header("Location: https://" . $_SERVER["HTTP_HOST"] . $_SERVER["REQUEST_URI"]);
  exit();
}

// REST api:

$commands = array();
$GLOBALS['commands'] = $commands;

class Command {

  var $name;
  var $action;

  function __construct($name, $action) {
    $this->name = $name;
    $this->action = $action;
  }

  static function register($name, $action) {
    array_push($GLOBALS['commands'], new Command($name, $action));
  }

}

$conn = $GLOBALS['conn'];

Command::register("start_session", function($user) {
  $name = $_POST['username'];
  $pass = $_POST['password'];

  if ($id = checkLogin($name, $pass)) {
    $stmt = $conn->prepare("INSERT INTO `sessions` (`id`, `user`) VALUES (?, ?);");
    $stmt->bind_param("si", $sid, $id);
    $sid = uniqid('', true);
    $stmt->execute();
  } else {
    jsonError("Incorrect username or password");
  }
});

Command::register("follow", function($user) {
  $account = user::loadFromHandle($_POST['handle']);
  $user->addFollowing($account->id);
  jsonMessage(array("following"=>true, "followers"=>$account->getFollowerCount()));
});

Command::register("unfollow", function($user) {
  $account = user::loadFromHandle($_POST['handle']);
  $user->removeFollowing($account->id);
  jsonMessage(array("following"=>false, "followers"=>$account->getFollowerCount()));
});

Command::register("delete_favorite", function($user) {
  $user->removeFavorite($_POST['type']);
  jsonMessage(array("favorites"=>$user->favorites));
});

Command::register("add_favorite", function($user) {
  $user->addFavorite($_POST['type']);
  jsonMessage(array("favorites"=>$user->favorites));
});

Command::register("search_tag", function($user) {
  $conn = $GLOBALS['conn'];
  $stmt = $conn->prepare("SELECT * FROM `tags` WHERE `name` LIKE ?");
  $search = "%{$_POST['q']}%";
  $stmt->bind_param("s", $search);
  $stmt->execute();
  $result = $stmt->get_result();
  $tags = [];
  while ($row = $result->fetch_assoc()) {
    array_push($tags, $row['name']);
  }
  jsonMessage(array("results"=>$result->num_rows,"tags"=>$tags,"q"=>$_POST['q'],"code"=>$_POST['code']));
});

Command::register("create_post", function($user) {
  $id = uniqid('', true);
  $date = gmdate(DATE_ATOM);
  $conn = $GLOBALS['conn'];
  $stmt = $conn->prepare("INSERT INTO `posts` (`id`, `tags`, `upvotes`, `downvotes`, `source`, `date`, `type`, `parent`, `library`) VALUES (?, '', 0, 0, ?, ?, ?, ?, ?);");
  $stmt->bind_param("sissii", $id, $user->id, $date, $_POST['type'], $_POST['parent'], $_POST['library']);
  $stmt->execute();

  move_uploaded_file($_FILES['file']['tmp_name'], 'images/' . $id . "." . $_POST['type']);

  jsonMessage(array("id"=>$id));
});

$action = $_GET['action'];

if ($action) {
  $user = null;
  $session = $_POST['session'];

  if ($session == session_id()) {
    $user = user::loadFromSession($session);
  }

  if ($session) {
    $stmt = $conn->prepare("SELECT user FROM `sessions` WHERE id=?");
    $stmt->bind_param("s", $session);
    $stmt->execute();
    $result = $stmt->get_result();
    if ($result->num_rows > 0) {
      $row = $result->fetch_assoc();
      $user = user::loadFromId($row['user']);
    }
  }

  foreach ($commands as $command) {
    if ($command->name == $action) {
      call_user_func($command->action, $user);
    }
  }
}

// Functions:

function topBar($self) {
  ?>
  <div class="top-bar">
    <div class="ec-account-settings">
      <div class="account-info">
        <div class="sd-img">
          <img src="<?php echo $self->getImage(); ?>" style="border: inherit; border-radius: inherit;" width="40" height="40">
        </div>
        <div class="sd-infoholder">
          <h1 class="n-name sdname"><?php echo $self->name; ?></h1>
          <div class="username">
            @<?php echo $self->handle; ?>
          </div>
        </div>
      </div>

      <i class="material-icons settings openAccount">settings</i>
    </div>

    <div class="searchbar">
      <i class="material-icons search-g" style="float: left; position:relative; top: -4px;">search</i><input type="text" placeholder="Search Site" style="all: unset; width: 150px;position: relative; left: 11px; color: #646d6d; top: -1.5px;" />
    </div>

    <div class="ec-search-results">
      <div class="ec-result-section">
        <div class="s-txt ec result highlighted">
          MEME 1
        </div><i class="material-icons ec-icons up results">trending_up</i>
      </div>

      <div class="ec-result-section">
        <div class="s-txt ec result">
          MEME 2
        </div><i class="material-icons ec-icons idle results">trending_flat</i>
      </div>

      <div class="ec-result-section">
        <div class="s-txt ec result">
          MEME 3
        </div><i class="material-icons ec-icons low results">trending_down</i>
      </div>
    </div>

  </div>

    <div class="s-dropdown">
      <div class="s-d-titlebox">
        <div class="sd-img">
          <img src="<?php echo $self->getImage(); ?>" style="border: inherit; border-radius: inherit;" width="40" height="40">
        </div>
        <div class="sd-infoholder">
          <h1 class="n-name sdname"><?php echo $self->name; ?></h1>
          <div class="username">
            @<?php echo $self->handle; ?>
          </div>
        </div>
      </div>
      <div class="sd-content">
        <div class="sd-option">

        </div>
        <div class="sd-option">

        </div>
      </div>
    </div>
  <?php
}

function jsonMessage($data) {
  $data['status'] = 'success';
  echo json_encode($data);
}

function jsonError($message) {
  echo json_encode(array('status' => 'error', 'msg' => $message));
}

function checkLogin($name, $pass) {
  if ($name == null || $pass == null)
    return false;

  $conn = $GLOBALS['conn'];

  $stmt = $conn->prepare("SELECT salt FROM users WHERE (handle=? OR email=?)");
  $stmt->bind_param('ss', $name, $pass);
  $stmt->execute();
  $result = $stmt->get_result();
  $salt = $result->fetch_assoc()['salt'];

  $pass = hash("sha256", $pass.$salt);

  $stmt = $conn->prepare("SELECT id FROM users WHERE (handle=? OR email=?) AND pwd=?");
  $stmt->bind_param('sss', $name, $email, $pass);
  $stmt->execute();
  $result = $stmt->get_result();

  if ($result->num_rows > 0) {
    return $result->fetch_assoc()['id'];
  } else {
    return false;
  }
}

function varToString($input) {
  return(var_export($input, true));
}

function logger($input) {
  $myfile = fopen("./logger.txt", "a+") or die("Unable to open file!");
  $dbgt=debug_backtrace();
  $date = date('m/d/Y h:i:s a', time());
  $txt = $date . "UTC | " . $dbgt[0]['file'] . " [" . $dbgt[0]['line'] . "] : " . $input . "\n";
  fwrite($myfile, $txt);
  fclose($myfile);
}

function exists($value, $table, $column) {
  $conn = $GLOBALS['conn'];
  $value = strtolower($value);
  $sql = "SELECT $column FROM $table WHERE LOWER($column) LIKE ?";
  $stmt = $conn->prepare($sql);
  $stmt->bind_param("s", $value);
  $stmt->execute();
  $result = $stmt->get_result();
  return ($result->num_rows === 1);
}

function imports() {
  ?>
    <script src="/js/jquery-3.3.1.min.js"></script>
    <script src="/js/main.min.js"></script>
    <link href="https://fonts.googleapis.com/css?family=Roboto:300,400,500,700,400italic|Roboto+Mono:400|Material+Icons" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css?family=Lato:400,900,400italic,700italic" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css?family=Roboto|Roboto+Slab:700" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css?family=Rubik:500,700" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css?family=Work+Sans:400,700" rel="stylesheet">
    <meta charset="utf-8">
    <link rel="stylesheet" href="/style/main.min.css">
  <?php
}

function loadDBObject($table, $selector, $classname) {
  $conn = $GLOBALS['conn'];
  $stmt = $conn->prepare("SELECT * FROM $table WHERE $selector");
  $stmt->execute();
  $result = $stmt->get_result();
  if ($result->num_rows > 0) {
    return $result->fetch_object($classname);
  }
  return null;
}

function getUser() {
  return $GLOBALS['user'];
}

function get_client_ip() {
    $ipaddress = '';
    if ($_SERVER['HTTP_CLIENT_IP'])
        $ipaddress = $_SERVER['HTTP_CLIENT_IP'];
    else if($_SERVER['HTTP_X_FORWARDED_FOR'])
        $ipaddress = $_SERVER['HTTP_X_FORWARDED_FOR'];
    else if($_SERVER['HTTP_X_FORWARDED'])
        $ipaddress = $_SERVER['HTTP_X_FORWARDED'];
    else if($_SERVER['HTTP_FORWARDED_FOR'])
        $ipaddress = $_SERVER['HTTP_FORWARDED_FOR'];
    else if($_SERVER['HTTP_FORWARDED'])
        $ipaddress = $_SERVER['HTTP_FORWARDED'];
    else if($_SERVER['REMOTE_ADDR'])
        $ipaddress = $_SERVER['REMOTE_ADDR'];
    else
        $ipaddress = 'UNKNOWN';

    return $ipaddress;
}

function loggedIn() {
  return $_SESSION['id'] !== null;
}

// -------------------------------------------------------------------------------------

class post {

  public static function loadFromId($id) {
    $img = loadDBObject("posts", "id=$id", "post");
    if ($img != null) {
      $img->tags = explode(",",$img->tags);
    }
    return $img;
  }

  public function printImage() {
    echo "<img src=\"/images/" . $this->id . "." . $this->type . "\" />";
  }

}

class user {

  public function getImage() {
    return "/userimg.php?handle=" . $this->handle;
  }

  public static function loadFromId($id) {
    $usr = loadDBObject("users", "id=$id", "user");
    if ($usr != null) {
      $usr->favorites = explode(",",$usr->favorites);
      $usr->image = "/userimg.php?handle=" + $usr->handle;
    }
    return $usr;
  }

  public static function loadFromEmail($email) {
    $usr = loadDBObject("users", "email='$email'", "user");
    if ($usr != null) {
      $usr->favorites = explode(",",$usr->favorites);
      $usr->image = "/userimg.php?handle=" + $usr->handle;
    }
    return $usr;
  }

  public static function loadFromHandle($handle) {
    $usr = loadDBObject("users", "handle='$handle'", "user");
    if ($usr != null) {
      $usr->favorites = explode(",",$usr->favorites);
    }
    return $usr;
  }

  public static function loadFromSession($session) {
    $usr = loadDBObject("users", "session='$session'", "user");
    if ($usr != null) {
      $usr->favorites = explode(",",$usr->favorites);
    }
    return $usr;
  }

  public static function create($name, $email, $password, $google) {
    if ($google)
      $password = uniqid();
    $conn = $GLOBALS['conn'];
    $stmt = $conn->prepare("INSERT INTO `users`
      (`id`, `name`, `handle`, `email`, `pwd`, `salt`, `confirmed`, `priv`, `joined`, `lastSeen`, `favorites`, `karma`, `rank`, `session`)
      VALUES (NULL, ?, ?, ?, ?, ?, 0, 1, ?, ?, '', 0, 0, '')");
    $stmt->bind_param("sssssss", $name, $name, $email, $hPass, $salt, $now, $now);
    $salt = uniqid();
    $hPass = hash("sha256", $password.$salt);
    $now = gmdate(DATE_ATOM);
    $stmt->execute();

    $stmt = $conn-prepare("SELECT id FROM users WHERE email=?");
    $stmt->bind_param('s', $email);
    $stmt->execute();
    $result = $stmt->get_result();

    $id = $result->fetch_assoc()['id'];

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
    return $id;
  }

  public function updateField($key) {
    $conn = $GLOBALS['conn'];
    $stmt = $conn->prepare("UPDATE users SET {$key}=? WHERE id=?");
    $fieldType = "";
    $value = get_object_vars($this)[$key];
    switch (gettype($value)) {
    case "integer":
      $fieldType = "i";
      break;
    case "string":
      $fieldType = "s";
      break;
    case "array":
      $fieldType = "s";
      $value = implode(",", $value);
      $value = substr($value, 0, strlen($value));
      break;
    }
    $stmt->bind_param("{$fieldType}i", $value, $this->id);
    $stmt->execute();
  }

  public function addFavorite($type) {
    array_push($this->favorites, $type);
    $this->updateField("favorites");
  }

  public function removeFavorite($type) {
    $index = -1;
    for ($i = 0; $i < count($this->favorites); $i++) {
      if ($this->favorites[$i] == $type) {
        $index = $i;
        break;
      }
    }
    array_splice($this->favorites, $index, 1);
    $this->updateField("favorites");
  }

  public function getFollowerCount() {
    $conn = $GLOBALS['conn'];
    $stmt = $conn->prepare("SELECT count(following) as followers FROM `following` WHERE `following`=?");
    $stmt->bind_param("i",$this->id);
    $stmt->execute();
    $result = $stmt->get_result();
    return $result->fetch_assoc()['followers'];
  }

  public function getFollowers() {
    $conn = $GLOBALS['conn'];
    $stmt = $conn->prepare("SELECT user FROM `following` WHERE `following`=?");
    $stmt->bind_param("i",$this->id);
    $stmt->execute();
    $result = $stmt->get_result();
    $followers = array();
    while ($row = $result->fetch_assoc()) {
      array_push($followers, $row['user']);
    }
    return $followers;
  }

  public function addFollowing($id) {
    $conn = $GLOBALS['conn'];
    $stmt = $conn->prepare("INSERT INTO `following` (`user`, `following`) VALUES (?, ?)");
    $stmt->bind_param("ii", $this->id, $id);
    $stmt->execute();
  }

  public function removeFollowing($id) {
    $conn = $GLOBALS['conn'];
    $stmt = $conn->prepare("DELETE FROM `following` WHERE user=? AND following=?");
    $stmt->bind_param("ii", $this->id, $id);
    $stmt->execute();
  }

  public function isFollowing($id) {
    $conn = $GLOBALS['conn'];
    $stmt = $conn->prepare("SELECT * FROM `following` WHERE user=? AND following=?");
    $stmt->bind_param("ii", $this->id, $id);
    $stmt->execute();
    $result = $stmt->get_result();
    return $result->num_rows > 0;
  }

}
 ?>
