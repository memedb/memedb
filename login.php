<?php
require('api.php');

$redirect = $_GET['red'];

$name = $_POST['name'];
$pass = $_POST['password'];

if ($_SESSION['id'] !== null)
  header("Location: https://www.memed-db.com/".urldecode($redirect));

if ($name !== null && $pass !== null && ) {
  $conn = $GLOBALS['conn'];

  $stmt = $conn->prepare("SELECT salt FROM users WHERE (name=? OR email=?)");
  $stmt->bind_param('ss', $name, $pass);
  $stmt->execute();
  $result = $stmt->get_result();
  $salt = $result->fetch_assoc()['salt'];

  $pass = hash("sha256", $pass.$salt);

  $stmt = $conn->prepare("SELECT id FROM users WHERE (name=? OR email=?) AND pwd=?");
  $stmt->bind_param('sss', $name, $email, $pass);
  $stmt->execute();
  $result = $stmt->get_result();

  if ($result->num_rows > 0) {
    $row = $result->fetch_assoc();
    $_SESSION['id'] = $row['id'];
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
      var profile = googleUser.getBasicProfile();
      var id_token = googleUser.getAuthResponse().id_token;
      console.log(id_token);
      console.log('ID: ' + profile.getId()); // Do not send to your backend! Use an ID token instead.
      console.log('Name: ' + profile.getName());
      console.log('Image URL: ' + profile.getImageUrl());
      console.log('Email: ' + profile.getEmail()); // This is null if the 'email' scope is not present.
      gapi.auth2.getAuthInstance().signOut().then(function() {
        console.log('User signed out.');
      });
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
        <p class="login-sub">Potential error message.</p>
      </div>

      <div style="margin-bottom:20px;">
        <div class="input">
          <input name="password" type="password" placeholder="Password" style="all: unset; width: 100%;position: relative; border-bottom: 2px solid #ddd;" required/>
        </div>
        <p class="login-sub">Password does not match email.</p>
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
