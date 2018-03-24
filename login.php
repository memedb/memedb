<?php
require('api.php');

if ($_SESSION['id'] !== null) {
  header("Location: https://meme-db.com");
}

function location($url) {
  ?>
  <script>
    window.location.href = "<?php echo $url; ?>";
  </script>
  <?php
}

$name = $_POST['name'];
$pass = $_POST['password'];

$GLOBALS['valid'] = true;

if ($name !== null && $pass !== null) {
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
    $row = $result->fetch_assoc();
    $_SESSION['id'] = $row['id'];
    $GLOBALS['valid'] = true;
    ?>
    <script>
      window.location.href = "https://meme-db.com/" + "<?php echo ($redirect ? $redirect : ""); ?>";
    </script>
    <?php
  } else {
    $_SESSION['id'] = null;
    $GLOBALS['valid'] = false;
  }

}
 ?>

<!DOCTYPE html>
<html>

<head>
  <script src="https://apis.google.com/js/platform.js" async defer></script>
  <meta name="google-signin-client_id" content="418828351371-8tdd958aet0f15qm8ju0rlv7v43tnstr.apps.googleusercontent.com">
  <?php
  imports();
  ?>
  <script>
    function onSignIn(googleUser) {
      var id_token = googleUser.getAuthResponse().id_token;

      $('#inset_form').html('<form action="https://meme-db.com/tokenlogin.php" name="google_login" method="post"><input type="text" name="idtoken" value="' + id_token + '" /></form>');

      document.forms['google_login'].submit();
      gapi.auth2.getAuthInstance().signOut();
    }

    var showError = false;
    function setValidationMessage(input, message) {
      var err = input.parentElement.nextElementSibling;
      input.addEventListener('invalid', function(event) {
        event.preventDefault();
      });
      input.addEventListener('input', function(event){
        if (showError) {
          if (input.validity.valueMissing) {
            err.innerHTML = message;
            err.style.opacity = 1;
            err.style.color = "#ff8e8e";
            this.style.borderBottom = "2px solid #ff8e8e";
          } else if (err.style.opacity == 1) {
            err.style.opacity = 0;
            err.style.color = "";
            this.style.borderBottom = "2px solid #ddd";
          }
        }
      });
    }

    $(document).ready(function() {
      var name = document.getElementById('name');
      var pwd = document.getElementById('pwd');

      setValidationMessage(name, "Please enter a username.", "Name cannot contain any special characters.");
      setValidationMessage(pwd, "Please enter a password.", "Password must be at least 8 characters.", "Password must be at least 8 characters.");

      <?php if (!$GLOBALS['valid']) { ?>
        var err = name.parentElement.nextElementSibling;
        err.innerHTML = "Invalid username or password";
        err.style.opacity = 1;
        err.style.color = "#ff8e8e";
        name.style.borderBottom = "2px solid #ff8e8e";
        showError = true;
      <?php } ?>

      $("#submit").click(function() {
        showError = true;
        var event = new Event('input', {
          'bubbles': true,
          'cancelable': true
        });
        name.dispatchEvent(event);
        pwd.dispatchEvent(event);
      });
    });
  </script>
  <title>memedb</title>
</head>

<body class="l-body">

  <div id="inset_form" style="display:none;">

  </div>

  <div class="login-block">
    <div class="color-block">
      <h1 class="login-h1">Sign In</h1>
    </div>

    <form method="POST" action="<?php echo $_SERVER['PHP_SELF'];?>">
      <div style="margin-bottom:20px;">
        <div class="input">
          <input id="name" name="name" type="text" value="<?php echo $_POST['name']; ?>" placeholder="Username or Email" style="all: unset; width: 100%;position: relative; border-bottom: 2px solid #ddd;" required/>
        </div>
        <p class="login-sub" style="opacity:0;">Potential error message.</p>
      </div>

      <div style="margin-bottom:20px;">
        <div class="input">
          <input id="pwd" name="password" type="password" placeholder="Password" style="all: unset; width: 100%;position: relative; border-bottom: 2px solid #ddd;" required/>
        </div>
        <p class="login-sub" style="opacity:0;">Potential error message.</p>
      </div>

      <button class="alt" style="font-size: 12px;">Forgot Password?</button>

      <div class="g-signin2" data-onsuccess="onSignIn"></div>

      <div class="l-buttons">
        <input id="submit" type="submit" class="button" value="SIGN IN"></input>
        <a href="/signup"><button class="alt">SIGN UP</button></a>
      </div>
    </form>

  </div>

</body>

</html>
