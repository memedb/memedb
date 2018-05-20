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
  <title><?php echo $account->name; ?></title>
</head>

<body>

  <div class="imp-bg-fade" id="imp-bg-fade" style="display: none; opacity 0;"></div>

  <div class="l-sett-opt" style="display: none;">
    <button class="l-sett-button">Rename</button>
    <button class="l-sett-button">Info</button>
    <button class="l-sett-button">Settings</button>

    <div class="l-line"></div>

    <button class="l-sett-button" style="color: #f44242;">Delete</button>

  </div>

  <div class="post category-blk addLib">
    <div class="post-header">
      <h1 class="post-title">ADD LIBRARY</h1>
    </div>

    <div class="c-content">
      <form id="libForm">
        <div>
          <div class="input">
            <input id="name" name="name" type="text" placeholder="Name" style="all: unset; width: 100%;position: relative; border-bottom: 2px solid #ddd; margin-top: 10px; cursor: auto;" required/>
          </div>
        </div>

        <label class="container">Private
          <label class="switch">
            <input type="checkbox" name="private">
            <span class="slider round"></span>
          </label>
        </label>

        <h1 class="s-section-title">Visibility</h1>

        <label class="container">Everyone
          <input type="radio" name="visibility" value="2">
          <span class="radio"></span>
        </label>
        <label class="container">Followers Only
          <input type="radio" name="visibility" checked="checked" value="1">
          <span class="radio"></span>
        </label>
        <label class="container">Only Me
          <input type="radio" name="visibility" value="0">
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
    <button class="imp-op-2" style="color: #f44242;">Delete</button>
    <button class="imp-op-1">Cancel</button>
  </div>

  <div class="floating-box">
    <div class="floating-button openAddLib">
      <i class="material-icons floating">add</i>
    </div>
  </div>

  <div class="s-settings">
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
        <div class="s-c-tab general">
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
              <img src="<?php echo $account->getImage(); ?>" style="border: inherit; border-radius: inherit; z-index: 1000; opacity: .7;" width="80" height="80">
              <p class="i-edit">Edit</p>
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
          <p class="setting-desc">You will need to accept follow requests for people to view your content</p>
          <label class="container">Ghost Account
            <label class="switch">
              <input type="checkbox">
              <span class="slider round"></span>
            </label>
          </label>
          <p class="setting-desc">People won't find you unless they have the link to your account.</p>
          <p class="setting-desc">Upvoting and Sharing posts will be counted but your account will not be linked to them</p>
        </div>
      </div>
    </div>
    <div class="s-bottom-buttons">
      <button class="s-op-1 closeSettings">Cancel</button>
      <button class="s-op-2" style="color: #4167f4;">Save</button>
    </div>
  </div>

  <div class="sidenav-home">
      <div class="scroll-hide">
        <div class="logo-info account">
          <div class="home-logo">
            <a style="all:unset;position: fixed;left: 58px;" href="/">memedb</a>
            <h1 class="l-title tl-post-title">TIMELINE</h1>
            <i class="material-icons expand-sidenav">details</i>
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

        <div class="exp-post-corridor">

          <div class="exp-post">
            <div class="exp-post-image">

            </div>
            <div class="exp-post-info">
              <h6>Title of Post</h6>
              <h2 class="card-date">dd/mm/yyyy</h2>
            </div>
          </div>

          <div class="exp-card long">
            <div class="exp-card-title">
              <h1 class="card-title">+ Cool Pics</h1>
              <h2 class="card-date">dd/mm/yyyy</h2>
            </div>
            <div class="exp-card-content">
              <div class="small-post"></div>
              <div class="small-post"></div>
              <div class="small-post"></div>
              <div class="small-post"></div>
              <div class="small-post"></div>
              <div class="small-post"></div>
              <div class="small-post"></div>
              <div class="small-post"></div>
              <div class="small-post"></div>
              <div class="small-post"></div>
              <div class="small-post"></div>
              <div class="small-post"></div>
              <div class="small-post"></div>
              <div class="small-post"><h1 class="album-text small">+267</h1></div>
            </div>
          </div>

          <!-- ONLY MAKE AN EVENT IS >=5 photos -->

          <div class="exp-card long">
            <div class="exp-card-title">
              <h1 class="card-title">+ Cool Pics</h1>
              <h2 class="card-date">dd/mm/yyyy</h2>
            </div>
            <div class="exp-card-content">
              <div class="small-post"></div>
              <div class="small-post"></div>
              <div class="small-post"></div>
              <div class="small-post"></div>
              <div class="small-post"></div>
            </div>
          </div>

          <div class="exp-card">
            <div class="exp-card-title">
              <h1 class="card-title">+ New Library</h1>
              <h2 class="card-date">dd/mm/yyyy</h2>
            </div>
            <div class="exp-card-content">
              <div class="exp-card-block">
                <div class="exp-card-square">
                  <i class="material-icons card-icon">
                  library_books
                  </i>
                </div>
                <h1 class="card-library-title">Library Name</h1>
              </div>
              <div class="exp-card-block">
                <div class="exp-card-square">
                  <i class="material-icons card-icon">
                  library_books
                  </i>
                </div>
                <h1 class="card-library-title">Library Name</h1>
              </div>
            </div>
          </div>

          <div class="exp-post">
            <div class="exp-post-image">

            </div>
            <div class="exp-post-info">
              <h6>Title of Post</h6>
              <h2 class="card-date">dd/mm/yyyy</h2>
            </div>
          </div>

          <div class="exp-card">
            <div class="exp-card-title">
              <h1 class="card-title">+ New Library</h1>
              <h2 class="card-date">dd/mm/yyyy</h2>
            </div>
            <div class="exp-card-content">
              <div class="exp-card-block">
                <div class="exp-card-square">
                  <i class="material-icons card-icon">
                  library_books
                  </i>
                </div>
                <h1 class="card-library-title">Library Name</h1>
              </div>
              <div class="c-button-hold">
                <button class="post-btn closePost" style="float: right">VIEW</button>
              </div>
            </div>
          </div>

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
        if ($lib->visibility == 2 || ($lib->visibility == 1 && ($self->id == $account->id || $self->isFollowing($account->id))) || ($lib->visibility == 0 && $self->id == $account->id)) {
          ?>
          <div class="library <?=$libCount%2==0?" light":""?>" data-id="<?=$lib->id?>" <?php echo $lib->icon ? $lib->canUpload ? $dragAttr : "" : $dragAttr; ?>>
            <?php
            if ($lib->icon) {
              ?>
              <i class="material-icons l-icon"><?=$lib->icon;?></i>
              <?php
            }
            ?>
            <h1 class="l-title"><?=$lib->name?></h1>

            <div class="l-settings">
              <i class="material-icons">keyboard_arrow_down</i>
            </div>
            <div class="l-drop">
              <i class="material-icons">more_horiz</i>
            </div>
          </div>

          <div class="l-content" style="height: 0px;" data-id="<?=$lib->id?>" ondragenter="libDrag(event);" ondragleave="libDragLeave(event);" ondragover="libDrag(event);" ondrop="libDrop(event);">
            <?php
              $posts = $lib->getPosts();
              foreach ($posts as $post) {
                $post->printImage("l-img");
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
