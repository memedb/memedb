<?php
require('api.php');

$account = $_GET['id'];

if ($account != null)
  $account = user::loadFromId($account);

if (loggedIn() && !$account) {
  $account = getUser();
}

if ($account == null)
  header("Location: https://meme-db.com");
?>

<!DOCTYPE html>
<html>

<head>
  <?php imports(); ?>
  <link rel="icon" href="https://i.imgur.com/h0t0THj.png" type="image" sizes="16x16">
  <title>memedb</title>
</head>

<body>

  <div class="top-bar">
    <div class="logo">memedb</div>
    <div class="searchbar">
      <i class="material-icons search-g" style="float: left; padding-right: 25px;position:relative; top: -4px;">search</i><input type="text" placeholder="Search" style="all: unset; width: 150px;position: relative; left: 11px;" />

      <div class="search-result-box" style="display:none;">
        <div class="search-op">
          <p class="res-p">This is option 1</p>
        </div>
        <div class="search-op">
          <p class="res-p">This is option 2</p>
        </div>
        <div class="search-op">
          <p class="res-p">This is option 3</p>
        </div>
        <div class="search-op">
          <p class="res-p">This is option 1</p>
        </div>
        <div class="search-op">
          <p class="res-p">This is option 2</p>
        </div>
        <div class="search-op">
          <p class="res-p">This is option 3</p>
        </div>
      </div>

      <div class="search-featured-box" style="display:none;">
        <h1>Featured Users</h1>
        <div class="s-box-holder">
          <div class="s-box">

          </div>
          <div class="s-box">

          </div>
          <div class="s-box">

          </div>
          <div class="s-box">

          </div>
          <div class="s-box">

          </div>
          <div class="s-box">

          </div>
          <div class="s-box">

          </div>
          <div class="s-box">

          </div>
          <div class="s-box">

          </div>
        </div>
      </div>

    </div>
    <div class="sign-in">SIGN IN</div>
  </div>

  <div class="imp-bg-fade" id="imp-bg-fade" style="display: none; opacity 0;"></div>

  <div class="l-sett-opt" style="display: none;">
    <button class="l-sett-button">Rename</button>
    <button class="l-sett-button">Info</button>
    <button class="l-sett-button">Settings</button>

    <div class="l-line"></div>

    <button class="l-sett-button" style="color: #f44242;">Delete</button>

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

  <div class="category-blk sharing">
    <div class="c-title-holder">
      <h1 class="imp-title">Sharing</h1>
    </div>

    <div class="c-content">

    </div>

    <div class="c-button-hold">
      <button class="c-op-1 closeSharing">Cancel</button>
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
        <div class="c-result">
          <h1 class="c-r-title">Tag Name</h1>
          <div class="type c">+</div>
        </div>
        <div class="c-result">
          <h1 class="c-r-title">Tag Name</h1>
          <div class="type c">+</div>
        </div>
        <div class="c-result">
          <h1 class="c-r-title">Tag Name</h1>
          <div class="type c">+</div>
        </div>
        <div class="c-result">
          <h1 class="c-r-title">Tag Name</h1>
          <div class="type c">+</div>
        </div>
        <div class="c-result">
          <h1 class="c-r-title">Tag Name</h1>
          <div class="type c">+</div>
        </div>
        <div class="c-result">
          <h1 class="c-r-title">Tag Name</h1>
          <div class="type c">+</div>
        </div>
        <div class="c-result">
          <h1 class="c-r-title">Tag Name</h1>
          <div class="type c">+</div>
        </div>
        <div class="c-result">
          <h1 class="c-r-title">Tag Name</h1>
          <div class="type c">+</div>
        </div>
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

  <div class="edit-menu">
    <div class="e-add" title="Add Library">
      <i class="material-icons edit-icons">add</i>
    </div>
    <div class="e-edit" title="Edit Library">
      <i class="material-icons edit-icons">edit</i>
    </div>
    <div class="e-fs" title="Share Library">
      <i class="material-icons edit-icons">folder_shared</i>
    </div>
    <div class="l-line"></div>
    <div class="e-sort" title="Sort by">
      <i class="material-icons edit-icons l-drop">sort</i>
    </div>
    <div class="e-timeln" title="Statistics">
      <i class="material-icons edit-icons openStats">timeline</i>
    </div>
    <div class="e-share" title="Share">
      <i class="material-icons edit-icons openSharing">share</i>
    </div>
    <div class="l-line">
    </div>
    <div class="e-settings" title="Settings">
      <i class="material-icons edit-icons openSettings" >settings</i>
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
        </div>
      </div>
    </div>
    <div class="s-bottom-buttons">
      <button class="s-op-1 closeSettings">Cancel</button>
      <button class="s-op-2" style="color: #4167f4;">Save</button>
    </div>
  </div>

  <div class="sidenav">
    <div class="s-user">
      <div class="user-wrapper">
        <div class="a-user-info">
          <div class="image">
            <img src="<?php echo $account->getImage(); ?>" style="border: inherit; border-radius: inherit;" width="60" height="60">
          </div>
          <div class="name">
            <h1 class="n-name"><?php echo $account->name; ?></h1>
            <div class="username">
              @<?php echo $account->handle; ?>
            </div>
          </div>
          <div class="u-stat">
            <!-- CHANGE NAME LATER -->
            <div class="u-stat karma">
              Karma: 0
            </div>
            <!--  -->
            <div class="u-stat rank">
              Elo: NaN
            </div>
          </div>
        </div>
        <button class="follow">Follow
          <span style="font-family: Roboto;font-weight: 500;color: #ccc;">0
          </span></button>
        <!-- <button class="follow" style="background:#ccc; color:#222;">Unfollow <span style="font-family: Roboto;font-weight: 500;color: #555;">0
        </span></button> -->
      </div>
    </div>

    <div class="s-favorites">
      <div class="fav-holder">
        <div class="div-line"></div>
        <h1 class="div-text">Favorites</h1>
        <div class="div-line"></div>
      </div>

      <div class="meme-type">
        <div class="type">META IRONIC<button class="t-cross">X</button></div>
        <div class="type">IRONIC<button class="t-cross">X</button></div>
        <div class="type">SHITPOSTING<button class="t-cross">X</button></div>
        <div class="type">PHILOSOPHY<button class="t-cross">X</button></div>
        <div class="type">DEEP FRIED<button class="t-cross">X</button></div>
        <div class="type">REACTION IMAGES<button class="t-cross">X</button></div>
        <div class="type">CURSED IMAGES<button class="t-cross">X</button></div>
        <div class="type">NONSENSICAL<button class="t-cross">X</button></div>
        <button class="t-add openTagSearch">+</button>
      </div>

      <div class="line" style="margin-top: 0;"></div>
    </div>

    <div class="s-searchbox">
      <div class="s-searchbar">
        <i class="material-icons seach-g" style="float: left;position:relative; top: -1px; color: #666;">search</i><input type="text" placeholder="Search User" style="all: unset; width: 88.5%;position: relative; left: 11px; border-bottom: 2px solid #ddd;"
        />
      </div>
    </div>


    <div class="s-results">
      <div class="s-r-scroll">
        <div class="s-margin">
          <div class="h-post-row">
            <div class="h-post tiny">
              <div class="h-post-info tiny">
                <div class="h-more">
                  <i class="material-icons" style="font-size: 18px; top: -7.5px;">more_horiz</i>
                </div>
              </div>
            </div>

            <div class="h-post tiny">
              <div class="h-post-info tiny">
                <div class="h-more">
                  <i class="material-icons" style="font-size: 18px; top: -7.5px;">more_horiz</i>
                </div>
              </div>
            </div>

            <div class="h-post tiny">
              <div class="h-post-info tiny">
                <div class="h-more">
                  <i class="material-icons" style="font-size: 18px; top: -7.5px;">more_horiz</i>
                </div>
              </div>
            </div>
          </div>

          <div class="h-post-row">
            <div class="h-post tiny">
              <div class="h-post-info tiny">
                <div class="h-more">
                  <i class="material-icons" style="font-size: 18px; top: -7.5px;">more_horiz</i>
                </div>
              </div>
            </div>

            <div class="h-post tiny">
              <div class="h-post-info tiny">
                <div class="h-more">
                  <i class="material-icons" style="font-size: 18px; top: -7.5px;">more_horiz</i>
                </div>
              </div>
            </div>

            <div class="h-post tiny">
              <div class="h-post-info tiny">
                <div class="h-more">
                  <i class="material-icons" style="font-size: 18px; top: -7.5px;">more_horiz</i>
                </div>
              </div>
            </div>
          </div>

          <div class="h-post-row">
            <div class="h-post tiny">
              <div class="h-post-info tiny">
                <div class="h-more">
                  <i class="material-icons" style="font-size: 18px; top: -7.5px;">more_horiz</i>
                </div>
              </div>
            </div>

            <div class="h-post tiny">
              <div class="h-post-info tiny">
                <div class="h-more">
                  <i class="material-icons" style="font-size: 18px; top: -7.5px;">more_horiz</i>
                </div>
              </div>
            </div>

            <div class="h-post tiny">
              <div class="h-post-info tiny">
                <div class="h-more">
                  <i class="material-icons" style="font-size: 18px; top: -7.5px;">more_horiz</i>
                </div>
              </div>
            </div>
          </div>

          <div class="h-post-row">
            <div class="h-post tiny">
              <div class="h-post-info tiny">
                <div class="h-more">
                  <i class="material-icons" style="font-size: 18px; top: -7.5px;">more_horiz</i>
                </div>
              </div>
            </div>

            <div class="h-post tiny">
              <div class="h-post-info tiny">
                <div class="h-more">
                  <i class="material-icons" style="font-size: 18px; top: -7.5px;">more_horiz</i>
                </div>
              </div>
            </div>

            <div class="h-post tiny">
              <div class="h-post-info tiny">
                <div class="h-more">
                  <i class="material-icons" style="font-size: 18px; top: -7.5px;">more_horiz</i>
                </div>
              </div>
            </div>
          </div>

          <div class="h-post-row">
            <div class="h-post tiny">
              <div class="h-post-info tiny">
                <div class="h-more">
                  <i class="material-icons" style="font-size: 18px; top: -7.5px;">more_horiz</i>
                </div>
              </div>
            </div>

            <div class="h-post tiny">
              <div class="h-post-info tiny">
                <div class="h-more">
                  <i class="material-icons" style="font-size: 18px; top: -7.5px;">more_horiz</i>
                </div>
              </div>
            </div>

            <div class="h-post tiny">
              <div class="h-post-info tiny">
                <div class="h-more">
                  <i class="material-icons" style="font-size: 18px; top: -7.5px;">more_horiz</i>
                </div>
              </div>
            </div>
          </div>

          <div class="h-post-row">
            <div class="h-post tiny">
              <div class="h-post-info tiny">
                <div class="h-more">
                  <i class="material-icons" style="font-size: 18px; top: -7.5px;">more_horiz</i>
                </div>
              </div>
            </div>

            <div class="h-post tiny">
              <div class="h-post-info tiny">
                <div class="h-more">
                  <i class="material-icons" style="font-size: 18px; top: -7.5px;">more_horiz</i>
                </div>
              </div>
            </div>

            <div class="h-post tiny">
              <div class="h-post-info tiny">
                <div class="h-more">
                  <i class="material-icons" style="font-size: 18px; top: -7.5px;">more_horiz</i>
                </div>
              </div>
            </div>
          </div>

          <div class="h-post-row">
            <div class="h-post tiny">
              <div class="h-post-info tiny">
                <div class="h-more">
                  <i class="material-icons" style="font-size: 18px; top: -7.5px;">more_horiz</i>
                </div>
              </div>
            </div>

            <div class="h-post tiny">
              <div class="h-post-info tiny">
                <div class="h-more">
                  <i class="material-icons" style="font-size: 18px; top: -7.5px;">more_horiz</i>
                </div>
              </div>
            </div>

            <div class="h-post tiny">
              <div class="h-post-info tiny">
                <div class="h-more">
                  <i class="material-icons" style="font-size: 18px; top: -7.5px;">more_horiz</i>
                </div>
              </div>
            </div>

          </div>

          <div class="h-post-row">
            <div class="h-post tiny">
              <div class="h-post-info tiny">
                <div class="h-more">
                  <i class="material-icons" style="font-size: 18px; top: -7.5px;">more_horiz</i>
                </div>
              </div>
            </div>

            <div class="h-post tiny">
              <div class="h-post-info tiny">
                <div class="h-more">
                  <i class="material-icons" style="font-size: 18px; top: -7.5px;">more_horiz</i>
                </div>
              </div>
            </div>

            <div class="h-post tiny">
              <div class="h-post-info tiny">
                <div class="h-more">
                  <i class="material-icons" style="font-size: 18px; top: -7.5px;">more_horiz</i>
                </div>
              </div>
            </div>
          </div>

          <div class="h-post-row">
            <div class="h-post tiny">
              <div class="h-post-info tiny">
                <div class="h-more">
                  <i class="material-icons" style="font-size: 18px; top: -7.5px;">more_horiz</i>
                </div>
              </div>
            </div>

            <div class="h-post tiny">
              <div class="h-post-info tiny">
                <div class="h-more">
                  <i class="material-icons" style="font-size: 18px; top: -7.5px;">more_horiz</i>
                </div>
              </div>
            </div>

            <div class="h-post tiny">
              <div class="h-post-info tiny">
                <div class="h-more">
                  <i class="material-icons" style="font-size: 18px; top: -7.5px;">more_horiz</i>
                </div>
              </div>
            </div>
          </div>

          <div class="h-post-row">
            <div class="h-post tiny">
              <div class="h-post-info tiny">
                <div class="h-more">
                  <i class="material-icons" style="font-size: 18px; top: -7.5px;">more_horiz</i>
                </div>
              </div>
            </div>

            <div class="h-post tiny">
              <div class="h-post-info tiny">
                <div class="h-more">
                  <i class="material-icons" style="font-size: 18px; top: -7.5px;">more_horiz</i>
                </div>
              </div>
            </div>

            <div class="h-post tiny">
              <div class="h-post-info tiny">
                <div class="h-more">
                  <i class="material-icons" style="font-size: 18px; top: -7.5px;">more_horiz</i>
                </div>
              </div>
            </div>
          </div>

          <div class="h-post-row">
            <div class="h-post tiny">
              <div class="h-post-info tiny">
                <div class="h-more">
                  <i class="material-icons" style="font-size: 18px; top: -7.5px;">more_horiz</i>
                </div>
              </div>
            </div>

            <div class="h-post tiny">
              <div class="h-post-info tiny">
                <div class="h-more">
                  <i class="material-icons" style="font-size: 18px; top: -7.5px;">more_horiz</i>
                </div>
              </div>
            </div>

            <div class="h-post tiny">
              <div class="h-post-info tiny">
                <div class="h-more">
                  <i class="material-icons" style="font-size: 18px; top: -7.5px;">more_horiz</i>
                </div>
              </div>
            </div>
          </div>

          <div class="h-post-row">
            <div class="h-post tiny">
              <div class="h-post-info tiny">
                <div class="h-more">
                  <i class="material-icons" style="font-size: 18px; top: -7.5px;">more_horiz</i>
                </div>
              </div>
            </div>

            <div class="h-post tiny">
              <div class="h-post-info tiny">
                <div class="h-more">
                  <i class="material-icons" style="font-size: 18px; top: -7.5px;">more_horiz</i>
                </div>
              </div>
            </div>

            <div class="h-post tiny">
              <div class="h-post-info tiny">
                <div class="h-more">
                  <i class="material-icons" style="font-size: 18px; top: -7.5px;">more_horiz</i>
                </div>
              </div>
            </div>
          </div>
        </div>

      </div>
    </div>
  </div>

  <div class="content">
    <div class="c-box">
      <h1 style="margin-left: 20px; font-weight: 200; font-family: 'Roboto', sans-serif;">Most Popular</h1>
      <div class="c-popular">
        <div class="c-pop-wrapper">
          <div class="h-post small">
            <div class="h-post-info">
              <div class="h-icon">
                <i class="material-icons" style="font-size: 18px; top: 5px;">keyboard_arrow_up</i>
              </div>
              <div class="h-p-stat" title="16472">
                16K
              </div>
              <div class="h-icon">
                <i class="material-icons black" style="font-size: 18px; top: 5px;font-weight: 600;">repeat</i>
              </div>
              <div class="h-p-stat">
                4K
              </div>
              <div class="h-more">
                <i class="material-icons" style="font-size: 18px; top: -3px;">more_horiz</i>
              </div>
            </div>
          </div>
          <div class="h-post small">
            <div class="h-post-info">
              <div class="h-icon">
                <i class="material-icons" style="font-size: 18px; top: 5px;">keyboard_arrow_up</i>
              </div>
              <div class="h-p-stat">
                16K
              </div>
              <div class="h-icon">
                <i class="material-icons black" style="font-size: 18px; top: 5px;font-weight: 600;">repeat</i>
              </div>
              <div class="h-p-stat">
                4K
              </div>
              <div class="h-more">
                <i class="material-icons" style="font-size: 18px; top: -3px;">more_horiz</i>
              </div>
            </div>
          </div>
          <div class="h-post small">
            <div class="h-post-info">
              <div class="h-icon">
                <i class="material-icons" style="font-size: 18px; top: 5px;">keyboard_arrow_up</i>
              </div>
              <div class="h-p-stat">
                16K
              </div>
              <div class="h-icon">
                <i class="material-icons black" style="font-size: 18px; top: 5px;font-weight: 600;">repeat</i>
              </div>
              <div class="h-p-stat">
                4K
              </div>
              <div class="h-more">
                <i class="material-icons" style="font-size: 18px; top: -3px;">more_horiz</i>
              </div>
            </div>
          </div>
          <div class="h-post small">
            <div class="h-post-info">
              <div class="h-icon">
                <i class="material-icons" style="font-size: 18px; top: 5px;">keyboard_arrow_up</i>
              </div>
              <div class="h-p-stat">
                16K
              </div>
              <div class="h-icon">
                <i class="material-icons black" style="font-size: 18px; top: 5px;font-weight: 600;">repeat</i>
              </div>
              <div class="h-p-stat">
                4K
              </div>
              <div class="h-more">
                <i class="material-icons" style="font-size: 18px; top: -3px;">more_horiz</i>
              </div>
            </div>
          </div>
          <div class="h-post small">
            <div class="h-post-info">
              <div class="h-icon">
                <i class="material-icons" style="font-size: 18px; top: 5px;">keyboard_arrow_up</i>
              </div>
              <div class="h-p-stat">
                16K
              </div>
              <div class="h-icon">
                <i class="material-icons black" style="font-size: 18px; top: 5px;font-weight: 600;">repeat</i>
              </div>
              <div class="h-p-stat">
                4K
              </div>
              <div class="h-more">
                <i class="material-icons" style="font-size: 18px; top: -3px;">more_horiz</i>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>

    <div class="library l-l1">
      <i class="material-icons l-icon">photo_library</i>
      <h1 class="l-title">Posts</h1>

      <div class="l-settings">
        <i class="material-icons">keyboard_arrow_down</i>
      </div>
      <div class="l-drop">
        <i class="material-icons">more_horiz</i>
      </div>
    </div>
    <div class="l-content" style="height: 0px;">
      <div class="l-img"></div>
      <div class="l-img"></div>
      <div class="l-img"></div>
      <div class="l-img"></div>
      <div class="l-img"></div>
      <div class="l-img"></div>
      <div class="l-img"></div>
      <div class="l-img"></div>
      <div class="l-img"></div>
      <div class="l-img"></div>
      <div class="l-img"></div>
      <div class="l-img"></div>
      <div class="l-img"></div>
      <div class="l-img"></div>
      <div class="l-img"></div>
      <div class="l-img"></div>
      <div class="l-img"></div>
      <div class="l-img"></div>
      <div class="l-img"></div>
      <div class="l-img"></div>
      <div class="l-img"></div>
      <div class="l-img"></div>
      <div class="l-img"></div>
      <div class="l-img"></div>
      <div class="l-img"></div>
      <div class="l-img"></div>
      <div class="l-img"></div>
      <div class="l-img"></div>
      <div class="l-img"></div>
      <div class="l-img"></div>
      <div class="l-img"></div>
      <div class="l-img"></div>
      <div class="l-img"></div>
      <div class="l-img"></div>
      <div class="l-img"></div>
      <div class="l-img"></div>
      <div class="l-img"></div>
      <div class="l-img"></div>
      <div class="l-img"></div>
      <div class="l-img"></div>
      <div class="l-img"></div>
      <div class="l-img"></div>
      <div class="l-img"></div>
      <div class="l-img"></div>
      <div class="l-img"></div>
      <div class="l-img"></div>
      <div class="l-img"></div>
      <div class="l-img"></div>
      <div class="l-img"></div>
      <div class="l-img"></div>
      <div class="l-img"></div>
      <div class="l-img"></div>
      <div class="l-img"></div>
      <div class="l-img"></div>
      <div class="l-img"></div>
      <div class="l-img"></div>
      <div class="l-img"></div>
      <div class="l-img"></div>
      <div class="l-img"></div>
      <div class="l-img"></div>
      <div class="l-img"></div>
      <div class="l-img"></div>
      <div class="l-img"></div>
      <div class="l-img"></div>
      <div class="l-img"></div>
      <div class="l-img"></div>
      <div class="l-img"></div>
      <div class="l-img"></div>
      <div class="l-img"></div>
      <div class="l-img"></div>
      <div class="l-img"></div>
      <div class="l-img"></div>
      <div class="l-img"></div>
      <div class="l-img"></div>
    </div>

    <div class="library l-l1">
      <i class="material-icons l-icon">repeat</i>
      <h1 class="l-title">Reposts</h1>
      <div class="l-settings">
        <i class="material-icons">keyboard_arrow_down</i>
      </div>
      <div class="l-drop">
        <i class="material-icons">more_horiz</i>
      </div>
    </div>
    <div class="l-content" style="height: 0px;">
      <div class="l-img"></div>
      <div class="l-img"></div>
      <div class="l-img"></div>
      <div class="l-img"></div>
      <div class="l-img"></div>
      <div class="l-img"></div>
      <div class="l-img"></div>
      <div class="l-img"></div>
      <div class="l-img"></div>
      <div class="l-img"></div>
      <div class="l-img"></div>
      <div class="l-img"></div>
      <div class="l-img"></div>
      <div class="l-img"></div>
      <div class="l-img"></div>
      <div class="l-img"></div>
      <div class="l-img"></div>
      <div class="l-img"></div>
      <div class="l-img"></div>
      <div class="l-img"></div>
      <div class="l-img"></div>
      <div class="l-img"></div>
      <div class="l-img"></div>
      <div class="l-img"></div>
      <div class="l-img"></div>
      <div class="l-img"></div>
      <div class="l-img"></div>
      <div class="l-img"></div>
      <div class="l-img"></div>
      <div class="l-img"></div>
      <div class="l-img"></div>
      <div class="l-img"></div>
      <div class="l-img"></div>
      <div class="l-img"></div>
      <div class="l-img"></div>
      <div class="l-img"></div>
      <div class="l-img"></div>
      <div class="l-img"></div>
      <div class="l-img"></div>
      <div class="l-img"></div>
      <div class="l-img"></div>
      <div class="l-img"></div>
      <div class="l-img"></div>
      <div class="l-img"></div>
      <div class="l-img"></div>
      <div class="l-img"></div>
      <div class="l-img"></div>
      <div class="l-img"></div>
      <div class="l-img"></div>
      <div class="l-img"></div>
      <div class="l-img"></div>
      <div class="l-img"></div>
      <div class="l-img"></div>
      <div class="l-img"></div>
      <div class="l-img"></div>
      <div class="l-img"></div>
      <div class="l-img"></div>
      <div class="l-img"></div>
      <div class="l-img"></div>
      <div class="l-img"></div>
      <div class="l-img"></div>
      <div class="l-img"></div>
      <div class="l-img"></div>
      <div class="l-img"></div>
      <div class="l-img"></div>
      <div class="l-img"></div>
      <div class="l-img"></div>
      <div class="l-img"></div>
      <div class="l-img"></div>
      <div class="l-img"></div>
      <div class="l-img"></div>
      <div class="l-img"></div>
      <div class="l-img"></div>
      <div class="l-img"></div>
      <div class="l-img"></div>
      <div class="l-img"></div>
      <div class="l-img"></div>
      <div class="l-img"></div>
      <div class="l-img"></div>
      <div class="l-img"></div>
      <div class="l-img"></div>
      <div class="l-img"></div>
      <div class="l-img"></div>
      <div class="l-img"></div>
    </div>

    <div class="library l-l1">
      <i class="material-icons l-icon">star</i>
      <h1 class="l-title">Favorites</h1>

      <div class="l-settings">
        <i class="material-icons">keyboard_arrow_down</i>
      </div>
      <div class="l-drop">
        <i class="material-icons">more_horiz</i>
      </div>
    </div>
    <div class="l-content" style="height: 0px;">
      <div class="l-img"></div>
      <div class="l-img"></div>
      <div class="l-img"></div>
      <div class="l-img"></div>
      <div class="l-img"></div>
      <div class="l-img"></div>
      <div class="l-img"></div>
      <div class="l-img"></div>
      <div class="l-img"></div>
      <div class="l-img"></div>
      <div class="l-img"></div>
      <div class="l-img"></div>
      <div class="l-img"></div>
      <div class="l-img"></div>
      <div class="l-img"></div>
      <div class="l-img"></div>
      <div class="l-img"></div>
      <div class="l-img"></div>
      <div class="l-img"></div>
      <div class="l-img"></div>
      <div class="l-img"></div>
      <div class="l-img"></div>
      <div class="l-img"></div>
      <div class="l-img"></div>
      <div class="l-img"></div>
      <div class="l-img"></div>
      <div class="l-img"></div>
      <div class="l-img"></div>
      <div class="l-img"></div>
      <div class="l-img"></div>
      <div class="l-img"></div>
      <div class="l-img"></div>
      <div class="l-img"></div>
      <div class="l-img"></div>
      <div class="l-img"></div>
      <div class="l-img"></div>
      <div class="l-img"></div>
      <div class="l-img"></div>
      <div class="l-img"></div>
      <div class="l-img"></div>
      <div class="l-img"></div>
      <div class="l-img"></div>
      <div class="l-img"></div>
      <div class="l-img"></div>
      <div class="l-img"></div>
      <div class="l-img"></div>
      <div class="l-img"></div>
      <div class="l-img"></div>
      <div class="l-img"></div>
      <div class="l-img"></div>
      <div class="l-img"></div>
      <div class="l-img"></div>
      <div class="l-img"></div>
      <div class="l-img"></div>
      <div class="l-img"></div>
      <div class="l-img"></div>
      <div class="l-img"></div>
      <div class="l-img"></div>
      <div class="l-img"></div>
      <div class="l-img"></div>
      <div class="l-img"></div>
      <div class="l-img"></div>
      <div class="l-img"></div>
      <div class="l-img"></div>
      <div class="l-img"></div>
      <div class="l-img"></div>
      <div class="l-img"></div>
      <div class="l-img"></div>
      <div class="l-img"></div>
      <div class="l-img"></div>
      <div class="l-img"></div>
      <div class="l-img"></div>
      <div class="l-img"></div>
      <div class="l-img"></div>
    </div>


    <div class="library">
      <h1 class="l-title">Library</h1>

      <div class="l-settings">
        <i class="material-icons">keyboard_arrow_down</i>
      </div>
      <div class="l-drop">
        <i class="material-icons">more_horiz</i>
      </div>
    </div>
    <div class="l-content" style="height: 0px;">
      <div class="l-img"></div>
      <div class="l-img"></div>
      <div class="l-img"></div>
      <div class="l-img"></div>
      <div class="l-img"></div>
      <div class="l-img"></div>
      <div class="l-img"></div>
      <div class="l-img"></div>
      <div class="l-img"></div>
      <div class="l-img"></div>
      <div class="l-img"></div>
      <div class="l-img"></div>
      <div class="l-img"></div>
      <div class="l-img"></div>
      <div class="l-img"></div>
      <div class="l-img"></div>
      <div class="l-img"></div>
      <div class="l-img"></div>
      <div class="l-img"></div>
      <div class="l-img"></div>
      <div class="l-img"></div>
      <div class="l-img"></div>
      <div class="l-img"></div>
      <div class="l-img"></div>
      <div class="l-img"></div>
      <div class="l-img"></div>
      <div class="l-img"></div>
      <div class="l-img"></div>
      <div class="l-img"></div>
      <div class="l-img"></div>
      <div class="l-img"></div>
      <div class="l-img"></div>
      <div class="l-img"></div>
      <div class="l-img"></div>
      <div class="l-img"></div>
      <div class="l-img"></div>
      <div class="l-img"></div>
      <div class="l-img"></div>
      <div class="l-img"></div>
      <div class="l-img"></div>
      <div class="l-img"></div>
      <div class="l-img"></div>
      <div class="l-img"></div>
      <div class="l-img"></div>
      <div class="l-img"></div>
      <div class="l-img"></div>
      <div class="l-img"></div>
      <div class="l-img"></div>
      <div class="l-img"></div>
      <div class="l-img"></div>
      <div class="l-img"></div>
      <div class="l-img"></div>
      <div class="l-img"></div>
      <div class="l-img"></div>
      <div class="l-img"></div>
      <div class="l-img"></div>
      <div class="l-img"></div>
      <div class="l-img"></div>
      <div class="l-img"></div>
      <div class="l-img"></div>
      <div class="l-img"></div>
      <div class="l-img"></div>
      <div class="l-img"></div>
      <div class="l-img"></div>
      <div class="l-img"></div>
      <div class="l-img"></div>
      <div class="l-img"></div>
      <div class="l-img"></div>
      <div class="l-img"></div>
      <div class="l-img"></div>
      <div class="l-img"></div>
      <div class="l-img"></div>
      <div class="l-img"></div>
      <div class="l-img"></div>
    </div>

    <div class="library">
      <h1 class="l-title">Library</h1>

      <div class="l-settings">
        <i class="material-icons">keyboard_arrow_down</i>
      </div>
      <div class="l-drop">
        <i class="material-icons">more_horiz</i>
      </div>
    </div>
    <div class="l-content" style="height: 0px;">
      <div class="l-img"></div>
      <div class="l-img"></div>
      <div class="l-img"></div>
      <div class="l-img"></div>
      <div class="l-img"></div>
      <div class="l-img"></div>
      <div class="l-img"></div>
      <div class="l-img"></div>
      <div class="l-img"></div>
      <div class="l-img"></div>
      <div class="l-img"></div>
      <div class="l-img"></div>
      <div class="l-img"></div>
      <div class="l-img"></div>
      <div class="l-img"></div>
      <div class="l-img"></div>
      <div class="l-img"></div>
      <div class="l-img"></div>
      <div class="l-img"></div>
      <div class="l-img"></div>
      <div class="l-img"></div>
      <div class="l-img"></div>
      <div class="l-img"></div>
      <div class="l-img"></div>
      <div class="l-img"></div>
      <div class="l-img"></div>
      <div class="l-img"></div>
      <div class="l-img"></div>
      <div class="l-img"></div>
      <div class="l-img"></div>
      <div class="l-img"></div>
      <div class="l-img"></div>
      <div class="l-img"></div>
      <div class="l-img"></div>
      <div class="l-img"></div>
      <div class="l-img"></div>
      <div class="l-img"></div>
      <div class="l-img"></div>
      <div class="l-img"></div>
      <div class="l-img"></div>
      <div class="l-img"></div>
      <div class="l-img"></div>
      <div class="l-img"></div>
      <div class="l-img"></div>
      <div class="l-img"></div>
      <div class="l-img"></div>
      <div class="l-img"></div>
      <div class="l-img"></div>
      <div class="l-img"></div>
      <div class="l-img"></div>
      <div class="l-img"></div>
      <div class="l-img"></div>
      <div class="l-img"></div>
      <div class="l-img"></div>
      <div class="l-img"></div>
      <div class="l-img"></div>
      <div class="l-img"></div>
      <div class="l-img"></div>
      <div class="l-img"></div>
      <div class="l-img"></div>
      <div class="l-img"></div>
      <div class="l-img"></div>
      <div class="l-img"></div>
      <div class="l-img"></div>
      <div class="l-img"></div>
      <div class="l-img"></div>
      <div class="l-img"></div>
      <div class="l-img"></div>
      <div class="l-img"></div>
      <div class="l-img"></div>
      <div class="l-img"></div>
      <div class="l-img"></div>
      <div class="l-img"></div>
      <div class="l-img"></div>
    </div>

    <div class="library">
      <h1 class="l-title">Selected Library</h1>

      <div class="l-settings">
        <i class="material-icons">keyboard_arrow_down</i>
      </div>
      <div class="l-drop">
        <i class="material-icons">more_horiz</i>
      </div>
    </div>
    <div class="l-content" style="height: 0px;">
      <div class="l-img"></div>
      <div class="l-img"></div>
      <div class="l-img"></div>
      <div class="l-img"></div>
      <div class="l-img"></div>
      <div class="l-img"></div>
      <div class="l-img"></div>
      <div class="l-img"></div>
      <div class="l-img"></div>
      <div class="l-img"></div>
      <div class="l-img"></div>
      <div class="l-img"></div>
      <div class="l-img"></div>
      <div class="l-img"></div>
      <div class="l-img"></div>
      <div class="l-img"></div>
      <div class="l-img"></div>
      <div class="l-img"></div>
      <div class="l-img"></div>
      <div class="l-img"></div>
      <div class="l-img"></div>
      <div class="l-img"></div>
      <div class="l-img"></div>
      <div class="l-img"></div>
      <div class="l-img"></div>
      <div class="l-img"></div>
      <div class="l-img"></div>
      <div class="l-img"></div>
      <div class="l-img"></div>
      <div class="l-img"></div>
      <div class="l-img"></div>
      <div class="l-img"></div>
      <div class="l-img"></div>
      <div class="l-img"></div>
      <div class="l-img"></div>
      <div class="l-img"></div>
      <div class="l-img"></div>
      <div class="l-img"></div>
      <div class="l-img"></div>
      <div class="l-img"></div>
      <div class="l-img"></div>
      <div class="l-img"></div>
      <div class="l-img"></div>
      <div class="l-img"></div>
      <div class="l-img"></div>
      <div class="l-img"></div>
      <div class="l-img"></div>
      <div class="l-img"></div>
      <div class="l-img"></div>
      <div class="l-img"></div>
      <div class="l-img"></div>
      <div class="l-img"></div>
      <div class="l-img"></div>
      <div class="l-img"></div>
      <div class="l-img"></div>
      <div class="l-img"></div>
      <div class="l-img"></div>
      <div class="l-img"></div>
      <div class="l-img"></div>
      <div class="l-img"></div>
      <div class="l-img"></div>
      <div class="l-img"></div>
      <div class="l-img"></div>
      <div class="l-img"></div>
      <div class="l-img"></div>
      <div class="l-img"></div>
      <div class="l-img"></div>
      <div class="l-img"></div>
      <div class="l-img"></div>
      <div class="l-img"></div>
      <div class="l-img"></div>
      <div class="l-img"></div>
      <div class="l-img"></div>
      <div class="l-img"></div>
    </div>

    <div class="library">
      <h1 class="l-title">Library</h1>

      <div class="l-settings">
        <i class="material-icons">keyboard_arrow_down</i>
      </div>
      <div class="l-drop">
        <i class="material-icons">more_horiz</i>
      </div>
    </div>
    <div class="l-content" style="height: 0px;">
      <div class="l-img"></div>
      <div class="l-img"></div>
      <div class="l-img"></div>
      <div class="l-img"></div>
      <div class="l-img"></div>
      <div class="l-img"></div>
      <div class="l-img"></div>
      <div class="l-img"></div>
      <div class="l-img"></div>
      <div class="l-img"></div>
      <div class="l-img"></div>
      <div class="l-img"></div>
      <div class="l-img"></div>
      <div class="l-img"></div>
      <div class="l-img"></div>
      <div class="l-img"></div>
      <div class="l-img"></div>
      <div class="l-img"></div>
      <div class="l-img"></div>
      <div class="l-img"></div>
      <div class="l-img"></div>
      <div class="l-img"></div>
      <div class="l-img"></div>
      <div class="l-img"></div>
      <div class="l-img"></div>
      <div class="l-img"></div>
      <div class="l-img"></div>
      <div class="l-img"></div>
      <div class="l-img"></div>
      <div class="l-img"></div>
      <div class="l-img"></div>
      <div class="l-img"></div>
      <div class="l-img"></div>
      <div class="l-img"></div>
      <div class="l-img"></div>
      <div class="l-img"></div>
      <div class="l-img"></div>
      <div class="l-img"></div>
      <div class="l-img"></div>
      <div class="l-img"></div>
      <div class="l-img"></div>
      <div class="l-img"></div>
      <div class="l-img"></div>
      <div class="l-img"></div>
      <div class="l-img"></div>
      <div class="l-img"></div>
      <div class="l-img"></div>
      <div class="l-img"></div>
      <div class="l-img"></div>
      <div class="l-img"></div>
      <div class="l-img"></div>
      <div class="l-img"></div>
      <div class="l-img"></div>
      <div class="l-img"></div>
      <div class="l-img"></div>
      <div class="l-img"></div>
      <div class="l-img"></div>
      <div class="l-img"></div>
      <div class="l-img"></div>
      <div class="l-img"></div>
      <div class="l-img"></div>
      <div class="l-img"></div>
      <div class="l-img"></div>
      <div class="l-img"></div>
      <div class="l-img"></div>
      <div class="l-img"></div>
      <div class="l-img"></div>
      <div class="l-img"></div>
      <div class="l-img"></div>
      <div class="l-img"></div>
      <div class="l-img"></div>
      <div class="l-img"></div>
      <div class="l-img"></div>
      <div class="l-img"></div>
    </div>

    <div class="library">
      <h1 class="l-title">Library</h1>

      <div class="l-settings">
        <i class="material-icons">keyboard_arrow_down</i>
      </div>
      <div class="l-drop">
        <i class="material-icons">more_horiz</i>
      </div>
    </div>
    <div class="l-content" style="height: 0px;">
      <div class="l-img"></div>
      <div class="l-img"></div>
      <div class="l-img"></div>
      <div class="l-img"></div>
      <div class="l-img"></div>
      <div class="l-img"></div>
      <div class="l-img"></div>
      <div class="l-img"></div>
      <div class="l-img"></div>
      <div class="l-img"></div>
      <div class="l-img"></div>
      <div class="l-img"></div>
      <div class="l-img"></div>
      <div class="l-img"></div>
      <div class="l-img"></div>
      <div class="l-img"></div>
      <div class="l-img"></div>
      <div class="l-img"></div>
      <div class="l-img"></div>
      <div class="l-img"></div>
      <div class="l-img"></div>
      <div class="l-img"></div>
      <div class="l-img"></div>
      <div class="l-img"></div>
      <div class="l-img"></div>
      <div class="l-img"></div>
      <div class="l-img"></div>
      <div class="l-img"></div>
      <div class="l-img"></div>
      <div class="l-img"></div>
      <div class="l-img"></div>
      <div class="l-img"></div>
      <div class="l-img"></div>
      <div class="l-img"></div>
      <div class="l-img"></div>
      <div class="l-img"></div>
      <div class="l-img"></div>
      <div class="l-img"></div>
      <div class="l-img"></div>
      <div class="l-img"></div>
      <div class="l-img"></div>
      <div class="l-img"></div>
      <div class="l-img"></div>
      <div class="l-img"></div>
      <div class="l-img"></div>
      <div class="l-img"></div>
      <div class="l-img"></div>
      <div class="l-img"></div>
      <div class="l-img"></div>
      <div class="l-img"></div>
      <div class="l-img"></div>
      <div class="l-img"></div>
      <div class="l-img"></div>
      <div class="l-img"></div>
      <div class="l-img"></div>
      <div class="l-img"></div>
      <div class="l-img"></div>
      <div class="l-img"></div>
      <div class="l-img"></div>
      <div class="l-img"></div>
      <div class="l-img"></div>
      <div class="l-img"></div>
      <div class="l-img"></div>
      <div class="l-img"></div>
      <div class="l-img"></div>
      <div class="l-img"></div>
      <div class="l-img"></div>
      <div class="l-img"></div>
      <div class="l-img"></div>
      <div class="l-img"></div>
      <div class="l-img"></div>
      <div class="l-img"></div>
      <div class="l-img"></div>
      <div class="l-img"></div>
    </div>
  </div>



</body>

</html>
