<?php
require('api.php');

if ($_SERVER['REQUEST_METHOD'] === 'POST') {

}
?>
<!DOCTYPE html>
<html>

<head>
  <?php imports(); ?>
  <script>
    function setValidationMessage(input, missing, pattern, other) {
      var err = input.parentElement.nextElementSibling;
      input.addEventListener('invalid', function(event) {
        event.preventDefault();
      });
      input.addEventListener('input', function(event){
        if (input.validity.patternMismatch) {
          err.innerHTML = pattern;
          err.style.opacity = 1;
        } else if (input.validity.valueMissing) {
          err.innerHTML = missing;
          err.style.opacity = 1;
        } else if (!input.validity.valid) {
          err.innerHTML = other;
          err.style.opacity = 1;
        } else if (err.style.opacity == 1) {
          err.style.opacity = 0;
        }
      });
    }

    $(document).ready(function() {
      var name = document.getElementById('name');
      var email = document.getElementById('email');
      var pwd1 = document.getElementById('pwd1');
      var pwd2 = document.getElementById('pwd2');

      setValidationMessage(name, "Please enter a username.", "Name cannot contain any special characters.");
      setValidationMessage(email, "Please enter an email.", "Please enter a valid email address.", "Please enter a valid email address.");
      setValidationMessage(pwd1, "Please enter a password.", "", "Password must be at least 8 characters.");
      setValidationMessage(pwd2, "Please confirm your password.", "", "Password must be at least 8 characters.");

      name.addEventListener('input', function(event) {

      });

      pwd2.addEventListener('input', function(event) {
        if (pwd1.value != pwd2.value) {
          var err = pwd2.parentElement.nextElementSibling;
          err.innerHTML = "Passwords do not match.";
          err.style.opacity = 1;
        }
      });

      $("form").submit(function() {
      });
    });
  </script>
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
          <input id="name" name="name" type="text" placeholder="Name" pattern="[a-zA-Z0-9_]{1,32}" maxlength="32" title="No more than 32 characters and no special characters." style="all: unset; width: 100%;position: relative; border-bottom: 2px solid #ddd;" required />
        </div>
        <p class="login-sub" style="opacity: 1;">Please enter a username.</p>
      </div>

      <div style="margin-bottom:20px;">
        <div class="input">
          <input id="email" name="email" type="email" placeholder="Email" style="all: unset; width: 100%;position: relative; border-bottom: 2px solid #ddd;" required />
        </div>
        <p class="login-sub" style="opacity: 1;">Please enter an email.</p>
      </div>

      <div style="margin-bottom:20px;">
        <div class="input">
          <input id="pwd1" type="password" placeholder="Password" pattern="{8,}" title="At least 8 characters." style="all: unset; width: 100%;position: relative; border-bottom: 2px solid #ddd;" required />
        </div>
        <p class="login-sub" style="opacity: 1;">Please enter a password.</p>
      </div>

      <div style="margin-bottom:20px;">
        <div class="input">
          <input id="pwd2" type="password" placeholder="Repeat Password" pattern="{8,}" title="At least 8 characters." style="all: unset; width: 100%;position: relative; border-bottom: 2px solid #ddd;" required />
        </div>
        <p class="login-sub" style="opacity: 1;">Please confirm your password.</p>
      </div>
      <input type="submit" value="SIGN UP" class="button"/>
    </form>

  </div>

</body>

</html>
