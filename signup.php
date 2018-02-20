<?php
require('api.php');

if ($_SERVER['REQUEST_METHOD'] === 'POST') {

}
?>
<!DOCTYPE html>
<html>

<head>
  <?php imports(); ?>
  <title>memedb</title>
</head>

<body class="l-body">

  <div class="signup-block">
    <div class="color-block">
      <h1 class="login-h1">Sign Up</h1>
    </div>

    <form method="post" action="<?php echo $_SERVER['PHP_SELF'];?>">
      <div style="margin-bottom:20px;">
        <div class="input">
          <input type="text" placeholder="Name" pattern="[a-zA-Z0-9_]{1,32}" title="No more than 32 characters and no special characters." style="all: unset; width: 100%;position: relative; border-bottom: 2px solid #ddd;" required />
        </div>
        <p class="login-sub" style="opacity: 0;">Name cannot be longer than 32 characters</p>
      </div>

      <div style="margin-bottom:20px;">
        <div class="input">
          <input type="email" placeholder="Email" style="all: unset; width: 100%;position: relative; border-bottom: 2px solid #ddd;" required />
        </div>
        <p class="login-sub" style="opacity: 0;">This email is already in use.</p>
      </div>

      <div style="margin-bottom:20px;">
        <div class="input">
          <input type="password" placeholder="Password" pattern="{8,}" title="At least 8 characters." style="all: unset; width: 100%;position: relative; border-bottom: 2px solid #ddd;" required />
        </div>
        <p class="login-sub" style="opacity: 0;">Potential warn message.</p>
      </div>

      <div style="margin-bottom:20px;">
        <div class="input">
          <input type="password" placeholder="Repeat Password" pattern="{8,}" title="At least 8 characters." style="all: unset; width: 100%;position: relative; border-bottom: 2px solid #ddd;" required />
        </div>
        <p class="login-sub" style="opacity: 0;">Password does not match.</p>
      </div>
      <input type="submit" value="SIGN UP" class="button"/>
    </form>

  </div>

</body>

</html>
