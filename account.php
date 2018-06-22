<?php
require('api.php');

// The account object being displayed
$account = $_GET['handle'];
// true if the user is looking at their own account false otherwise
$is_self = false;
// The user logged in
$self = getUser();

if ($account != null) {
  $account = user::loadFromHandle($account);
  $is_self = (loggedIn() && $self->id == $account->id);
}

if (loggedIn() && !$account) {
  header("Location: https://meme-db.com/account/" . getUser()->handle);
  exit;
}

if ($account == null) {
  header("Location: https://meme-db.com/login");
  exit;
}
?>

<!DOCTYPE html>
<html>

<head>
  <?php imports(); ?>
  <script>
    var timelinePage = 0;
    var handle = "";
    $(document).ready(function() {
      handle = document.getElementById("data-account").dataset.account;
      loadTimeline(3);
      $(".scroll-hide").scroll(function(event) {
        if(this.scrollTop === (this.scrollHeight - this.offsetHeight)) {
          loadTimeline();
        }
      });
    });

    function loadTimeline(amount) {
      console.log(timelinePage);
      if (timelinePage >= 0) {
        loadPage("/timeline.php?handle=" + handle + "&page=" + timelinePage, function(content) {
          if (content == "null")
            timelinePage = -1;
          else {
            $("#timeline-content").append(content);
            timelinePage++;
            if (amount > 1) {
              loadTimeline(amount - 1);
            }
          }
        });
      }
    }
  </script>
  <title><?php echo $account->name; ?></title>
</head>

