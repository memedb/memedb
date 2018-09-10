<?php
class Post extends DBObject {

    function __construct() {
        parent::__construct("s", "posts");
    }


    public static function loadFromId($id) {
    $img = loadDBObject("posts", "id='$id'", "Post");
    $img->fixVars();
    return $img;
    }

    public function fixVars() {
    $arr = explode(',',$this->tags);
    if ($arr[0] === "")
        $this->tags = array();
    else
        $this->tags = $arr;
    }

    public function printImage($class, $resizeHolder, $width) {
    $size = getimagesize("./images/" . ($this->original ? $this->original : $this->id) . "." . $this->type);
    $height = ($size[1]/$size[0]) * $width;
    ?>
    <img onclick="showImagePreview(event);" data-id="<?=$this->id;?>" class="<?=$class?>" src="/images/<?=($this->original ? $this->original : $this->id) . "." . $this->type?>" style="<?=$resizeHolder ? "height: ".$height."px;" : ""?>">
    <?php
    }

    public static function printActivityContainerHtml($timestamp, $posts) {
    $dateStr = date("d M Y", $timestamp);
    if (sizeof($posts) == 1) {
    ?>
    <div class="exp-post">
        <?php
        $posts[0]->printImage("exp-post-image", true, 600);
        ?>
        <div class="exp-post-info">
        <h6><?=$posts[0]->caption;?></h6>
        <h2 class="card-date"><?=$dateStr?></h2>
        </div>
    </div>
    <?php
    } else {
        if (sizeof($posts) >= 5) {
        ?>
        <div class="exp-card long">
        <div class="exp-card-title">
            <h1 class="card-title">+ <?=$posts[0]->getLibrary()->name?></h1>
            <h2 class="card-date"><?=$dateStr?></h2>
        </div>
        <div class="exp-card-content">
            <?php
            $count = 0;
            foreach ($posts as $post) {
                ?>
                <div class="small-post" style="background-image: url(/images/<?=($post->original ? $post->original : $post->id) . "." . $post->type?>);">
                </div>
                <?php
                $count++;
                if ($count >= 13)
                break;
            }
            if (sizeof($posts) > 13) {
            ?>
            <div class="small-post"><h1 class="album-text small"><?=sizeof($posts) - 13?></h1></div>
            <?php
            }
            ?>
        </div>
        </div>
        <?php
        }
    }
    }

    public function getLibrary() {
    return loadDBObject("libraries", "`id`='{$this->library}'", "library");
    }

    public function getRepostCount() {
    $conn = $GLOBALS['conn'];
    $stmt = $conn->prepare("SELECT COUNT(id) AS reposts FROM `posts` WHERE `original`=?");
    $stmt->bind_param("s", $this->id);
    $stmt->execute();
    $result = $stmt->get_result();
    return $result->fetch_assoc()['reposts'];
    }

    public function getVotes() {
        $conn = $GLOBALS['conn'];
        $stmt = $conn->prepare("SELECT `vote` FROM `votes` WHERE `post`=?");
        $stmt->bind_param("s", $this->id);
        $stmt->execute();
        $result = $stmt->get_result();
        $votes = 0;
        if ($result->num_rows > 0) {
            while ($row = $result->fetch_assoc()) {
                $votes += $row['vote'];
            }
        }
        return $votes;
    }

    public function getVote($user) {
    if ($user == null)
        return 0;
    $conn = $GLOBALS['conn'];
    $stmt = $conn->prepare("SELECT vote FROM `votes` WHERE post=?");
    $stmt->bind_param("s", $this->id);
    $stmt->execute();
    $result = $stmt->get_result();
    if ($result->num_rows == 0)
        return 0;
    return $result->fetch_assoc()['vote'];
    }

    public function upvote($user) {
    return $this->vote(1, $user);
    }

    public function downvote($user) {
    return $this->vote(-1, $user);
    }

    private function vote($vote, $user) {
    $conn = $GLOBALS['conn'];
    $stmt = $conn->prepare("SELECT vote FROM votes WHERE post=?");
    $stmt->bind_param("s", $this->id);
    $stmt->execute();
    $result = $stmt->get_result();
    if ($result->num_rows != 0) {
        $stmt = $conn->prepare("DELETE FROM `votes` WHERE `post`=? AND `user`=?");
        $stmt->bind_param("si", $this->id, $user->id);
        $stmt->execute();
        if ($result->fetch_assoc()['vote'] != $vote) {
        $stmt = $conn->prepare("INSERT INTO `votes` (`user`, `post`, `vote`) VALUES (?, ?, ?)");
        $stmt->bind_param("isi", $user->id, $this->id, $vote);
        $stmt->execute();
        } else {
        $vote = 0;
        }
    } else {
        $stmt = $conn->prepare("INSERT INTO `votes` (`user`, `post`, `vote`) VALUES (?, ?, ?)");
        $stmt->bind_param("isi", $user->id, $this->id, $vote);
        $stmt->execute();
    }
    $post = Post::loadFromId($this->id);
    return $vote;
    }

    public function repost($user) {
    $conn = $GLOBALS['conn'];
    $stmt = $conn->prepare("SELECT `id` FROM `posts` WHERE `original`=? AND `source`=?");
    $stmt->bind_param("si", $this->id, $user->id);
    $stmt->execute();
    $result = $stmt->get_result();
    $reposted = 0;
    if ($result->num_rows == 0) {
        $id = uniqid('', true);
        $date = gmdate(DATE_ATOM);
        $lib = "POSTS";
        $stmt = $conn->prepare("INSERT INTO `posts` (`id`, `caption`, `tags`, `source`, `original`, `date`, `type`, `parent`, `library`) VALUES (?, '', '', ?, ?, ?, ?, ?, ?);");
        $stmt->bind_param("sisssis", $id, $user->id, $this->id, $date, $this->type, $this->parent, $lib);
        $stmt->execute();
        $reposted = 1;
    } else {
        $stmt = $conn->prepare("DELETE FROM `posts` WHERE `original`=? AND `source`=?");
        $stmt->bind_param("si", $this->id, $user->id);
        $stmt->execute();
    }
    return $reposted;
    }

    public function hasReposted($user) {
    if ($user == null)
        return false;
    $conn = $GLOBALS['conn'];
    $stmt = $conn->prepare("SELECT `id` FROM `posts` WHERE `original`=? AND `source`=?");
    $stmt->bind_param("si", $this->id, $user->id);
    $stmt->execute();
    $result = $stmt->get_result();
    return ($result->num_rows != 0);
    }

    public function getComments() {
    return loadDBObjects("comments", "`post`='{$this->id}' AND `parent` IS NULL ORDER BY date DESC", "Comment");
    }

    public function getCommentCount() {
    $conn = $GLOBALS['conn'];
    $stmt = $conn->prepare("SELECT COUNT(id) AS comments FROM `comments` WHERE `post`=?");
    $stmt->bind_param("s", $this->id);
    $stmt->execute();
    $result = $stmt->get_result();
    return $result->fetch_assoc()['comments'];
    }

}
?>