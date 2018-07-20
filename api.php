<?php
session_start();

require('sql.php');

header("Access-Control-Allow-Credentials: true");
header("X-Frame-Options: DENY");

$server = "localhost";
$user = $GLOBALS['sql_user'];
$pass = $GLOBALS['sql_pass'];
$db = "zerentha_meme";

$GLOBALS['conn'] = new mysqli($server, $user, $pass, $db);

if (!isset($_SESSION['id']) && isset($_COOKIE['PHPSESSID'])) {
  $conn = $GLOBALS['conn'];
  $stmt = $conn->prepare("SELECT id FROM users WHERE session='{$_COOKIE['PHPSESSID']}'");
  $stmt->execute();
  $result = $stmt->get_result();
  if ($result->num_rows > 0) {
    $_SESSION['id'] = $result->fetch_assoc()['id'];
  }
}

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
  $post = post::loadFromId($id);
  if ($post === null)
    jsonMessage(array("id"=>"null"));
  else {
    $post->source = user::loadFromId($post->source)->handle;
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
  $lib = loadDBObject("libraries", "`id`='$id'", "library");
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
  $post = post::loadFromId($id);
  $post->upvote($user);
  jsonMessage(array("upvotes"=>$post->getUpvotes()));
});

Command::register("downvote_post", function($user) {
  $id = $_POST['id'];
  $post = post::loadFromId($id);
  $post->downvote($user);
  jsonMessage(array("upvotes"=>$post->getDownvotes()));
});

Command::register("repost", function($user) {
  $id = $_POST['id'];
  $post = post::loadFromId($id);
  $post->repost($user);
  jsonMessage(array("reposts"=>$post->getRepostCount()));
});

Command::register("upvote_comment", function($user) {
  $id = $_POST['id'];
  $cmt = comment::loadFromId($id);
  $cmt->upvote($user);
  jsonMessage(array("upvotes"=>$cmt->getUpvotes()));
});

Command::register("downvote_comment", function($user) {
  $id = $_POST['id'];
  $cmt = comment::loadFromId($id);
  $cmt->downvote($user);
  jsonMessage(array("upvotes"=>$cmt->getDownvotes()));
});

