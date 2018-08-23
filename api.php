<?php
session_start();

require('sql.php');
require('classes/Comment.php');
require('classes/Library.php');
require('classes/Post.php');
require('classes/User.php');

header("Access-Control-Allow-Credentials: true");
header("X-Frame-Options: DENY");

$server = "localhost";
$user = $GLOBALS['sql_user'];
$pass = $GLOBALS['sql_pass'];
$db = "zerentha_meme";

$GLOBALS['conn'] = new mysqli($server, $user, $pass, $db);

if (!isset($_SESSION['id']) && isset($_COOKIE['PHPSESSID'])) {
  $_SESSION['id'] = User::loadFromSession($_COOKIE['PHPSESSID'])->id;
}

if ($_SESSION['id']) {
  $GLOBALS['user'] = User::loadFromId($_SESSION['id']);
  $user = $GLOBALS['user'];
  $ip = get_client_ip();
  $user->ip = $ip;
  $user->session = session_id();
  $user->updateFields("ip", "session");
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

$commands = array();
$GLOBALS['commands'] = $commands;

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
  $account = User::loadFromHandle($_POST['handle']);
  $user->addFollowing($account->id);
  jsonMessage(array("following"=>true, "followers"=>$account->getFollowerCount()));
});

Command::register("unfollow", function($user) {
  $account = User::loadFromHandle($_POST['handle']);
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

  if (move_uploaded_file($_FILES['file']['tmp_name'], 'images/' . $id . "." . $_POST['type'])) {
    $date = gmdate(DATE_ATOM);
    $conn = $GLOBALS['conn'];
    $title = '';
    if (isset($_POST['caption'])) {
      $title = $_POST['caption'];
    }
    $stmt = $conn->prepare("INSERT INTO `posts` (`id`, `caption`, `tags`, `source`, `original`, `date`, `type`, `parent`, `library`) VALUES (?, ?, '', ?, NULL, ?, ?, ?, ?);");
    $stmt->bind_param("ssissis", $id, $title, $user->id, $date, $_POST['type'], $_POST['parent'], $_POST['library']);
    $stmt->execute();

    jsonMessage(array("id"=>$id));
  } else {
    jsonError("Something went wrong while uploading your file. Please try again later.");
  }
});

Command::register("get_post", function($user) {
  $id = $_POST['id'];
  $post = Post::loadFromId($id);
  if ($post === null)
    jsonMessage(array("id"=>"null"));
  else {
    $post->source = User::loadFromId($post->source)->handle;
    jsonMessage((array) $post);
  }
});

Command::register("create_library", function($user) {
  $id = uniqid('', true);
  $date = gmdate(DATE_ATOM);
  $conn = $GLOBALS['conn'];
  $stmt = $conn->prepare("INSERT INTO `libraries` (`id`, `user`, `name`, `visibility`, `date`) VALUES (?, ?, ?, ?, ?);");
  $stmt->bind_param("sisis", $id,  $user->id, $_POST['name'], $_POST['visibility'], $date);
  $stmt->execute();
  jsonMessage(array("type"=>"create","id"=>$id));
});

Command::register("edit_library", function($user) {
  $id = $_POST['id'];
  $conn = $GLOBALS['conn'];
  $stmt = $conn->prepare("UPDATE `libraries` SET `name`=?, `visibility`=? WHERE `id`=?");
  $stmt->bind_param("sis", $_POST['name'], $_POST['visibility'], $id);
  $stmt->execute();
  jsonMessage(array("type"=>"edit","id"=>$id));
});

Command::register("delete_library", function($user) {
  $id = $_POST['id'];
  $conn = $GLOBALS['conn'];
  $stmt = $conn->prepare("DELETE FROM `libraries` WHERE `id`=?");
  $stmt->bind_param("s", $id);
  $stmt->execute();
  jsonMessage(array());
});

Command::register("get_library", function($user) {
  $id = $_POST['id'];
  $lib = loadDBObject("libraries", "`id`='$id'", "Library");
  if ($lib === null)
    jsonMessage(array("id"=>"null"));
  else
    jsonMessage((array) $lib);
});

Command::register("get_timeline", function($user) {
  $message = getTimeline($_POST['handle'], $_POST['page']);
  if ($message == NULL)
    jsonMessage(array());
  else
    jsonMessage($message);
});

Command::register("upvote_post", function($user) {
  $id = $_POST['id'];
  $post = Post::loadFromId($id);
  $vote = $post->upvote($user);
  jsonMessage(array("votes"=>$post->getVotes(), "vote"=>$vote));
});

Command::register("downvote_post", function($user) {
  $id = $_POST['id'];
  $post = Post::loadFromId($id);
  $vote = $post->downvote($user);
  jsonMessage(array("votes"=>$post->getVotes(), "vote"=>$vote));
});

Command::register("repost", function($user) {
  $id = $_POST['id'];
  $post = Post::loadFromId($id);
  $reposted = $post->repost($user);
  jsonMessage(array("reposts"=>$post->getRepostCount(), "reposted"=>$reposted));
});

