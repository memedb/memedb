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

  <div class="sidenav-ec">
      <div class="scroll-hide">
        <h1 class="ec-logo">memedb</h1>

        <div class="section-dark">
          <div class="s-txt ec">
            BALANCE <span class="balance-span">24,789db</span>
          </div>
        </div>

        <div class="sections">
          <div class="line ec"></div>

          <div class="section-dark">
            <div class="s-txt ec">
              HOME
            </div>
          </div>

          <div class="section-dark">
            <div class="s-txt ec">
              RECOMMENDED
            </div>
          </div>

          <div class="section-dark">
            <div class="s-txt ec highlighted">
              DB ECONOMY
            </div>
          </div>

          <div class="line ec"></div>
        </div>

        <div class="subscriptions">

          <div class="section-dark">
            <div class="s-txt ec highlighted">
              MEME 1
            </div><i class="material-icons ec-icons up">trending_up</i>
          </div>

          <div class="section-dark">
            <div class="s-txt ec">
              MEME 2
            </div><i class="material-icons ec-icons idle">trending_flat</i>
          </div>

          <div class="section-dark">
            <div class="s-txt ec">
              MEME 3
            </div><i class="material-icons ec-icons low">trending_down</i>
          </div>

          <div class="section-dark">
            <div class="s-txt ec">
              MEME
            </div><i class="material-icons ec-icons idle">trending_flat</i>
          </div>

          <div class="section-dark">
            <div class="s-txt ec">
              MEME
            </div><i class="material-icons ec-icons idle">trending_flat</i>
          </div>

          <div class="section-dark">
            <div class="s-txt ec">
              MEME
            </div><i class="material-icons ec-icons idle">trending_flat</i>
          </div>

          <div class="section-dark">
            <div class="s-txt ec">
              MEME
            </div><i class="material-icons ec-icons idle">trending_flat</i>
          </div>

          <div class="section-dark">
            <div class="s-txt ec">
              MEME
            </div><i class="material-icons ec-icons idle">trending_flat</i>
          </div>

          <div class="section-dark">
            <div class="s-txt ec">
              MEME
            </div><i class="material-icons ec-icons idle">trending_flat</i>
          </div>

          <div class="section-dark">
            <div class="s-txt ec">
              MEME
            </div><i class="material-icons ec-icons idle">trending_flat</i>
          </div>

          <div class="section-dark">
            <div class="s-txt ec">
              MEME
            </div><i class="material-icons ec-icons idle">trending_flat</i>
          </div>

          <div class="section-dark">
            <div class="s-txt ec">
              MEME
            </div><i class="material-icons ec-icons idle">trending_flat</i>
          </div>

          <div class="section-dark">
            <div class="s-txt ec">
              MEME
            </div><i class="material-icons ec-icons idle">trending_flat</i>
          </div>

          <div class="section-dark">
            <div class="s-txt ec">
              MEME
            </div><i class="material-icons ec-icons idle">trending_flat</i>
          </div>

          <div class="section-dark">
            <div class="s-txt ec">
              MEME
            </div><i class="material-icons ec-icons idle">trending_flat</i>
          </div>

          <div class="section-dark">
            <div class="s-txt ec">
              MEME
            </div><i class="material-icons ec-icons idle">trending_flat</i>
          </div>

          <div class="section-dark">
            <div class="s-txt ec">
              MEME
            </div><i class="material-icons ec-icons idle">trending_flat</i>
          </div>

          <div class="section-dark">
            <div class="s-txt ec">
              MEME
            </div><i class="material-icons ec-icons idle">trending_flat</i>
          </div>

          <div class="section-dark">
            <div class="s-txt ec">
              MEME
            </div><i class="material-icons ec-icons idle">trending_flat</i>
          </div>

          <div class="section-dark">
            <div class="s-txt ec">
              MEME
            </div><i class="material-icons ec-icons idle">trending_flat</i>
          </div>

          <div class="section-dark">
            <div class="s-txt ec">
              MEME
            </div><i class="material-icons ec-icons idle">trending_flat</i>
          </div>

          <div class="section-dark">
            <div class="s-txt ec">
              MEME
            </div><i class="material-icons ec-icons idle">trending_flat</i>
          </div>

          <div class="section-dark">
            <div class="s-txt ec">
              MEME
            </div><i class="material-icons ec-icons idle">trending_flat</i>
          </div>

          <div class="section-dark">
            <div class="s-txt ec">
              MEME
            </div><i class="material-icons ec-icons idle">trending_flat</i>
          </div>

          <div class="section-dark">
            <div class="s-txt ec">
              MEME
            </div><i class="material-icons ec-icons idle">trending_flat</i>
          </div>

          <div class="section-dark">
            <div class="s-txt ec">
              MEME
            </div><i class="material-icons ec-icons idle">trending_flat</i>
          </div>

          <div class="section-dark">
            <div class="s-txt ec">
              MEME
            </div><i class="material-icons ec-icons idle">trending_flat</i>
          </div>

          <div class="section-dark">
            <div class="s-txt ec">
              MEME
            </div><i class="material-icons ec-icons idle">trending_flat</i>
          </div>

          <div class="section-dark">
            <div class="s-txt ec">
              MEME
            </div><i class="material-icons ec-icons idle">trending_flat</i>
          </div>

          <div class="section-dark">
            <div class="s-txt ec">
              MEME
            </div><i class="material-icons ec-icons idle">trending_flat</i>
          </div>

          <div class="section-dark">
            <div class="s-txt ec">
              MEME
            </div><i class="material-icons ec-icons idle">trending_flat</i>
          </div>

          <div class="section-dark">
            <div class="s-txt ec">
              MEME
            </div><i class="material-icons ec-icons idle">trending_flat</i>
          </div>

          <div class="section-dark">
            <div class="s-txt ec">
              MEME
            </div><i class="material-icons ec-icons idle">trending_flat</i>
          </div>

          <div class="section-dark">
            <div class="s-txt ec">
              MEME
            </div><i class="material-icons ec-icons idle">trending_flat</i>
          </div>

          <div class="section-dark">
            <div class="s-txt ec">
              MEME
            </div><i class="material-icons ec-icons idle">trending_flat</i>
          </div>

          <div class="section-dark">
            <div class="s-txt ec">
              MEME
            </div><i class="material-icons ec-icons idle">trending_flat</i>
          </div>

          <div class="section-dark">
            <div class="s-txt ec">
              MEME
            </div><i class="material-icons ec-icons idle">trending_flat</i>
          </div>

          <div class="section-dark">
            <div class="s-txt ec">
              MEME
            </div><i class="material-icons ec-icons idle">trending_flat</i>
          </div>

          <div class="section-dark">
            <div class="s-txt ec">
              MEME
            </div><i class="material-icons ec-icons idle">trending_flat</i>
          </div>

          <div class="section-dark">
            <div class="s-txt ec">
              MEME
            </div><i class="material-icons ec-icons idle">trending_flat</i>
          </div>

          <div class="section-dark">
            <div class="s-txt ec">
              MEME
            </div><i class="material-icons ec-icons idle">trending_flat</i>
          </div>

          <div class="section-dark">
            <div class="s-txt ec">
              MEME
            </div><i class="material-icons ec-icons idle">trending_flat</i>
          </div>

          <div class="section-dark">
            <div class="s-txt ec">
              MEME
            </div><i class="material-icons ec-icons idle">trending_flat</i>
          </div>

          <div class="section-dark">
            <div class="s-txt ec">
              MEME
            </div><i class="material-icons ec-icons idle">trending_flat</i>
          </div>

          <div class="section-dark">
            <div class="s-txt ec">
              MEME
            </div><i class="material-icons ec-icons idle">trending_flat</i>
          </div>

          <div class="section-dark">
            <div class="s-txt ec">
              MEME
            </div><i class="material-icons ec-icons idle">trending_flat</i>
          </div>

          <div class="section-dark">
            <div class="s-txt ec">
              MEME
            </div><i class="material-icons ec-icons idle">trending_flat</i>
          </div>

          <div class="section-dark">
            <div class="s-txt ec">
              MEME
            </div><i class="material-icons ec-icons idle">trending_flat</i>
          </div>

          <div class="section-dark">
            <div class="s-txt ec">
              MEME
            </div><i class="material-icons ec-icons idle">trending_flat</i>
          </div>

          <div class="section-dark">
            <div class="s-txt ec">
              MEME
            </div><i class="material-icons ec-icons idle">trending_flat</i>
          </div>

          <div class="section-dark">
            <div class="s-txt ec">
              MEME
            </div><i class="material-icons ec-icons idle">trending_flat</i>
          </div>

          <div class="section-dark">
            <div class="s-txt ec">
              MEME
            </div><i class="material-icons ec-icons idle">trending_flat</i>
          </div>

          <div class="section-dark">
            <div class="s-txt ec">
              MEME
            </div><i class="material-icons ec-icons idle">trending_flat</i>
          </div>

          <div class="section-dark">
            <div class="s-txt ec">
              MEME
            </div><i class="material-icons ec-icons idle">trending_flat</i>
          </div>

          <div class="section-dark">
            <div class="s-txt ec">
              MEME
            </div><i class="material-icons ec-icons idle">trending_flat</i>
          </div>

          <div class="section-dark">
            <div class="s-txt ec">
              MEME
            </div><i class="material-icons ec-icons idle">trending_flat</i>
          </div>

          <div class="section-dark">
            <div class="s-txt ec">
              MEME
            </div><i class="material-icons ec-icons idle">trending_flat</i>
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
  </div> -->

  <div class="h-content ec">

    <div class="ec-top-bar">
      <div class="ec-account-settings">
        <div class="ec-account-info">
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

        <i class="material-icons ec-settings">settings</i>
      </div>

      <div class="ec-searchbar">
        <i class="material-icons search-g" style="float: left; position:relative; top: -4px;">search</i><input type="text" placeholder="Search" style="all: unset; width: 150px;position: relative; left: 11px; color: #646d6d; top: -1.5px;" />
      </div>

    </div>

  <div class="ec-content">


    <div class="ec-title">
      <h1 class="ec-meme-title">MEME TITLE</h1>
      <i class="material-icons ec-icons up large">trending_up</i>
      <h1 class="ec-meme-save">SAVE</h1>
    </div>

    <div class="ec-graph">

    </div>

    <div class="ec-stats-info">
      <div class="ec-invest">
        <h1 class="ec-invest">INVEST</h1>
        <input type="text" placeholder="0.00" class="ec-invest-input" /><span style="font-family: 'Roboto Slab'; font-weight: bold; color: #818c8b; font-size: 25px;    position: relative; top: -6px;">db</span>
      </div>

      <div class="ec-lifetime">
        <h1 class="ec-h-lifetime">Lifetime</h1>
        <div class="lifetime-box">

        </div>
      </div>

    </div>

  </div>

  </div>

</body>

</html>
