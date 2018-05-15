<?php
require('api.php');

$account = $_GET['id'];

$is_self = false;
// The user logged in
$self = getUser();

if ($account != null) {
  $account = user::loadFromHandle($account);
  $is_self = (loggedIn() && $self->id == $account->id);
}

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
  <title>memedb</title>

</head>

<body>

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

  <div class="s-dropdown">
    <div class="s-d-titlebox">
      <div class="sd-img">
        <img src="<?php echo $account->getImage(); ?>" style="border: inherit; border-radius: inherit;" width="40" height="40">
      </div>
      <div class="sd-infoholder">
        <h1 class="n-name sdname"><?php echo $account->name; ?></h1>
        <div class="username">
          @<?php echo $account->handle; ?>
        </div>
      </div>
    </div>
    <div class="sd-content">
      <div class="section">
          <i class="material-icons s-icon settings-icon">account_circle</i>
          <div class="s-txt">
            My Account
          </div>
        </div>
        <div class="section">
            <i class="material-icons s-icon settings-icon">group</i>
            <div class="s-txt">
              Switch Accounts
            </div>
        </div>
        <div class="section">
            <i class="material-icons s-icon settings-icon">exit_to_app</i>
            <div class="s-txt">
              Sign Out
            </div>
        </div>
        <div class="long-line"></div>
        <div class="section">
            <i class="material-icons s-icon settings-icon">help</i>
            <div class="s-txt">
              Help
            </div>
        </div>
        <div class="section">
            <i class="material-icons s-icon settings-icon">feedback</i>
            <div class="s-txt">
              Send Feedback
            </div>
        </div>
        <div class="section">
            <i class="material-icons s-icon settings-icon">settings</i>
            <div class="s-txt">
              Settings
            </div>
        </div>
    </div>
  </div>
  <div class="imp-bg-fade" id="imp-bg-fade" style="display: none; opacity 0;"></div>

  <div class="donate-bar" style="display: none;">
    <div class="d-para">Please consider donating to help keep this service shutting down.</div>

    <i class="material-icons black d-icon">clear</i>

    <button class="d-button">Donate w/ Paypal</button>

  </div>

  <div class="s-settings" style="display: none;">
    <div class="s-title-box">
      <h1 class="s-title">Settings</h1>
      <i class="material-icons black s-delete">clear</i>
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
      <button class="s-op-1">Cancel</button>
      <button class="s-op-2" style="color: #4167f4;">Save</button>
    </div>
  </div>

  <div class="sidenav-home">
    <div class="s-scroll">
      <div class="scroll-hide">

        <div class="sections">

          <div class="section">
            <i class="material-icons black s-icon">supervisor_account</i>
            <div class="s-txt">
              Following
            </div>
            <button class="s-notes">+156</button>
          </div>

          <div class="section" style="background: #ddd;">
            <i class="material-icons black s-icon">functions</i>
            <div class="s-txt">
              Recommended
            </div>
          </div>

          <div class="line"></div>
        </div>

        <div class="subscriptions">

          <div class="section">
            <div class="s-avatar"></div>
            <div class="s-txt">
              Will Garrett
            </div>
            <button class="s-notes">4</button>
          </div>

          <div class="section">
            <div class="s-avatar"></div>
            <div class="s-txt">
              Asher Bearce
            </div>
            <button class="s-notes">6</button>
          </div>

          <div class="section">
            <div class="s-avatar"></div>
            <div class="s-txt">
              Bryan Scott
            </div>
          </div>

          <div class="section">
            <div class="s-avatar"></div>
            <div class="s-txt">
              Justin Fernald
            </div>
            <button class="s-notes">99+</button>
          </div>

          <div class="section">
            <div class="s-avatar"></div>
            <div class="s-txt">
              Last one
            </div>
            <button class="s-notes">99+</button>
          </div>

        </div>
      </div>
    </div>
  </div>

  <div class="context" style="display: none;">
    <div class="support">

      <h1 class="s-title">Support Us</h1>

      <div class="s-bar">
        <div class="s-b"></div>
        <div class="s-percent">$100/100</div>
      </div>

      <div class="s-text">
        This service is community funded, and we'll need all the help we can get to keep it going. Thanks for being a part of this awesome community!
      </div>

      <div class="donate">
        <button class="paypal">PAYPAL</button>
      </div>

    </div>


    <h1 class="title">Latest</h1>
  </div>

  <div class="sidenav-home">
      <div class="scroll-hide">
        <div class="logo-info">
          <div class="home-logo"><a style="all:unset;" href="/">memedb</a><i class="material-icons expand-sidenav">details</i></div>

          <div class="sections">

            <div class="line h"></div>

            <div class="account-wrapper">
              <div class="account-info" style="float: none; margin-top: 0px;">
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
              <div class="account-para">
                Founder of memedb
              </div>
              <button class="follow">
                <span>100k</span>
              </button>
            </div>

            <div class="line h"></div>

          </div>
        </div>

        <div class="subscriptions">

        </div>
      </div>
  </div>


  <div class="rec-content">
    <?php
    topBar($self);
     ?>
    <div class="tag-corridor">

      <div class="rec-tag">
        <div class="rt-title">
          <h class="rt-header"1>CURSED IMAGES</h>
          <i class="material-icons rec-icon">bookmark_border</i>
        </div>
        <div class="rt-userbox">

          <div class="userbox-title">
            <div class="m-pp">

            </div>
            <div class="m-names">
              <h1 class="m-OP">Gaetan Almela</h1>
              <h1 class="m-handle">@Al</h1>
            </div>

            <button class="followmp">Follow
              <span style="font-family: Roboto;font-weight: 500;color: #444;">0
              </span></button>
          </div>
          <div class="rt-postchain">
            <div class="rt-post">
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
            <div class="rt-post">
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
            <div class="rt-post">
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
            <div class="rt-post">
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
            <div class="rt-post">
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
            <div class="rt-post">
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
            <div class="rt-post">
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
          </div>

          <div class="userbox-title">
            <div class="m-pp">

            </div>
            <div class="m-names">
              <h1 class="m-OP">Gaetan Almela</h1>
              <h1 class="m-handle">@Al</h1>
            </div>

            <button class="followmp">Follow
              <span style="font-family: Roboto;font-weight: 500;color: #444;">0
              </span></button>
          </div>
          <div class="rt-postchain">
            <div class="rt-post">
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
            <div class="rt-post">
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
            <div class="rt-post">
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
            <div class="rt-post">
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
            <div class="rt-post">
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
            <div class="rt-post">
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
            <div class="rt-post">
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
          </div>

        </div>
        <div class="rt-more">
          <div class="rt-fab">
            <i class="material-icons small-floating">keyboard_arrow_down</i>
          </div>
        </div>
      </div>

      <div class="rec-tag">
        <div class="rt-title">
          <h class="rt-header"1>IRONIC</h>
          <i class="material-icons rec-icon">bookmark_border</i>
        </div>
        <div class="rt-userbox">

          <div class="userbox-title">
            <div class="m-pp">

            </div>
            <div class="m-names">
              <h1 class="m-OP">Gaetan Almela</h1>
              <h1 class="m-handle">@Al</h1>
            </div>

            <button class="followmp">Follow
              <span style="font-family: Roboto;font-weight: 500;color: #444;">0
              </span></button>
          </div>
          <div class="rt-postchain">
            <div class="rt-post">
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
            <div class="rt-post">
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
            <div class="rt-post">
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
            <div class="rt-post">
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
            <div class="rt-post">
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
            <div class="rt-post">
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
            <div class="rt-post">
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
          </div>

          <div class="userbox-title">
            <div class="m-pp">

            </div>
            <div class="m-names">
              <h1 class="m-OP">Gaetan Almela</h1>
              <h1 class="m-handle">@Al</h1>
            </div>

            <button class="followmp">Follow
              <span style="font-family: Roboto;font-weight: 500;color: #444;">0
              </span></button>
          </div>
          <div class="rt-postchain">
            <div class="rt-post">
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
            <div class="rt-post">
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
            <div class="rt-post">
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
            <div class="rt-post">
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
            <div class="rt-post">
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
            <div class="rt-post">
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
            <div class="rt-post">
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
          </div>

        </div>
        <div class="rt-more">
          <div class="rt-fab">
            <i class="material-icons small-floating">keyboard_arrow_down</i>
          </div>
        </div>
      </div>

      <div class="rec-tag">
        <div class="rt-title">
          <h class="rt-header"1>SHITPOSTING</h>
          <i class="material-icons rec-icon">bookmark_border</i>
        </div>
        <div class="rt-userbox">

          <div class="userbox-title">
            <div class="m-pp">

            </div>
            <div class="m-names">
              <h1 class="m-OP">Gaetan Almela</h1>
              <h1 class="m-handle">@Al</h1>
            </div>

            <button class="followmp">Follow
              <span style="font-family: Roboto;font-weight: 500;color: #444;">0
              </span></button>
          </div>
          <div class="rt-postchain">
            <div class="rt-post">
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
            <div class="rt-post">
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
            <div class="rt-post">
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
            <div class="rt-post">
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
            <div class="rt-post">
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
            <div class="rt-post">
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
            <div class="rt-post">
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
          </div>

          <div class="userbox-title">
            <div class="m-pp">

            </div>
            <div class="m-names">
              <h1 class="m-OP">Gaetan Almela</h1>
              <h1 class="m-handle">@Al</h1>
            </div>

            <button class="followmp">Follow
              <span style="font-family: Roboto;font-weight: 500;color: #444;">0
              </span></button>
          </div>
          <div class="rt-postchain">
            <div class="rt-post">
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
            <div class="rt-post">
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
            <div class="rt-post">
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
            <div class="rt-post">
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
            <div class="rt-post">
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
            <div class="rt-post">
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
            <div class="rt-post">
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
          </div>

        </div>
        <div class="rt-more">
          <div class="rt-fab">
            <i class="material-icons small-floating">keyboard_arrow_down</i>
          </div>
        </div>
      </div>

    </div>
  </div>

</body>

</html>
