<?php
require('api.php');

$name = $_POST['name'];
$email = $_POST['email'];
$pass1 = $_POST['password'];
$pass2 = $_POST['confirm'];

if ($name !== null && $email !== null && $pass1 !== null && $pass2 !== null) {
  $name_exists = exists($name, 'users', 'name');
  $email_exists = exists($email, 'users', 'email');

  if (!($name_exists || $email_exists)) {
    $_SESSION['id'] = User::create($name, $email, $pass1);
    header("Location: /account.php?new");
  }
}
?>
<!DOCTYPE html>
<html>

<head>
  <?php imports(); ?>
  <script>
    var showError = false;
    function setValidationMessage(input, missing, pattern, other) {
      var err = input.parentElement.nextElementSibling;
      input.addEventListener('invalid', function(event) {
        event.preventDefault();
      });
      input.addEventListener('input', function(event){
        if (showError) {
          if (input.validity.patternMismatch) {
            err.innerHTML = pattern;
            err.style.opacity = 1;
            err.style.color = "#ff8e8e";
            this.style.borderBottom = "2px solid #ff8e8e";
          } else if (input.validity.valueMissing) {
            err.innerHTML = missing;
            err.style.opacity = 1;
            err.style.color = "#ff8e8e";
            this.style.borderBottom = "2px solid #ff8e8e";
          } else if (!input.validity.valid) {
            err.innerHTML = other;
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
      var email = document.getElementById('email');
      var pwd1 = document.getElementById('pwd1');
      var pwd2 = document.getElementById('pwd2');

      setValidationMessage(name, "Please enter a username.", "Name cannot contain any special characters.");
      setValidationMessage(email, "Please enter an email.", "Please enter a valid email address.", "Please enter a valid email address.");
      setValidationMessage(pwd1, "Please enter a password.", "Password must be at least 8 characters.", "Password must be at least 8 characters.");
      setValidationMessage(pwd2, "Please confirm your password.", "Password must be at least 8 characters.", "Password must be at least 8 characters.");

      pwd2.addEventListener('input', function(event) {
        if (showError && pwd1.value != pwd2.value) {
          var err = pwd2.parentElement.nextElementSibling;
          pwd2.style.borderBottom = "2px solid #ff8e8e";
          err.innerHTML = "Passwords do not match.";
          err.style.opacity = 1;
        }
      });

      $("#submit").click(function() {
        showError = true;
        var event = new Event('input', {
          'bubbles': true,
          'cancelable': true
        });
        name.dispatchEvent(event);
        email.dispatchEvent(event);
        pwd1.dispatchEvent(event);
        pwd2.dispatchEvent(event);
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
          <input value="<?php echo $name; ?>" id="name" name="name" type="text" placeholder="Username" pattern="[a-zA-Z0-9_]{1,32}" maxlength="32" title="No more than 32 characters and no special characters." style="all: unset; width: 100%;position: relative; border-bottom: 2px solid #<?php echo ($name_exists ? "ff8e8e" : "ddd"); ?>;" required />
        </div>
        <p class="login-sub" style="opacity: <?php echo ($name_exists ? "1" : "0"); ?>;">This username already exists!</p>
      </div>

      <div style="margin-bottom:20px;">
        <div class="input">
          <input value="<?php echo $email; ?>" id="email" name="email" type="email" placeholder="Email" style="all: unset; width: 100%;position: relative; border-bottom: 2px solid #<?php echo ($email_exists ? "ff8e8e" : "ddd"); ?>;" required />
        </div>
        <p class="login-sub" style="opacity: <?php echo ($email_exists ? "1" : "0"); ?>;">This email already exists!</p>
      </div>

      <div style="margin-bottom:20px;">
        <div class="input">
          <input value="<?php echo $pass1; ?>" id="pwd1" name="password" type="password" placeholder="Password" pattern=".{8,}" title="At least 8 characters." style="all: unset; width: 100%;position: relative; border-bottom: 2px solid #ddd;" required />
        </div>
        <p class="login-sub" style="opacity: 0;">Please enter a password.</p>
      </div>

      <div style="margin-bottom:20px;">
        <div class="input">
          <input value="<?php echo $pass2; ?>" id="pwd2" name="confirm" type="password" placeholder="Repeat Password" pattern=".{8,}" title="At least 8 characters." style="all: unset; width: 100%;position: relative; border-bottom: 2px solid #ddd;" required />
        </div>
        <p class="login-sub" style="opacity: 0;">Please confirm your password.</p>
      </div>
      <input id="submit" type="submit" value="SIGN UP" class="button"/>
    </form>

  </div>

</body>

</html>
