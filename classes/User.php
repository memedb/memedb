<?php

class User {

    public function getImage() {
        return "/userimg.php?handle=" . $this->handle;
    }

    public function printImage($size, $style) {
        ?>
        <img src="<?= $this->getImage(); ?>" style="<?=$style?>" width="<?=$size?>" height="<?=$size?>">
        <?php
    }

    public function getLink() {
        return "/account/" . $this->handle;
    }

    public static function loadFromId($id) {
        $usr = loadDBObject("users", "id={$id}", "User");
        $usr->fixVars();
        return $usr;
    }

    public static function loadFromEmail($email) {
        $usr = loadDBObject("users", "email='$email'", "User");
        $usr->fixVars();
        return $usr;
    }

    public static function loadFromHandle($handle) {
        $usr = loadDBObject("users", "handle='$handle'", "User");
        $usr->fixVars();
        return $usr;
    }

    public static function loadFromSession($session) {
        $usr = loadDBObject("users", "session='$session'", "User");
        $usr->fixVars();
        return $usr;
    }

    public function fixVars() {
        if ($usr != null) {
        $usr->favorites = explode(",",$usr->favorites);
        $usr->image = "/userimg.php?handle=" + $usr->handle;
        }
    }

    public static function create($name, $email, $password, $google) {
        if ($google)
        $password = uniqid();
        $conn = $GLOBALS['conn'];
        $stmt = $conn->prepare("INSERT INTO `users`
        (`id`, `name`, `handle`, `email`, `pwd`, `salt`, `confirmed`, `priv`, `joined`, `lastSeen`, `favorites`, `karma`, `rank`, `session`)
        VALUES (NULL, ?, ?, ?, ?, ?, 0, 1, ?, ?, '', 0, 0, '')");
        $stmt->bind_param("sssssss", $name, $name, $email, $hPass, $salt, $now, $now);
        $salt = uniqid();
        $hPass = hash("sha256", $password.$salt);
        $now = gmdate(DATE_ATOM);
        $stmt->execute();

        $stmt = $conn-prepare("SELECT id FROM users WHERE email=?");
        $stmt->bind_param('s', $email);
        $stmt->execute();
        $result = $stmt->get_result();

        $id = $result->fetch_assoc()['id'];

        $subject = 'MemeDB Confirmation';
        $message = "<html>
        <head>
        <title>MemeDB Confirmation</title>
        </head>
        <body>
        <p>Hi $name! Thank you for registering on MemeDB! To complete the registration click the link below.</p>

        <a href='http://memed-db.com/confirm.php?token=$token'>
            <div>
            Confirm
            </div>
        </a>
        <br>
        </body>
        </html>";

        $headers[] = 'MIME-Version: 1.0';
        $headers[] = 'Content-type: text/html; charset=iso-8859-1';

        $headers[] = 'To: '.$name.' <'.$email.'>';
        $headers[] = 'From: MemeDB Confirmation <support@memedb.io>';

        mail($email, $subject, $message, implode("\r\n", $headers));
        return $id;
    }

    public function updateFields() {
        $keys = func_get_args();
        $keysExtra = array();
        $numKeys = func_num_args();
        $updateVals = "";

        for ($i = 0; $i < $numKeys; $i++) {
            $keysExtra[$i] = $keys[$i]."=?";
        }

        $updateVals = implode(",", $keysExtra);

        $conn = $GLOBALS['conn'];
        $stmt = $conn->prepare("UPDATE users SET {$updateVals} WHERE id=?");

        $fieldTypes = "";

        $params = array();
        $values = array();

        for ($i = 0; $i < $numKeys; $i++) {
            $values[$i] = get_object_vars($this)[$keys[$i]];
            switch (gettype($values[$i])) {
            case "integer":
                $fieldTypes = $fieldTypes."i";
                break;
            case "string":
                $fieldTypes = $fieldTypes."s";
                break;
            case "array":
                $fieldTypes = $fieldTypes."s";
                $values[$i] = implode(",", $values[$i]);
                $values[$i] = substr($values[$i], 0, strlen($values[$i]));
                break;
            }
            $params = array_merge($params, array(&$values[$i]));
        }

        $params = array_merge(array($fieldTypes."i"), $params);

        $params = array_merge($params, array(&$this->id));

        call_user_func_array(array($stmt, "bind_param"), $params);
        $stmt->execute();
    }

    public function addFavorite($type) {
        array_push($this->favorites, $type);
        $this->updateFields("favorites");
    }

    public function removeFavorite($type) {
        $index = -1;
        for ($i = 0; $i < count($this->favorites); $i++) {
        if ($this->favorites[$i] == $type) {
            $index = $i;
            break;
        }
        }
        array_splice($this->favorites, $index, 1);
        $this->updateFields("favorites");
    }

    public function getFollowerCount() {
        $conn = $GLOBALS['conn'];
        $stmt = $conn->prepare("SELECT count(following) as followers FROM `following` WHERE `following`=?");
        $stmt->bind_param("i",$this->id);
        $stmt->execute();
        $result = $stmt->get_result();
        return $result->fetch_assoc()['followers'];
    }

    public function getFormattedFollowerCount() {
        $count = $this->getFollowerCount();
        return shortNum($count);
    }

    public function getFollowers() {
        $conn = $GLOBALS['conn'];
        $stmt = $conn->prepare("SELECT user FROM `following` WHERE `following`=?");
        $stmt->bind_param("i",$this->id);
        $stmt->execute();
        $result = $stmt->get_result();
        $followers = array();
        while ($row = $result->fetch_assoc()) {
        array_push($followers, $row['user']);
        }
        return $followers;
    }

    public function addFollowing($id) {
        $conn = $GLOBALS['conn'];
        $stmt = $conn->prepare("INSERT INTO `following` (`user`, `following`) VALUES (?, ?)");
        $stmt->bind_param("ii", $this->id, $id);
        $stmt->execute();
    }

    public function removeFollowing($id) {
        $conn = $GLOBALS['conn'];
        $stmt = $conn->prepare("DELETE FROM `following` WHERE user=? AND following=?");
        $stmt->bind_param("ii", $this->id, $id);
        $stmt->execute();
    }

    public function isFollowing($id) {
        $conn = $GLOBALS['conn'];
        $stmt = $conn->prepare("SELECT * FROM `following` WHERE user=? AND following=?");
        $stmt->bind_param("ii", $this->id, $id);
        $stmt->execute();
        $result = $stmt->get_result();
        return $result->num_rows > 0;
    }

    public function getAccountLink() {
        
    }

}
  
?>