Command::register("upvote_comment", function($user) {
  $id = $_POST['id'];
  $cmt = Comment::loadFromId($id);
  $vote = $cmt->upvote($user);
  jsonMessage(array("votes"=>$cmt->getVotes(), "vote"=>$vote));
});

Command::register("downvote_comment", function($user) {
  $id = $_POST['id'];
  $cmt = Comment::loadFromId($id);
  $vote = $cmt->downvote($user);
  jsonMessage(array("votes"=>$cmt->getVotes(), "vote"=>$vote));
});

Command::register("post_comment", function($user) {
  if ($_POST['text'] == '') {
    jsonError("Empty message.");
    return;
  }
  $id = uniqid('', true);
  $date = gmdate(DATE_ATOM);
  $conn = $GLOBALS['conn'];
  if ($_POST['parent'] == "null") {
    $stmt = $conn->prepare("INSERT INTO `comments` (`user`, `text`, `post`, `id`, `parent`, `date`) VALUES (?, ?, ?, ?, NULL, ?);");
    $stmt->bind_param("issss", $user->id, $_POST['text'], $_POST['post'], $id, $date);
  } else {
    $stmt = $conn->prepare("INSERT INTO `comments` (`user`, `text`, `post`, `id`, `parent`, `date`) VALUES (?, ?, ?, ?, ?, ?);");
    $stmt->bind_param("isssss", $user->id, $_POST['text'], $_POST['post'], $id, $_POST['parent'], $date);
  }
  $stmt->execute();
  jsonMessage(array("id"=>$id));
});

$action = $_GET['action'];

if ($action) {
  $user = null;
  $session = $_POST['session'];

  if ($session == session_id()) {
    $user  = User::loadFromSession($session);
  } else if ($session) {
    $stmt = $conn->prepare("SELECT user FROM `sessions` WHERE id=?");
    $stmt->bind_param("s", $session);
    $stmt->execute();
    $result = $stmt->get_result();
    if ($result->num_rows > 0) {
      $row = $result->fetch_assoc();
      $user = User::loadFromId($row['user']);
    }
  }

  foreach ($commands as $command) {
    if ($command->name == $action) {
      call_user_func($command->action, $user);
    }
  }
}

// Functions:

function getTimeline($handle, $page, $self) {
  $account = User::loadFromHandle($handle);

  $conn = $GLOBALS['conn'];
  $stmt = $conn->prepare("SELECT DISTINCT `date` FROM `libraries` WHERE `user`={$account->id} UNION SELECT DISTINCT `date` FROM `posts` WHERE `source`={$account->id} AND `original` IS NULL");
  $stmt->execute();
  $result = $stmt->get_result();

  $dates = array();

  while ($row = $result->fetch_assoc()) {
    array_push($dates, $row['date']);
  }

  sort($dates);

  $datesFlip = array();

  for ($i = sizeof($dates) - 1; $i >= 0; $i--) {
    array_push($datesFlip, $dates[$i]);
  }
  $dates = $datesFlip;

  $last = "";
  for ($i = 0; $i < sizeof($dates); $i++) {
    $dates[$i] = substr($dates[$i], 0, 10);
    if ($dates[$i] == $last) {
      array_splice($dates, $i, 1);
      $i--;
    } else {
      $last = $dates[$i];
    }
  }

  if ($page >= sizeof($dates)) {
    return NULL;
  }

  logger(varToString($dates));

  $ymd = $dates[$page];

  $libs = loadDBObjects("libraries", "`user`={$account->id} AND `date` LIKE '{$ymd}%' ORDER BY `date` DESC", "Library");
  $posts = loadDBObjects("posts", "`source`={$account->id} AND `original` IS NULL AND `date` LIKE '{$ymd}%' ORDER BY `date` DESC", "Post");
  $postGroups = array();

  foreach ($posts as $post) {
    if (!isset($postGroups[$post->library]))
      $postGroups[$post->library] = array();
    array_push($postGroups[$post->library], $post->id);
  }

  $libIds = array();

  foreach ($libs as $lib) {
    if ((!$lib->private || $is_self) || $lib->visibility == 2 || ($lib->visibility == 1 && ($self->id == $account->id || $self->isFollowing($account->id))) || ($lib->visibility == 0 && $self->id == $account->id))
      array_push($libIds, $lib->id);
  }

  return array($libIds, $postGroups);
}

function isLibrary($id) {
  $conn = $GLOBALS['conn'];
}