<body>

  <div style="display:none;" id="data-account" data-account=<?=$_GET['handle'];?>></div>

  <div class="imp-bg-fade" id="imp-bg-fade" style="display: none; opacity 0;"></div>

  <div class="upload-popup-hover" style="display:none;">
    <div class="upload-popup-bar">
      <h1 class="upload-popup-title">Uploads</h1>
    </div>
    <div class="upload-popup-content" id="uploads">
    </div>
  </div>

  <div class="l-sett-opt" style="display: none;">
    <button class="l-sett-button">Info</button>
    <button onclick="openLibSettings();" class="l-sett-button editable_lib">Settings</button>

    <div class="l-line editable_lib"></div>

    <button onclick="confirmDeleteLib();" class="l-sett-button editable_lib" style="color: #f44242;">Delete</button>

  </div>

  <div class="post category-blk addLib">
    <div class="post-header">
      <h1 class="post-title" id="lib_edit_title">ADD LIBRARY</h1>
    </div>

    <div class="c-content">
      <form id="libForm">
        <div>
          <div class="input">
            <input id="lib_name" name="name" type="text" placeholder="Name" style="all: unset; width: 100%;position: relative; border-bottom: 2px solid #ddd; margin-top: 10px; cursor: auto;" required/>
          </div>
        </div>

        <h1 class="s-section-title">Visibility</h1>

        <label class="container">Everyone
          <input id="lib_visibility_2" type="radio" name="visibility" value="2">
          <span class="radio"></span>
        </label>
        <label class="container">Followers Only
          <input id="lib_visibility_1" type="radio" name="visibility" checked="checked" value="1">
          <span class="radio"></span>
        </label>
        <label class="container">Only Me
          <input id="lib_visibility_0" type="radio" name="visibility" value="0">
          <span class="radio"></span>
        </label>
      </form>
    </div>

    <div class="c-button-hold">
      <button class="c-op-1 closeAddLib">Cancel</button>
      <button class="c-op-2 sendAddLib" style="color: #4167f4;">Add</button>
    </div>
  </div>

  <div class="category-blk stats">
    <div class="c-title-holder">
      <h1 class="imp-title">Statistics</h1>
    </div>

    <div class="c-content">

    </div>

    <div class="c-button-hold">
      <button class="c-op-1 closeStats">Cancel</button>
      <button class="c-op-2" style="color: #4167f4;">Save</button>
    </div>
  </div>

  <div class="category-blk tagFinder">
    <div class="c-title-holder">
      <div class="searchbar category">
        <i class="material-icons search-g" style="float: left; padding-right: 25px;position:relative; top: -4px;">search</i><input type="text" placeholder="Search Tags" style="all: unset; width: 330px;position: relative; left: -10px;" />
      </div>
    </div>

    <div class="c-b-results">
      <div class="c-b-wrapper">
      </div>
    </div>

    <div class="c-button-hold">
      <button class="c-op-1 closeTagSearch">Cancel</button>
      <button class="c-op-2" style="color: #4167f4;">Save</button>
    </div>
  </div>

  <div class="imp-message" id="imp-message" style="display: none; opacity: 0;">
    <div class="imp-title-holder">
      <h1 class="imp-title">Warning!</h1>
    </div>
    <p class="imp-p">Are you sure you want to permanently delete this library and all of its content?</p>
    <button class="imp-op-2" style="color: #f44242;" onclick="deleteLib();">Delete</button>
    <button class="imp-op-1">Cancel</button>
  </div>

  <?php
  if ($is_self) {
  ?>
  <div class="floating-box">
    <div class="floating-button openAddLib">
      <i class="material-icons floating">add</i>
    </div>
  </div>
  <?php
  }
  ?>

  <?php settingsMenu(); ?>

  <div class="sidenav-home">
      <div class="scroll-hide">
        <div class="logo-info account">
          <div class="home-logo">
            <a style="all:unset;position: fixed;left: 58px;" href="/home.php">memedb</a>
            <h1 class="l-title tl-post-title">TIMELINE</h1>
            <i class="material-icons expand-sidenav hoverable-sidenav">details</i>
          </div>

          <div class="sections slim">

            <div class="line h"></div>

            <div class="account-wrapper">
              <div class="account-info" style="float: none; margin-top: 0px;">
                <div class="sd-img">
                  <img src="<?= $account->getImage(); ?>" style="border: inherit; border-radius: inherit;" width="40" height="40">
                </div>
                <div class="sd-infoholder">
                  <h1 class="n-name sdname"><?= $account->name; ?></h1>
                  <div class="username">
                    @<?= $account->handle; ?>
                  </div>
                </div>
              </div>
              <div class="account-para">
                <?=$account->description;?>
              </div>
              <button id="follow-btn" onclick="followAction()" data-handle="<?= $account->handle?>" class="<?php echo ($is_self ? "follow-self" : ($self->isFollowing($account->id) ? "unfollow" : "follow")) ?>">
                <span><?= $account->getFormattedFollowerCount(); ?></span>
              </button>
            </div>

            <div class="line h"></div>

          </div>

          <div class="sections slim">

            <div class="section-light imp-info">
              <div class="s-txt a">
                <a style="all:unset;" href="/home.php">HOME</a>
              </div>
            </div>

            <div class="section-light imp-info">
              <div class="s-txt a">
                <a style="all:unset;" href="/recommended.php">RECOMMENDED</a>
              </div>
            </div>

            <div class="section-light imp-info">
              <div class="s-txt highlighted a">
                <a style="all:unset;" href="/account.php">MY ACCOUNT</a>
              </div>
            </div>

            <div class="line h"></div>
          </div>

        </div>

        <div id="timeline-content" class="exp-post-corridor">
        </div>

      </div>
  </div>

  <div id="home-content" class="home-content">
    <?php
    topBar($self);

    $libs = library::loadFromUser($account);
    $libCount = 0;
    $dragAttr = "ondragenter='libDrag(event);' ondragleave='libDragLeave(event);' ondragover='libDrag(event);' ondrop='libDrop(event);'";
    foreach ($libs as $lib) {
        if ((!$lib->private || $is_self) || $lib->visibility == 2 || ($lib->visibility == 1 && ($self->id == $account->id || $self->isFollowing($account->id))) || ($lib->visibility == 0 && $self->id == $account->id)) {
          ?>
          <div class="library <?=$libCount%2==0?" light":""?>" data-id="<?=$lib->id?>" <?php echo $lib->icon ? $lib->canUpload ? $dragAttr : "" : $dragAttr; ?>>
            <?php
            if ($lib->icon) { // icon is a boolean - should icons be loaded
              ?>
              <i class="material-icons l-icon"><?=$lib->icon;?></i>
              <?php
            }
            $posts = $lib->getPosts(); // Array of post in that library

            if(!$lib->icon){
              if($lib->visibility == 0){
                ?><i class="material-icons l-icon" title="Only You can see this">lock</i><?php
              } elseif ($lib->visibility == 1) {
                ?><i class="material-icons l-icon" title="Only Followers can see this">lock_open</i><?php
              } elseif ($lib->visibility == 2) {
                ?><i class="material-icons l-icon" title="Everyone can see this">visibility</i><?php
              }
            }
             ?>
            <h1 class="l-title"><?=$lib->name?></h1>

            <div class="l-settings">
              <i class="material-icons hoverable">keyboard_arrow_down</i>
            </div>
            <div class="l-drop">
              <i class="material-icons hoverable">more_horiz</i>
            </div>
          </div>

          <div class=" l-content <?=sizeof($posts) == 0?"empty-library":""?>" style="height: 0px;" data-id="<?=$lib->id?>" ondragenter="libDrag(event);" ondragleave="libDragLeave(event);" ondragover="libDrag(event);" ondrop="libDrop(event);">
            <?php
              foreach ($posts as $post) {
                $post->printImage("l-img", true, 100);
              }

              if(sizeof($posts) == 0 && !$lib->icon) {
                ?>
                  <div class="empty-library-content">
                    <i class="material-icons empty-library-icon">add_photo_alternate</i>
                    <h1 class="empty-library-title">Start adding Images, Gifs - Just Drag & Drop</h1>
                  </div>
                <?php
              }
            ?>
          </div>
          <?php
          $libCount++;



        }
    }
    ?>

  </div>

</body>

</html>
