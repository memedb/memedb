<?php
require_once 'vendor/autoload.php';
require_once 'api.php';

$id_token = $_POST['idtoken'];

if ($id_token == null) {
  header("Location: https://meme-db.com");
}

$client = new Google_Client();
$client->setAuthConfig('client_secrets.json');
// $client->setAccessType("offline");
// $client->setIncludeGrantedScopes(true);
// $client->addScope(Google_Service_Drive::DRIVE_METADATA_READONLY);
// $client->setRedirectUri('http://' . $_SERVER['HTTP_HOST']);

$payload = $client->verifyIdToken($id_token);
if ($payload) {
  echo "true";
  $usr = user::loadFromEmail($payload['email']);
  if ($usr) {
    $_SESSION['id'] = $usr->id;
  } else {
    $_SESSION['id'] = user::create($payload['name'], $payload['email'], null, true);
  }
} else {
  echo "false";
}
?>