function settingsMenu() {
  ?>
  <div class="s-settings" style="display: none;">
    <div class="s-title-box">
      <h1 class="s-title">Settings</h1>
      <i class="material-icons black s-delete closeSettings">clear</i>
    </div>
    <div class="s-tab-box">
      <div class="s-tab-holder">
        <div class="s-tab s-selected">
          GENERAL
        </div>
        <div class="s-tab">
          ACCOUNT
        </div>
      </div>
    </div>
    <div class="s-content">
      <div class="s-c-wrapper">
        <div class="s-c-tab">
          <h1 class="s-section-title">Notifications</h1>
          <label class="container">Enable Notifications
            <label class="switch">
              <input type="checkbox">
              <span class="slider round"></span>
            </label>
          </label>
          <div class="line"></div>
          <label class="container">Checkmark
            <input type="checkbox">
            <span class="checkmark"></span>
          </label>
          <label class="container">Radio
            <input type="radio" name="radio" checked="checked">
            <span class="radio"></span>
          </label>
          <label class="container">Buttons
            <input type="radio" name="radio">
            <span class="radio"></span>
          </label>

        </div>
        <div class="s-c-tab account">
          <h1 class="s-section-title">Personalisation</h1>
          <div class="p-holder">
          <div class="image edit">
              <img class="setting-img">
              <input type="file" id="acctImg" multiple="" accept="image/*" style="display:none;">
              <label for="acctImg">
                <p class="i-edit" style="/* display:  none; */">Edit</p>
              </label>
            </div>
            <div style="margin-bottom:20px;">
              <div class="input s">
                <input type="text" placeholder="Change name" value="Gaetan A." class="input-bar" />
              </div>
              <p class="input-sub">Name may only contain </p>
              <div class="input s">
                <input type="text" placeholder="Change handle" value="@Al" class="input-bar i-handle" />
              </div>
              <p class="input-sub">_______ is already taken</p>
            </div>
          </div>
          <h1 class="s-section-title">Other</h1>
          <label class="container">Lock Account
            <label class="switch">
              <input type="checkbox">
              <span class="slider round"></span>
            </label>
          </label>
        </div>
      </div>
    </div>
    <div class="s-bottom-buttons">
      <button class="s-op-1 closeSettings">Cancel</button>
      <button class="s-op-2" style="color: #4167f4;">Save</button>
    </div>
  </div>
  <?php
}

function topBar($self) {
  ?>
  <div class="top-bar">

    <i class="material-icons openSidenav" style="display: none;">menu</i>

    <div class="ec-account-settings">
      <div class="account-info">
        <div class="sd-img">
          <img src="<?php echo $self->getImage(); ?>" class="home-topbar-image" style="border: inherit; border-radius: inherit;" width="width" height="40">
        </div>
        <div class="sd-infoholder disapear">
          <h1 class="n-name sdname"><?php echo $self->name; ?></h1>
          <div class="username">
            @<?php echo $self->handle; ?>
          </div>
        </div>
      </div>

      <i class="material-icons settings openAccount">settings</i>
    </div>

    <div class="searchbar">
      <i class="material-icons search-g" style="float: left; position:relative; top: -4px;">search</i><input type="text" class="input-searchbar" placeholder="Search" style="all: unset; width: 150px;position: relative; left: 11px; color: #646d6d; top: 1px;" />
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
          <img src="<?php echo $self->getImage(); ?>" class="home-topbar-image" style="border: inherit; border-radius: inherit;" width="auto" height="40">
        </div>
        <div class="sd-infoholder">
          <h1 class="n-name sdname"><?php echo $self->name; ?></h1>
          <div class="username">
            @<?php echo $self->handle; ?>
          </div>
        </div>
      </div>
      <div class="sd-content">

            <a style="all:unset;" href="/account.php">
              <div class="section">
                  <i class="material-icons s-icon settings-icon">account_circle</i>
                  <div class="s-txt">
                    My Account
                  </div>
              </div>
            </a>
            <a style="all:unset;" href="/">
              <div class="section">
                  <i class="material-icons s-icon settings-icon">group</i>
                  <div class="s-txt">
                    Switch Accounts
                  </div>
              </div>
            </a>
            <a style="all:unset;" href="/logout.php">
            <div class="section">
                <i class="material-icons s-icon settings-icon">exit_to_app</i>
                <div class="s-txt">
                  Sign Out
                </div>
            </div>
          </a>
          <!-- <div class="long-line"></div>
            <div class="section">
              <a style="all:unset;" href="/">
                <i class="material-icons s-icon settings-icon">help</i>
                <div class="s-txt">
                  Help
                </div>
              </a>
            </div>
            <div class="section">
              <a style="all:unset;" href="/">
                <i class="material-icons s-icon settings-icon">feedback</i>
                <div class="s-txt">
                  Send Feedback
                </div>
              </a>
            </div> -->
            <div class="section openSettings">
                <i class="material-icons s-icon settings-icon">settings</i>
                <div class="s-txt">
                  Settings
                </div>
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
    <link href="https://fonts.googleapis.com/css?family=Rubik:400,500,700" rel="stylesheet">
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

function loadDBObjects($table, $selector, $classname) {
  $conn = $GLOBALS['conn'];
  $stmt = $conn->prepare("SELECT * FROM $table WHERE $selector");
  logger($table . " : " . $selector);
  logger(varToString(debug_backtrace()));
  $stmt->execute();
  $result = $stmt->get_result();
  $objects = array();
  if ($result->num_rows > 0) {
    while ($obj = $result->fetch_object($classname)) {
      $obj->fixVars();
      array_push($objects, $obj);
    }
  }
  return $objects;
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

function shortNum($num) {
  if ($num >= 1000000000) return round(($num/1000000000),1)."B";
  if ($num >= 1000000) return round(($num/1000000),1)."M";
  if ($num >= 1000) return round(($num/1000),1).'K';
  return $num;
}
 ?>
