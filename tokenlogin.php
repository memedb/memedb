<?php
require_once 'vendor/autoload.php';
require_once 'api.php';

$id_token = $_POST['idtoken'];

if ($id_token == null) {
  header("Location: https://memedb.io");
}

$client = new Google_Client();
$client->setAuthConfig('secret/client_secrets.json');

$payload = $client->verifyIdToken($id_token);
if ($payload) {
  header("Location: https://memedb.io");
  $usr = User::loadFromEmail($payload['email']);
  if ($usr) {
    $_SESSION['id'] = $usr->id;
  } else {
    $_SESSION['id'] = User::create($payload['name'], $payload['email'], null, true);
  }
  var_dump($usr);
} else {
  header("Location: https://memedb.io/login");
}
?>
