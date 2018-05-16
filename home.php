<?php
require('api.php');

$account = $_GET['id'];
$self = getUser();

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
  <title>Home</title>

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

  <div class="sidenav-home">
      <div class="scroll-hide">
        <div class="logo-info">
          <div class="home-logo" style="margin-bottom:0px;"><a style="all:unset;" href="/">memedb</a></div>

          <div class="sections">
            <div class="line h"></div>

            <div class="section-light imp-info">
              <div class="s-txt h highlighted">
                <a style="all:unset;" href="/home.php">HOME</a>
              </div>
            </div>

            <div class="section-light imp-info">
              <div class="s-txt h">
                <a style="all:unset;" href="/recommended.php">RECOMMENDED</a>
              </div>
            </div>

            <div class="section-light imp-info">
              <div class="s-txt h">
                <a style="all:unset;" href="/economy.php">DB ECONOMY</a>
              </div>
            </div>

            <div class="line h"></div>
          </div>
        </div>

        <div class="subscriptions">

          <div class="section-light subs">
            <div class="section-avi"></div>
            <div class="s-txt foll">
              Gaetan A.
            </div>
          </div>

          <div class="section-light subs">
            <div class="section-avi"></div>
            <div class="s-txt foll">
              bobmandude9889
            </div>
          </div>

          <div class="section-light subs">
            <div class="section-avi"></div>
            <div class="s-txt foll">
              Ryan Scott
            </div>
          </div>

          <div class="section-light subs">
            <div class="section-avi"></div>
            <div class="s-txt foll">
              Gaetan A.
            </div>
          </div>

          <div class="section-light subs">
            <div class="section-avi"></div>
            <div class="s-txt foll">
              bobmandude9889
            </div>
          </div>

          <div class="section-light subs">
            <div class="section-avi"></div>
            <div class="s-txt foll">
              Ryan Scott
            </div>
          </div>

          <div class="section-light subs">
            <div class="section-avi"></div>
            <div class="s-txt foll">
              Gaetan A.
            </div>
          </div>

          <div class="section-light subs">
            <div class="section-avi"></div>
            <div class="s-txt foll">
              bobmandude9889
            </div>
          </div>

          <div class="section-light subs">
            <div class="section-avi"></div>
            <div class="s-txt foll">
              Ryan Scott
            </div>
          </div>

          <div class="section-light subs">
            <div class="section-avi"></div>
            <div class="s-txt foll">
              Gaetan A.
            </div>
          </div>

          <div class="section-light subs">
            <div class="section-avi"></div>
            <div class="s-txt foll">
              bobmandude9889
            </div>
          </div>

          <div class="section-light subs">
            <div class="section-avi"></div>
            <div class="s-txt foll">
              Ryan Scott
            </div>
          </div>

          <div class="section-light subs">
            <div class="section-avi"></div>
            <div class="s-txt foll">
              Gaetan A.
            </div>
          </div>

          <div class="section-light subs">
            <div class="section-avi"></div>
            <div class="s-txt foll">
              bobmandude9889
            </div>
          </div>

          <div class="section-light subs">
            <div class="section-avi"></div>
            <div class="s-txt foll">
              Ryan Scott
            </div>
          </div>

          <div class="section-light subs">
            <div class="section-avi"></div>
            <div class="s-txt foll">
              Gaetan A.
            </div>
          </div>

          <div class="section-light subs">
            <div class="section-avi"></div>
            <div class="s-txt foll">
              bobmandude9889
            </div>
          </div>

          <div class="section-light subs">
            <div class="section-avi"></div>
            <div class="s-txt foll">
              Ryan Scott
            </div>
          </div>

          <div class="section-light subs">
            <div class="section-avi"></div>
            <div class="s-txt foll">
              Gaetan A.
            </div>
          </div>

          <div class="section-light subs">
            <div class="section-avi"></div>
            <div class="s-txt foll">
              bobmandude9889
            </div>
          </div>

          <div class="section-light subs">
            <div class="section-avi"></div>
            <div class="s-txt foll">
              Ryan Scott
            </div>
          </div>

          <div class="section-light subs">
            <div class="section-avi"></div>
            <div class="s-txt foll">
              Gaetan A.
            </div>
          </div>

          <div class="section-light subs">
            <div class="section-avi"></div>
            <div class="s-txt foll">
              bobmandude9889
            </div>
          </div>

          <div class="section-light subs">
            <div class="section-avi"></div>
            <div class="s-txt foll">
              Ryan Scott
            </div>
          </div>

          <div class="section-light subs">
            <div class="section-avi"></div>
            <div class="s-txt foll">
              Gaetan A.
            </div>
          </div>

          <div class="section-light subs">
            <div class="section-avi"></div>
            <div class="s-txt foll">
              bobmandude9889
            </div>
          </div>

          <div class="section-light subs">
            <div class="section-avi"></div>
            <div class="s-txt foll">
              Ryan Scott
            </div>
          </div>

          <div class="section-light subs">
            <div class="section-avi"></div>
            <div class="s-txt foll">
              Gaetan A.
            </div>
          </div>

          <div class="section-light subs">
            <div class="section-avi"></div>
            <div class="s-txt foll">
              bobmandude9889
            </div>
          </div>

          <div class="section-light subs">
            <div class="section-avi"></div>
            <div class="s-txt foll">
              Ryan Scott
            </div>
          </div>

          <div class="section-light subs">
            <div class="section-avi"></div>
            <div class="s-txt foll">
              Gaetan A.
            </div>
          </div>

          <div class="section-light subs">
            <div class="section-avi"></div>
            <div class="s-txt foll">
              bobmandude9889
            </div>
          </div>

          <div class="section-light subs">
            <div class="section-avi"></div>
            <div class="s-txt foll">
              Ryan Scott
            </div>
          </div>

          <div class="section-light subs">
            <div class="section-avi"></div>
            <div class="s-txt foll">
              Gaetan A.
            </div>
          </div>

          <div class="section-light subs">
            <div class="section-avi"></div>
            <div class="s-txt foll">
              bobmandude9889
            </div>
          </div>

          <div class="section-light subs">
            <div class="section-avi"></div>
            <div class="s-txt foll">
              Ryan Scott
            </div>
          </div>

          <div class="section-light subs">
            <div class="section-avi"></div>
            <div class="s-txt foll">
              Gaetan A.
            </div>
          </div>

          <div class="section-light subs">
            <div class="section-avi"></div>
            <div class="s-txt foll">
              bobmandude9889
            </div>
          </div>

          <div class="section-light subs">
            <div class="section-avi"></div>
            <div class="s-txt foll">
              Ryan Scott
            </div>
          </div>

          <div class="section-light subs">
            <div class="section-avi"></div>
            <div class="s-txt foll">
              Gaetan A.
            </div>
          </div>

          <div class="section-light subs">
            <div class="section-avi"></div>
            <div class="s-txt foll">
              bobmandude9889
            </div>
          </div>

          <div class="section-light subs">
            <div class="section-avi"></div>
            <div class="s-txt foll">
              Ryan Scott
            </div>
          </div>

          <div class="section-light subs">
            <div class="section-avi"></div>
            <div class="s-txt foll">
              Gaetan A.
            </div>
          </div>

          <div class="section-light subs">
            <div class="section-avi"></div>
            <div class="s-txt foll">
              bobmandude9889
            </div>
          </div>

          <div class="section-light subs">
            <div class="section-avi"></div>
            <div class="s-txt foll">
              Ryan Scott
            </div>
          </div>

          <div class="section-light subs">
            <div class="section-avi"></div>
            <div class="s-txt foll">
              Gaetan A.
            </div>
          </div>

          <div class="section-light subs">
            <div class="section-avi"></div>
            <div class="s-txt foll">
              bobmandude9889
            </div>
          </div>

          <div class="section-light subs">
            <div class="section-avi"></div>
            <div class="s-txt foll">
              Ryan Scott
            </div>
          </div>

          <div class="section-light subs">
            <div class="section-avi"></div>
            <div class="s-txt foll">
              Gaetan A.
            </div>
          </div>

          <div class="section-light subs">
            <div class="section-avi"></div>
            <div class="s-txt foll">
              bobmandude9889
            </div>
          </div>

          <div class="section-light subs">
            <div class="section-avi"></div>
            <div class="s-txt foll">
              Ryan Scott
            </div>
          </div>

          <div class="section-light subs">
            <div class="section-avi"></div>
            <div class="s-txt foll">
              Gaetan A.
            </div>
          </div>

          <div class="section-light subs">
            <div class="section-avi"></div>
            <div class="s-txt foll">
              bobmandude9889
            </div>
          </div>

          <div class="section-light subs">
            <div class="section-avi"></div>
            <div class="s-txt foll">
              Ryan Scott
            </div>
          </div>

          <div class="section-light subs">
            <div class="section-avi"></div>
            <div class="s-txt foll">
              Gaetan A.
            </div>
          </div>

          <div class="section-light subs">
            <div class="section-avi"></div>
            <div class="s-txt foll">
              bobmandude9889
            </div>
          </div>

          <div class="section-light subs">
            <div class="section-avi"></div>
            <div class="s-txt foll">
              Ryan Scott
            </div>
          </div>

          <div class="section-light subs">
            <div class="section-avi"></div>
            <div class="s-txt foll">
              Gaetan A.
            </div>
          </div>

          <div class="section-light subs">
            <div class="section-avi"></div>
            <div class="s-txt foll">
              bobmandude9889
            </div>
          </div>

          <div class="section-light subs">
            <div class="section-avi"></div>
            <div class="s-txt foll">
              Ryan Scott
            </div>
          </div>

          <div class="section-light subs">
            <div class="section-avi"></div>
            <div class="s-txt foll">
              Gaetan A.
            </div>
          </div>

          <div class="section-light subs">
            <div class="section-avi"></div>
            <div class="s-txt foll">
              bobmandude9889
            </div>
          </div>

          <div class="section-light subs">
            <div class="section-avi"></div>
            <div class="s-txt foll">
              Ryan Scott
            </div>
          </div>

        </div>
      </div>
  </div>

  <div class="imp-bg-fade" id="imp-bg-fade" style="display: none; opacity 1;"></div>

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

  <div class="h-content">
    <?php topBar($self) ?>

  <div class="post m-post">
    <div class="post-header">
      <h1 class="post-title">NEW POST</h1>
    </div>
    <div class="post-content">
      <div class="textarea-wrap">
        <textarea name="name" class="post-textarea" wrap="hard"></textarea>
        <div class="other-options-wrap">
          <button class="option-btn hover">
            <i class="material-icons search-g" style="float: left;padding-right: 10px; position: relative; font-size: 21px;top: -0.5px;">collections</i>Add Image
          </button>
          <button class="option-btn hover">
            <i class="material-icons search-g" style="float: left;padding-right: 10px; position: relative; font-size: 21px;top: -0.5px;">video_library</i>Add Video
          </button>
          <button class="option-btn hover">
            <i class="material-icons search-g" style="float: left;padding-right: 10px;position: relative;font-size: 34px;height: 10px;top: -6.5px;left: -5px;width: 23px;">gif</i>Add Gif
          </button>
        </div>
      </div>
      <div class="tags-wrap">
          <div class="searchbar category" style="background: #ddd">
            <i class="material-icons search-g" style="float: left; padding-right: 25px;position:relative; top: -4px; color: #999;">search</i><input type="text" placeholder="Add Tags" style="all: unset; width: 100px;position: relative; left: -10px; color: #999;" />
          </div>
      </div>
    </div>
    <div class="c-button-hold">
      <button class="post-btn closePost">Cancel</button>
      <button class="post-btn closePost" style="float: right">Post</button>
    </div>
  </div>

  <!-- <div class="post-blk m-post">
      <div class="c-title-holder">
        <h1 class="imp-title">New Post</h1>
      </div>

      <div class="c-content">

        <div class="textarea-wrap">
          <textarea name="name" class="post-textarea" wrap="hard"></textarea>
          <div class="other-options-wrap">
            <button class="option-btn hover">
              <i class="material-icons search-g" style="float: left;padding-right: 10px; position: relative; font-size: 21px;top: -0.5px;">collections</i>Add Image
            </button>
            <button class="option-btn hover">
              <i class="material-icons search-g" style="float: left;padding-right: 10px; position: relative; font-size: 21px;top: -0.5px;">video_library</i>Add Video
            </button>
            <button class="option-btn hover">
              <i class="material-icons search-g" style="float: left;padding-right: 10px;position: relative;font-size: 34px;height: 10px;top: -6.5px;left: -5px;width: 23px;">gif</i>Add Gif
            </button>
          </div>
        </div>
        <div class="tags-wrap">
            <div class="searchbar category" style="background: #ddd">
              <i class="material-icons search-g" style="float: left; padding-right: 25px;position:relative; top: -4px; color: #999;">search</i><input type="text" placeholder="Add Tags" style="all: unset; width: 100px;position: relative; left: -10px; color: #999;" />
            </div>
        </div>

      </div>

      <div class="c-button-hold new-post">
        <button class="post-btn closePost">Cancel</button>
        <button class="post-btn hover">Post</button>
      </div>
    </div> -->

  <div class="floating-box">
    <div class="floating-button openPost">
      <i class="material-icons floating">add</i>
    </div>
  </div>