Command::register("post_comment", function($user) {
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
    $user  = user::loadFromSession($session);
  } else if ($session) {
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

function getTimeline($handle, $page, $self) {
  $account = user::loadFromHandle($handle);

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

  $libs = loadDBObjects("libraries", "`user`={$account->id} AND `date` LIKE '{$ymd}%' ORDER BY `date` DESC", "library");
  $posts = loadDBObjects("posts", "`source`={$account->id} AND `original` IS NULL AND `date` LIKE '{$ymd}%' ORDER BY `date` DESC", "post");
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

// -------------------------------------------------------------------------------------

class post {

  public static function loadFromId($id) {
    $img = loadDBObject("posts", "id='$id'", "post");
    $img->fixVars();
    return $img;
  }

  public function fixVars() {
    $arr = explode(',',$this->tags);
    if ($arr[0] === "")
      $this->tags = array();
    else
      $this->tags = $arr;
  }

  public function printImage($class, $resizeHolder, $width) {
    $size = getimagesize("./images/" . ($this->original ? $this->original : $this->id) . "." . $this->type);
    $height = ($size[1]/$size[0]) * $width;
    ?>
    <img onclick="showImagePreview(event);" data-id="<?=$this->id;?>" class="<?=$class?>" src="/images/<?=($this->original ? $this->original : $this->id) . "." . $this->type?>" style="<?=$resizeHolder ? "height: ".$height."px;" : ""?>">
    <?php
  }

  public static function printActivityContainerHtml($timestamp, $posts) {
    $dateStr = date("d M Y", $timestamp);
    if (sizeof($posts) == 1) {
    ?>
    <div class="exp-post">
      <?php
      $posts[0]->printImage("exp-post-image", true, 600);
      ?>
      <div class="exp-post-info">
        <h6><?=$posts[0]->caption;?></h6>
        <h2 class="card-date"><?=$dateStr?></h2>
      </div>
    </div>
    <?php
    } else {
      if (sizeof($posts) >= 5) {
      ?>
      <div class="exp-card long">
        <div class="exp-card-title">
          <h1 class="card-title">+ <?=$posts[0]->getLibrary()->name?></h1>
          <h2 class="card-date"><?=$dateStr?></h2>
        </div>
        <div class="exp-card-content">
          <?php
            $count = 0;
            foreach ($posts as $post) {
              ?>
              <div class="small-post" style="background-image: url(/images/<?=($post->original ? $post->original : $post->id) . "." . $post->type?>);">
              </div>
              <?php
              $count++;
              if ($count >= 13)
                break;
            }
          if (sizeof($posts) > 13) {
            ?>
            <div class="small-post"><h1 class="album-text small"><?=sizeof($posts) - 13?></h1></div>
            <?php
          }
          ?>
        </div>
      </div>
      <?php
      }
    }
  }

  public function getLibrary() {
    return loadDBObject("libraries", "`id`='{$this->library}'", "library");
  }

  public function getRepostCount() {
    $conn = $GLOBALS['conn'];
    $stmt = $conn->prepare("SELECT COUNT(id) AS reposts FROM `posts` WHERE `original`=?");
    $stmt->bind_param("s", $this->id);
    $stmt->execute();
    $result = $stmt->get_result();
    return $result->fetch_assoc()['reposts'];
  }

  public function getUpvotes() {
    $conn = $GLOBALS['conn'];
    $stmt = $conn->prepare("SELECT COUNT(vote) AS upvotes FROM `votes` WHERE `vote`=1 AND `post`=?");
    $stmt->bind_param("s", $this->id);
    $stmt->execute();
    $result = $stmt->get_result();
    return $result->fetch_assoc()['upvotes'];
  }

  public function getDownvotes() {
    $conn = $GLOBALS['conn'];
    $stmt = $conn->prepare("SELECT COUNT(id) AS downvotes FROM `votes` WHERE `vote`=-1 AND `post`=?");
    $stmt->bind_param("s", $this->id);
    $stmt->execute();
    $result = $stmt->get_result();
    return $result->fetch_assoc()['downvotes'];
  }

  public function upvote($user) {
    $this->vote(1, $user);
  }

  public function downvote($user) {
    $this->vote(-1, $user);
  }

  private function vote($vote, $user) {
    $conn = $GLOBALS['conn'];
    $stmt = $conn->prepare("SELECT post FROM votes WHERE post=? AND vote=?");
    $stmt->bind_param("si", $this->id, $vote);
    $stmt->execute();
    $result = $stmt->get_result();
    if ($result->num_rows == 0) {
      $stmt = $conn->prepare("INSERT INTO `votes` (`user`, `post`, `vote`) VALUES (?, ?, ?)");
      $stmt->bind_param("isi", $user->id, $this->id, $vote);
      $stmt->execute();
    } else {
      $stmt = $conn->prepare("DELETE FROM `votes` WHERE `post`=? AND `user`=?");
      $stmt->bind_param("si", $this->id, $user->id);
      $stmt->execute();
    }
    $post = post::loadFromId($this->id);
  }

  public function repost($user) {
    $conn = $GLOBALS['conn'];
    $stmt = $conn->prepare("SELECT `id` FROM `posts` WHERE `original`=? AND `source`=?");
    $stmt->bind_param("si", $this->id, $user->id);
    $stmt->execute();
    $result = $stmt->get_result();
    if ($result->num_rows == 0) {
      $id = uniqid('', true);
      $date = gmdate(DATE_ATOM);
      $lib = "POSTS";
      $stmt = $conn->prepare("INSERT INTO `posts` (`id`, `caption`, `tags`, `source`, `original`, `date`, `type`, `parent`, `library`) VALUES (?, '', '', ?, ?, ?, ?, ?, ?);");
      $stmt->bind_param("sisssis", $id, $user->id, $this->id, $date, $this->type, $this->parent, $lib);
      $stmt->execute();
    } else {
      $stmt = $conn->prepare("DELETE FROM `posts` WHERE `original`=? AND `source`=?");
      $stmt->bind_param("si", $this->id, $user->id);
      $stmt->execute();
    }
  }

  public function getComments() {
    return loadDBObjects("comments", "`post`='{$this->id}' AND `parent` IS NULL ORDER BY date DESC", "comment");
  }

  public function getCommentCount() {
    $conn = $GLOBALS['conn'];
    $stmt = $conn->prepare("SELECT COUNT(id) AS comments FROM `comments` WHERE `post`=?");
    $stmt->bind_param("s", $this->id);
    $stmt->execute();
    $result = $stmt->get_result();
    return $result->fetch_assoc()['comments'];
  }

}

class comment {

  public static function loadFromId($id) {
    $cmt = loadDBObject("comments", "id='$id'", "comment");
    $cmt->fixVars();
    return $cmt;
  }
 
  public function fixVars() {
  }

  public function getUpvotes() {
    $conn = $GLOBALS['conn'];
    $stmt = $conn->prepare("SELECT COUNT(vote) AS upvotes FROM `comment_votes` WHERE `vote`=1 AND `id`=?");
    $stmt->bind_param("s", $this->id);
    $stmt->execute();
    $result = $stmt->get_result();
    return $result->fetch_assoc()['upvotes'];
  }

  public function getDownvotes() {
    $conn = $GLOBALS['conn'];
    $stmt = $conn->prepare("SELECT COUNT(id) AS downvotes FROM `comment_votes` WHERE `vote`=-1 AND `id`=?");
    $stmt->bind_param("s", $this->id);
    $stmt->execute();
    $result = $stmt->get_result();
    return $result->fetch_assoc()['downvotes'];
  }

  public function upvote($user) {
    $this->vote(1, $user);
  }

  public function downvote($user) {
    $this->vote(-1, $user);
  }

  private function vote($vote, $user) {
    $conn = $GLOBALS['conn'];
    $stmt = $conn->prepare("SELECT id FROM comment_votes WHERE id=? AND vote=?");
    $stmt->bind_param("si", $this->id, $vote);
    $stmt->execute();
    $result = $stmt->get_result();
    if ($result->num_rows == 0) {
      $stmt = $conn->prepare("INSERT INTO `comment_votes` (`id`, `user`, `vote`) VALUES (?, ?, ?)");
      $stmt->bind_param("ssi", $this->id, $user->id, $vote);
      $stmt->execute();
    } else {
      $stmt = $conn->prepare("DELETE FROM `comment_votes` WHERE `id`=? AND `user`=?");
      $stmt->bind_param("si", $this->id, $user->id);
      $stmt->execute();
    }
    //$post = post::loadFromId($this->id);
  }

  public function getReplies() {
    return loadDBObjects("comments", "`post`='{$this->post}' AND `parent`='{$this->id}' ORDER BY date DESC", "comment");
  }

}

class user {

  public function getImage() {
    return "/userimg.php?handle=" . $this->handle;
  }

  public static function loadFromId($id) {
    $usr = loadDBObject("users", "id={$id}", "user");
    $usr->fixVars();
    return $usr;
  }

  public static function loadFromEmail($email) {
    $usr = loadDBObject("users", "email='$email'", "user");
    $usr->fixVars();
    return $usr;
  }

  public static function loadFromHandle($handle) {
    $usr = loadDBObject("users", "handle='$handle'", "user");
    $usr->fixVars();
    return $usr;
  }

  public static function loadFromSession($session) {
    $usr = loadDBObject("users", "session='$session'", "user");
    $usr->fixVars();
    return $usr;
  }

  public function fixVars() {
    if ($usr != null) {
      $usr->favorites = explode(",",$usr->favorites);
      $usr->image = "/userimg.php?handle=" + $usr->handle;
    }
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
    $headers[] = 'From: MemeDB Confirmation <support@memedb.io>';

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

  public function getFormattedFollowerCount() {
    $count = $this->getFollowerCount();
    return shortNum($count);
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

  public function getAccountLink() {
    
  }

}

class library {

  public static function create($name, $posts, $icon, $canUpload, $user) {
    $lib = new library();
    $lib->name = $name;
    $lib->id = $name;
    $lib->posts = $posts;
    $lib->icon = $icon;
    $lib->canUpload = $canUpload;
    $lib->visibility = 2;
    $lib->user = $user->id;
    return $lib;
  }

  public static function loadFromUser($user) {
    $libs = loadDBObjects("libraries", "user={$user->id}", "library");
    array_unshift($libs,
      library::create("POSTS", loadDBObjects("posts", "source={$user->id} AND original IS NULL", "post"), "photo_library", true, $user),
      library::create("REPOSTS", loadDBObjects("posts", "source={$user->id} AND original IS NOT NULL", "post"), "repeat", false, $user),
      library::create("FAVORITES", loadDBObjects("posts", "id IN (SELECT post FROM favorites WHERE user={$user->id})", "post"), "start", false, $user)
    );
    return $libs;
  }

  public function getPosts() {
    if ($this->posts)
      return $this->posts;
    logger("library='{$this->id}' AND source={$this->user}");
    return loadDBObjects("posts", "library='{$this->id}' AND source={$this->user}", "post");
  }

  public function fixVars() {}

  public static function printActivityContainerHtml($timestamp, $libs) {
    $dateStr = date("d M Y", $timestamp);
    ?>
      <div class="exp-card">
        <div class="exp-card-title">
          <h1 class="card-title">+ New Library</h1>
          <h2 class="card-date"><?=$dateStr?></h2>
        </div>
        <div class="exp-card-content">
          <?php
            foreach ($libs as $lib) {
              $lib->printActivityHtml();
            }

            if (sizeof($libs) == 1) {
              ?>
                <div class="c-button-hold">
                  <a href="">
                    <button class="post-btn closePost" style="float: right">VIEW</button>
                  </a>
                </div>
              <?php
            }
          ?>
        </div>
      </div>
    <?php
  }

  public function printActivityHtml() {
    ?>
    <div class="exp-card-block">
      <div class="exp-card-square">
        <i class="material-icons card-icon">
        library_books
        </i>
      </div>
      <h1 class="card-library-title"><?=$this->name?></h1>
    </div>
    <?php
  }

}
 ?>
