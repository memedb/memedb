<?php
require('api.php');

if ($_SESSION['id'] == null) {
  header("Location: https://meme-db.com");
}

function location($url) {
  ?>
  <script>
    window.location.href = "<?php echo $url; ?>";
  </script>
  <?php
}

$redirect = $_GET['red'];

$name = $_POST['name'];
$pass = $_POST['password'];

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
    ?>
    <script>
      window.location.href = "https://meme-db.com/" + "<?php echo ($redirect ? $redirect : ""); ?>";
    </script>
    <?php
  } else {
    $_SESSION['id'] = null;
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

      var xhr = new XMLHttpRequest();
      xhr.open('POST', 'https://meme-db.com/tokenlogin.php');
      xhr.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded');
      xhr.onreadystatechange = function () {
        if (xhr.readyState === XMLHttpRequest.DONE && xhr.status === 200) {
          console.log(xhr.responseText);
          if (xhr.responseText == "true")
            window.location.href = "https://meme-db.com/" + "<?php echo ($redirect ? $redirect : ""); ?>";
        }
      };
      xhr.send('idtoken=' + id_token);
      gapi.auth2.getAuthInstance().signOut();
    }
  </script>
  <title>memedb</title>
</head>

<body class="l-body">

  <div class="login-block">
    <div class="color-block">
      <h1 class="login-h1">Login</h1>
    </div>

    <form method="post" action="<?php echo $_SERVER['PHP_SELF'];?>">
      <div style="margin-bottom:20px;">
        <div class="input">
          <input name="name" type="text" placeholder="Username or Email" style="all: unset; width: 100%;position: relative; border-bottom: 2px solid #ddd;" required/>
        </div>
        <p class="login-sub" style="display: none">Potential error message.</p>
      </div>

      <div style="margin-bottom:20px;">
        <div class="input">
          <input name="password" type="password" placeholder="Password" style="all: unset; width: 100%;position: relative; border-bottom: 2px solid #ddd;" required/>
        </div>
      </div>

      <button class="alt" style="font-size: 12px;">Forgot Password?</button>

      <div class="g-signin2" data-onsuccess="onSignIn"></div>

      <div class="l-buttons">
        <input type="submit" class="button" value="LOGIN"></input>
        <a href="/signup"><button class="alt">SIGN UP</button></a>
      </div>
    </form>

  </div>

</body>

</html>