<div class="post-corridor">
  <div class="meme-preview-box">
    <div class="m-text-box">
      <div class="reposted">
        <i class="material-icons m-icon" style="font-size: 14px; color: #fff; top: 0">repeat</i>
          <h1 class="m-handle" style="color: #fff; position: relative; float: left; margin-left: 5px;">@Al</h1>
      </div>
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

    <div class="m-new-container">
      <div class="m-main-content">
        <div class="meme-img">

        </div>
        <div class="post-content">
          <h6>Title of Post</h6>
          <div class="post-para">
            This is the content of the card. I have to write shit in here huh?
             I don't really know what to write so I'm just gonna say that Will sucks.
          </div>
          <div class="c-button-hold">
            <div class="m-post-info">
              <div class="m-likes">
                <i class="material-icons m-icon">keyboard_arrow_up</i>
                <h1 class="m-header">16K</h1>
              </div>
              <div class="m-reposts">
                <i class="material-icons m-icon" style="font-size: 23px; margin-top: 1px;">repeat</i>
                <h1 class="m-header">69</h1>
              </div>
              <div class="m-comments">
                <i class="material-icons m-icon" style="font-size: 22px; position: relative; top: 4px;">chat_bubble_outline</i>
                <h1 class="m-header">572</h1>
              </div>
              <div class="m-save">
                <i class="material-icons m-icon" style="float: left;">save</i>
              </div>
              <h1 class="m-date">dd/mm/yyyy</h1>
            </div>
          </div>
        </div>
      </div>
      <div class="m-comment-wrapper">
        <div class="m-comment-inside">


            <div class="m-comment">
              <div class="m-c-text-box">
                <div class="c-pp">
                </div>
                <div class="c-names">
                  <h1 class="c-OP">Gaetan Almela</h1>
                  <h1 class="c-handle">@Al</h1>
                </div>
              </div>
              <div class="m-c-para">
                <p class="c-para">
                  Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam</p>
              </div>
              <div class="comment-image"></div>
              <div class="m-c-reviews">
                <div class="m-comment-likes">
                  <i class="material-icons m-comment-icon">keyboard_arrow_up</i>
                  <h1 class="m-header-comment">522</h1>
                </div>
                <button class="c-op-1 c-reply" style="top: 5px; margin-left: 7px; color: #333;">REPLY</button>
                <i class="material-icons" style="top: 3px; color: #333;">more_horiz</i>
              </div>
              <div class="comment-replies">
                <div class="reply-comment">
                  <h1 class="c-OP">Gaetan Almela</h1>
                  <p class="c-para small">
                    Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua.</p>
                  <div class="m-c-reviews reply">
                    <div class="m-comment-likes">
                      <i class="material-icons m-comment-icon reply">keyboard_arrow_up</i>
                      <h1 class="m-header-comment reply">522</h1>
                    </div>
                    <button class="c-op-1 c-reply reply" style="top: 5px; margin-left: 7px; color: #333;">REPLY</button>
                    <i class="material-icons" style="top: 2px; color: #333; font-size: 24px;">more_horiz</i>
                  </div>
                </div>
                <div class="reply-comment">
                  <h1 class="c-OP">Gaetan Almela</h1>
                  <p class="c-para small">
                    Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor.</p>
                  <div class="comment-image reply"></div>
                  <div class="m-c-reviews reply">
                    <div class="m-comment-likes">
                      <i class="material-icons m-comment-icon reply">keyboard_arrow_up</i>
                      <h1 class="m-header-comment reply">522</h1>
                    </div>
                    <button class="c-op-1 c-reply reply" style="top: 5px; margin-left: 7px; color: #333;">REPLY</button>
                    <i class="material-icons" style="top: 2px; color: #333; font-size: 24px;">more_horiz</i>
                  </div>
                </div>
                <div class="m-c-reviews" style="margin-left: 0px;">
                  <button class="c-op-1 c-reply" style="top: 5px; margin-left: 0px; color: #333;">SHOW MORE</button>
                </div>
              </div>
            </div>


            <div class="m-comment">

              <div class="m-c-text-box">
                <div class="c-pp">

                </div>
                <div class="c-names">
                  <h1 class="c-OP">Gaetan Almela</h1>
                  <h1 class="c-handle">@Al</h1>
                </div>
              </div>

              <div class="m-c-para">
                <p class="c-para">
                  <span style="font-family: Roboto;font-weight: 700;color: #222;">@bobmandude9889
                  </span> Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip
                  ex ea commodo consequat. Duis aute irure dolor.</p>

              </div>
              <div class="m-c-reviews">
                <div class="m-comment-likes">
                  <i class="material-icons m-comment-icon">keyboard_arrow_up</i>
                  <h1 class="m-header-comment">522</h1>
                </div>
                <button class="c-op-1 c-reply" style="top: 5px; margin-left: 7px; color: #333;">REPLY</button>
                <i class="material-icons" style="top: 3px; color: #333;">more_horiz</i>
              </div>
            </div>
            <div class="m-comment">

              <div class="m-c-text-box">
                <div class="c-pp">

                </div>
                <div class="c-names">
                  <h1 class="c-OP">Gaetan Almela</h1>
                  <h1 class="c-handle">@Al</h1>
                </div>
              </div>

              <div class="m-c-para">
                <p class="c-para">
                  Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor.</p>

              </div>
              <div class="m-c-reviews">
                <div class="m-comment-likes">
                  <i class="material-icons m-comment-icon">keyboard_arrow_up</i>
                  <h1 class="m-header-comment">522</h1>
                </div>
                <button class="c-op-1 c-reply" style="top: 5px; margin-left: 7px; color: #333;">REPLY</button>
                <i class="material-icons" style="top: 3px; color: #333;">more_horiz</i>
              </div>
            </div>
            <div class="m-comment">

              <div class="m-c-text-box">
                <div class="c-pp">

                </div>
                <div class="c-names">
                  <h1 class="c-OP">Gaetan Almela</h1>
                  <h1 class="c-handle">@Al</h1>
                </div>
              </div>

              <div class="m-c-para">
                <p class="c-para">
                  Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor.</p>

              </div>
              <div class="m-c-reviews">
                <div class="m-comment-likes">
                  <i class="material-icons m-comment-icon">keyboard_arrow_up</i>
                  <h1 class="m-header-comment">522</h1>
                </div>
                <button class="c-op-1 c-reply" style="top: 5px; margin-left: 7px; color: #333;">REPLY</button>
                <i class="material-icons" style="top: 3px; color: #333;">more_horiz</i>
              </div>
            </div>
            <div class="m-comment">

              <div class="m-c-text-box">
                <div class="c-pp">

                </div>
                <div class="c-names">
                  <h1 class="c-OP">Gaetan Almela</h1>
                  <h1 class="c-handle">@Al</h1>
                </div>
              </div>

              <div class="m-c-para">
                <p class="c-para">
                  Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor.</p>

              </div>
              <div class="m-c-reviews">
                <div class="m-comment-likes">
                  <i class="material-icons m-comment-icon">keyboard_arrow_up</i>
                  <h1 class="m-header-comment">522</h1>
                </div>
                <button class="c-op-1 c-reply" style="top: 5px; margin-left: 7px; color: #333;">REPLY</button>
                <i class="material-icons" style="top: 3px; color: #333;">more_horiz</i>
              </div>
            </div>
            <div class="m-comment">

              <div class="m-c-text-box">
                <div class="c-pp">

                </div>
                <div class="c-names">
                  <h1 class="c-OP">Gaetan Almela</h1>
                  <h1 class="c-handle">@Al</h1>
                </div>
              </div>

              <div class="m-c-para">
                <p class="c-para">
                  Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor.</p>

              </div>
              <div class="m-c-reviews">
                <div class="m-comment-likes">
                  <i class="material-icons m-comment-icon">keyboard_arrow_up</i>
                  <h1 class="m-header-comment">522</h1>
                </div>
                <button class="c-op-1 c-reply" style="top: 5px; margin-left: 7px; color: #333;">REPLY</button>
                <i class="material-icons" style="top: 3px; color: #333;">more_horiz</i>
              </div>
            </div>
        </div>
      </div>
      <div class="m-post-comment">
        <div class="comment-box">
          <i class="material-icons m-meme-icon">add_a_photo</i>
          <textarea name="name" class="m-textarea" rows="1" cols="10" wrap="hard"></textarea>
          <button class="c-op-1 postit" style="top: 5px; margin-left: 7px; color: #333;">POST</button>
        </div>
      </div>
    </div>

  </div>

  <div class="meme-preview-box">
    <div class="m-text-box">
      <div class="reposted">
        <i class="material-icons m-icon" style="font-size: 14px; color: #fff; top: 0">repeat</i>
          <h1 class="m-handle" style="color: #fff; position: relative; float: left; margin-left: 5px;">@Al</h1>
      </div>
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

    <div class="m-new-container">
      <div class="m-main-content">
        <div class="m-album">
          <div class="m-album-row">
            <div class="m-album-img light"></div>
            <div class="m-album-img "></div>
          </div>
          <div class="m-album-row">
            <div class="m-album-img"></div>
            <div class="m-album-img light">
              <h1 class="album-text">+1</h1>
            </div>
          </div>
        </div>
        <div class="post-content">
          <h6>Title of Post</h6>
          <div class="post-para">
            This is the content of the card. I have to write shit in here huh?
             I don't really know what to write so I'm just gonna say that Will sucks.
          </div>
          <div class="c-button-hold">
            <div class="m-post-info">
              <div class="m-likes">
                <i class="material-icons m-icon">keyboard_arrow_up</i>
                <h1 class="m-header">16K</h1>
              </div>
              <div class="m-reposts">
                <i class="material-icons m-icon" style="font-size: 23px; margin-top: 1px;">repeat</i>
                <h1 class="m-header">69</h1>
              </div>
              <div class="m-comments">
                <i class="material-icons m-icon" style="font-size: 22px; position: relative; top: 4px;">chat_bubble_outline</i>
                <h1 class="m-header">572</h1>
              </div>
              <div class="m-save">
                <i class="material-icons m-icon" style="float: left;">save</i>
              </div>
              <h1 class="m-date">dd/mm/yyyy</h1>
            </div>
          </div>
        </div>
      </div>
      <div class="m-comment-wrapper">
        <div class="m-comment-inside">


            <div class="m-comment">
              <div class="m-c-text-box">
                <div class="c-pp">
                </div>
                <div class="c-names">
                  <h1 class="c-OP">Gaetan Almela</h1>
                  <h1 class="c-handle">@Al</h1>
                </div>
              </div>
              <div class="m-c-para">
                <p class="c-para">
                  Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam</p>
              </div>
              <div class="comment-image"></div>
              <div class="m-c-reviews">
                <div class="m-comment-likes">
                  <i class="material-icons m-comment-icon">keyboard_arrow_up</i>
                  <h1 class="m-header-comment">522</h1>
                </div>
                <button class="c-op-1 c-reply" style="top: 5px; margin-left: 7px; color: #333;">REPLY</button>
                <i class="material-icons" style="top: 3px; color: #333;">more_horiz</i>
              </div>
              <div class="comment-replies">
                <div class="reply-comment">
                  <h1 class="c-OP">Gaetan Almela</h1>
                  <p class="c-para small">
                    Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua.</p>
                  <div class="m-c-reviews reply">
                    <div class="m-comment-likes">
                      <i class="material-icons m-comment-icon reply">keyboard_arrow_up</i>
                      <h1 class="m-header-comment reply">522</h1>
                    </div>
                    <button class="c-op-1 c-reply reply" style="top: 5px; margin-left: 7px; color: #333;">REPLY</button>
                    <i class="material-icons" style="top: 2px; color: #333; font-size: 24px;">more_horiz</i>
                  </div>
                </div>
                <div class="reply-comment">
                  <h1 class="c-OP">Gaetan Almela</h1>
                  <p class="c-para small">
                    Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor.</p>
                  <div class="comment-image reply"></div>
                  <div class="m-c-reviews reply">
                    <div class="m-comment-likes">
                      <i class="material-icons m-comment-icon reply">keyboard_arrow_up</i>
                      <h1 class="m-header-comment reply">522</h1>
                    </div>
                    <button class="c-op-1 c-reply reply" style="top: 5px; margin-left: 7px; color: #333;">REPLY</button>
                    <i class="material-icons" style="top: 2px; color: #333; font-size: 24px;">more_horiz</i>
                  </div>
                </div>
                <div class="m-c-reviews" style="margin-left: 0px;">
                  <button class="c-op-1 c-reply" style="top: 5px; margin-left: 0px; color: #333;">SHOW MORE</button>
                </div>
              </div>
            </div>


            <div class="m-comment">

              <div class="m-c-text-box">
                <div class="c-pp">

                </div>
                <div class="c-names">
                  <h1 class="c-OP">Gaetan Almela</h1>
                  <h1 class="c-handle">@Al</h1>
                </div>
              </div>

              <div class="m-c-para">
                <p class="c-para">
                  <span style="font-family: Roboto;font-weight: 700;color: #222;">@bobmandude9889
                  </span> Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip
                  ex ea commodo consequat. Duis aute irure dolor.</p>

              </div>
              <div class="m-c-reviews">
                <div class="m-comment-likes">
                  <i class="material-icons m-comment-icon">keyboard_arrow_up</i>
                  <h1 class="m-header-comment">522</h1>
                </div>
                <button class="c-op-1 c-reply" style="top: 5px; margin-left: 7px; color: #333;">REPLY</button>
                <i class="material-icons" style="top: 3px; color: #333;">more_horiz</i>
              </div>
            </div>
            <div class="m-comment">

              <div class="m-c-text-box">
                <div class="c-pp">

                </div>
                <div class="c-names">
                  <h1 class="c-OP">Gaetan Almela</h1>
                  <h1 class="c-handle">@Al</h1>
                </div>
              </div>

              <div class="m-c-para">
                <p class="c-para">
                  Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor.</p>

              </div>
              <div class="m-c-reviews">
                <div class="m-comment-likes">
                  <i class="material-icons m-comment-icon">keyboard_arrow_up</i>
                  <h1 class="m-header-comment">522</h1>
                </div>
                <button class="c-op-1 c-reply" style="top: 5px; margin-left: 7px; color: #333;">REPLY</button>
                <i class="material-icons" style="top: 3px; color: #333;">more_horiz</i>
              </div>
            </div>
            <div class="m-comment">

              <div class="m-c-text-box">
                <div class="c-pp">

                </div>
                <div class="c-names">
                  <h1 class="c-OP">Gaetan Almela</h1>
                  <h1 class="c-handle">@Al</h1>
                </div>
              </div>

              <div class="m-c-para">
                <p class="c-para">
                  Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor.</p>

              </div>
              <div class="m-c-reviews">
                <div class="m-comment-likes">
                  <i class="material-icons m-comment-icon">keyboard_arrow_up</i>
                  <h1 class="m-header-comment">522</h1>
                </div>
                <button class="c-op-1 c-reply" style="top: 5px; margin-left: 7px; color: #333;">REPLY</button>
                <i class="material-icons" style="top: 3px; color: #333;">more_horiz</i>
              </div>
            </div>
            <div class="m-comment">

              <div class="m-c-text-box">
                <div class="c-pp">

                </div>
                <div class="c-names">
                  <h1 class="c-OP">Gaetan Almela</h1>
                  <h1 class="c-handle">@Al</h1>
                </div>
              </div>

              <div class="m-c-para">
                <p class="c-para">
                  Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor.</p>

              </div>
              <div class="m-c-reviews">
                <div class="m-comment-likes">
                  <i class="material-icons m-comment-icon">keyboard_arrow_up</i>
                  <h1 class="m-header-comment">522</h1>
                </div>
                <button class="c-op-1 c-reply" style="top: 5px; margin-left: 7px; color: #333;">REPLY</button>
                <i class="material-icons" style="top: 3px; color: #333;">more_horiz</i>
              </div>
            </div>
            <div class="m-comment">

              <div class="m-c-text-box">
                <div class="c-pp">

                </div>
                <div class="c-names">
                  <h1 class="c-OP">Gaetan Almela</h1>
                  <h1 class="c-handle">@Al</h1>
                </div>
              </div>

              <div class="m-c-para">
                <p class="c-para">
                  Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor.</p>

              </div>
              <div class="m-c-reviews">
                <div class="m-comment-likes">
                  <i class="material-icons m-comment-icon">keyboard_arrow_up</i>
                  <h1 class="m-header-comment">522</h1>
                </div>
                <button class="c-op-1 c-reply" style="top: 5px; margin-left: 7px; color: #333;">REPLY</button>
                <i class="material-icons" style="top: 3px; color: #333;">more_horiz</i>
              </div>
            </div>
        </div>
      </div>
      <div class="m-post-comment">
        <div class="comment-box">
          <i class="material-icons m-meme-icon">add_a_photo</i>
          <textarea name="name" class="m-textarea" rows="1" cols="10" wrap="hard"></textarea>
          <button class="c-op-1 postit" style="top: 5px; margin-left: 7px; color: #333;">POST</button>
        </div>
      </div>
    </div>

  </div>

  <div class="meme-preview-box">
    <div class="m-text-box">
      <div class="reposted">
        <i class="material-icons m-icon" style="font-size: 14px; color: #fff; top: 0">repeat</i>
          <h1 class="m-handle" style="color: #fff; position: relative; float: left; margin-left: 5px;">@Al</h1>
      </div>
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

    <div class="m-new-container">
      <div class="m-main-content">
        <div class="m-album">
          <div class="m-album-row">
            <div class="m-album-img light"></div>
            <div class="m-album-img "></div>
          </div>
          </div>
        </div>
        <div class="post-content">
          <h6>Title of Post</h6>
          <div class="post-para">
            This is the content of the card. I have to write shit in here huh?
             I don't really know what to write so I'm just gonna say that Will sucks.
          </div>
          <div class="c-button-hold">
            <div class="m-post-info">
              <div class="m-likes">
                <i class="material-icons m-icon">keyboard_arrow_up</i>
                <h1 class="m-header">16K</h1>
              </div>
              <div class="m-reposts">
                <i class="material-icons m-icon" style="font-size: 23px; margin-top: 1px;">repeat</i>
                <h1 class="m-header">69</h1>
              </div>
              <div class="m-comments">
                <i class="material-icons m-icon" style="font-size: 22px; position: relative; top: 4px;">chat_bubble_outline</i>
                <h1 class="m-header">572</h1>
              </div>
              <div class="m-save">
                <i class="material-icons m-icon" style="float: left;">save</i>
              </div>
              <h1 class="m-date">dd/mm/yyyy</h1>
            </div>
          </div>
        </div>
      </div>
      <div class="m-comment-wrapper">
        <div class="m-comment-inside">


            <div class="m-comment">
              <div class="m-c-text-box">
                <div class="c-pp">
                </div>
                <div class="c-names">
                  <h1 class="c-OP">Gaetan Almela</h1>
                  <h1 class="c-handle">@Al</h1>
                </div>
              </div>
              <div class="m-c-para">
                <p class="c-para">
                  Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam</p>
              </div>
              <div class="comment-image"></div>
              <div class="m-c-reviews">
                <div class="m-comment-likes">
                  <i class="material-icons m-comment-icon">keyboard_arrow_up</i>
                  <h1 class="m-header-comment">522</h1>
                </div>
                <button class="c-op-1 c-reply" style="top: 5px; margin-left: 7px; color: #333;">REPLY</button>
                <i class="material-icons" style="top: 3px; color: #333;">more_horiz</i>
              </div>
              <div class="comment-replies">
                <div class="reply-comment">
                  <h1 class="c-OP">Gaetan Almela</h1>
                  <p class="c-para small">
                    Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua.</p>
                  <div class="m-c-reviews reply">
                    <div class="m-comment-likes">
                      <i class="material-icons m-comment-icon reply">keyboard_arrow_up</i>
                      <h1 class="m-header-comment reply">522</h1>
                    </div>
                    <button class="c-op-1 c-reply reply" style="top: 5px; margin-left: 7px; color: #333;">REPLY</button>
                    <i class="material-icons" style="top: 2px; color: #333; font-size: 24px;">more_horiz</i>
                  </div>
                </div>
                <div class="reply-comment">
                  <h1 class="c-OP">Gaetan Almela</h1>
                  <p class="c-para small">
                    Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor.</p>
                  <div class="comment-image reply"></div>
                  <div class="m-c-reviews reply">
                    <div class="m-comment-likes">
                      <i class="material-icons m-comment-icon reply">keyboard_arrow_up</i>
                      <h1 class="m-header-comment reply">522</h1>
                    </div>
                    <button class="c-op-1 c-reply reply" style="top: 5px; margin-left: 7px; color: #333;">REPLY</button>
                    <i class="material-icons" style="top: 2px; color: #333; font-size: 24px;">more_horiz</i>
                  </div>
                </div>
                <div class="m-c-reviews" style="margin-left: 0px;">
                  <button class="c-op-1 c-reply" style="top: 5px; margin-left: 0px; color: #333;">SHOW MORE</button>
                </div>
              </div>
            </div>


            <div class="m-comment">

              <div class="m-c-text-box">
                <div class="c-pp">

                </div>
                <div class="c-names">
                  <h1 class="c-OP">Gaetan Almela</h1>
                  <h1 class="c-handle">@Al</h1>
                </div>
              </div>

              <div class="m-c-para">
                <p class="c-para">
                  <span style="font-family: Roboto;font-weight: 700;color: #222;">@bobmandude9889
                  </span> Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip
                  ex ea commodo consequat. Duis aute irure dolor.</p>

              </div>
              <div class="m-c-reviews">
                <div class="m-comment-likes">
                  <i class="material-icons m-comment-icon">keyboard_arrow_up</i>
                  <h1 class="m-header-comment">522</h1>
                </div>
                <button class="c-op-1 c-reply" style="top: 5px; margin-left: 7px; color: #333;">REPLY</button>
                <i class="material-icons" style="top: 3px; color: #333;">more_horiz</i>
              </div>
            </div>
            <div class="m-comment">

              <div class="m-c-text-box">
                <div class="c-pp">

                </div>
                <div class="c-names">
                  <h1 class="c-OP">Gaetan Almela</h1>
                  <h1 class="c-handle">@Al</h1>
                </div>
              </div>

              <div class="m-c-para">
                <p class="c-para">
                  Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor.</p>

              </div>
              <div class="m-c-reviews">
                <div class="m-comment-likes">
                  <i class="material-icons m-comment-icon">keyboard_arrow_up</i>
                  <h1 class="m-header-comment">522</h1>
                </div>
                <button class="c-op-1 c-reply" style="top: 5px; margin-left: 7px; color: #333;">REPLY</button>
                <i class="material-icons" style="top: 3px; color: #333;">more_horiz</i>
              </div>
            </div>
            <div class="m-comment">

              <div class="m-c-text-box">
                <div class="c-pp">

                </div>
                <div class="c-names">
                  <h1 class="c-OP">Gaetan Almela</h1>
                  <h1 class="c-handle">@Al</h1>
                </div>
              </div>

              <div class="m-c-para">
                <p class="c-para">
                  Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor.</p>

              </div>
              <div class="m-c-reviews">
                <div class="m-comment-likes">
                  <i class="material-icons m-comment-icon">keyboard_arrow_up</i>
                  <h1 class="m-header-comment">522</h1>
                </div>
                <button class="c-op-1 c-reply" style="top: 5px; margin-left: 7px; color: #333;">REPLY</button>
                <i class="material-icons" style="top: 3px; color: #333;">more_horiz</i>
              </div>
            </div>
            <div class="m-comment">

              <div class="m-c-text-box">
                <div class="c-pp">

                </div>
                <div class="c-names">
                  <h1 class="c-OP">Gaetan Almela</h1>
                  <h1 class="c-handle">@Al</h1>
                </div>
              </div>

              <div class="m-c-para">
                <p class="c-para">
                  Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor.</p>

              </div>
              <div class="m-c-reviews">
                <div class="m-comment-likes">
                  <i class="material-icons m-comment-icon">keyboard_arrow_up</i>
                  <h1 class="m-header-comment">522</h1>
                </div>
                <button class="c-op-1 c-reply" style="top: 5px; margin-left: 7px; color: #333;">REPLY</button>
                <i class="material-icons" style="top: 3px; color: #333;">more_horiz</i>
              </div>
            </div>
            <div class="m-comment">

              <div class="m-c-text-box">
                <div class="c-pp">

                </div>
                <div class="c-names">
                  <h1 class="c-OP">Gaetan Almela</h1>
                  <h1 class="c-handle">@Al</h1>
                </div>
              </div>

              <div class="m-c-para">
                <p class="c-para">
                  Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor.</p>

              </div>
              <div class="m-c-reviews">
                <div class="m-comment-likes">
                  <i class="material-icons m-comment-icon">keyboard_arrow_up</i>
                  <h1 class="m-header-comment">522</h1>
                </div>
                <button class="c-op-1 c-reply" style="top: 5px; margin-left: 7px; color: #333;">REPLY</button>
                <i class="material-icons" style="top: 3px; color: #333;">more_horiz</i>
              </div>
            </div>
        </div>
      </div>
      <div class="m-post-comment">
        <div class="comment-box">
          <i class="material-icons m-meme-icon">add_a_photo</i>
          <textarea name="name" class="m-textarea" rows="1" cols="10" wrap="hard"></textarea>
          <button class="c-op-1 postit" style="top: 5px; margin-left: 7px; color: #333;">POST</button>
        </div>
      </div>
    </div>

  </div>

</div>

  </div>

</body>

</html>
