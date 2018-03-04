<!DOCTYPE html>
<html>

<head>
  <link href="https://fonts.googleapis.com/css?family=Roboto:100,200,300,400,500,600,700,400italic|Roboto+Mono:400|Material+Icons" rel="stylesheet">
  <link href="https://fonts.googleapis.com/css?family=Lato:400,900,400italic,700italic" rel="stylesheet">
  <link href="https://fonts.googleapis.com/css?family=Roboto|Roboto+Slab:700" rel="stylesheet">
  <meta charset="utf-8">
  <link rel="stylesheet" href="../style/main.css">
  <script src="https://apis.google.com/js/platform.js" async defer></script>
  <meta name="google-signin-client_id" content="418828351371-8tdd958aet0f15qm8ju0rlv7v43tnstr.apps.googleusercontent.com">
  <script src="script.js"></script>
  <title>memedb</title>
</head>

<body class="l-body">

  <div class="login-block">
    <div class="color-block">
      <h1 class="login-h1">Login</h1>
    </div>

    <div style="margin-bottom:20px;">
      <div class="input">
        <input type="text" placeholder="Email" style="all: unset; width: 100%;position: relative; border-bottom: 2px solid #ddd;" />
      </div>
      <p class="login-sub">Potential error message.</p>
    </div>

    <div style="margin-bottom:20px;">
      <div class="input">
        <input type="text" placeholder="Password" style="all: unset; width: 100%;position: relative; border-bottom: 2px solid #ddd;" />
      </div>
      <p class="login-sub">Password does not match email.</p>
    </div>

    <button class="alt" style="font-size: 12px;">Forgot Password?</button>

    <div class="g-signin2" data-onsuccess="onSignIn"></div>

    <div class="l-buttons">
      <button class="button">LOGIN</button>
      <button class="alt">SIGN UP</button>
    </div>

  </div>

</body>

</html>
