<?php
class Comment extends DBObject {

    public static $idType = "s";
    public static $table = "comments";

    public static function loadFromId($id) {
        $cmt = loadDBObject("comments", "id='$id'", "Comment");
        $cmt->fixVars();
        return $cmt;
    }

    public function fixVars() {
    }

    public function getVotes() {
        $conn = $GLOBALS['conn'];
        $stmt = $conn->prepare("SELECT COUNT(vote) AS votes FROM `comment_votes` WHERE `vote`=1 AND `id`=? UNION SELECT COUNT(vote) AS votes FROM `comment_votes` WHERE `vote`=-1 AND `id`=? ");
        $stmt->bind_param("ss", $this->id, $this->id);
        $stmt->execute();
        $result = $stmt->get_result();
        $upvotes = $result->fetch_assoc()['votes'];
        $downvotes = $result->fetch_assoc()['votes'];
        logger("upvotes: " . $upvotes);
        logger("downvotes: " . $downvotes);
        return $upvotes - $downvotes;
    }

    public function getVote($user) {
        if ($user == null)
        return 0;
        $conn = $GLOBALS['conn'];
        $stmt = $conn->prepare("SELECT vote FROM `comment_votes` WHERE id=?");
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
        $stmt = $conn->prepare("SELECT vote FROM `comment_votes` WHERE id=?");
        $stmt->bind_param("s", $this->id);
        $stmt->execute();
        $result = $stmt->get_result();
        if ($result->num_rows != 0) {
        $stmt = $conn->prepare("DELETE FROM `comment_votes` WHERE `id`=? AND `user`=?");
        $stmt->bind_param("si", $this->id, $user->id);
        $stmt->execute();
        if ($result->fetch_assoc()['vote'] != $vote) {
            $stmt = $conn->prepare("INSERT INTO `comment_votes` (`user`, `id`, `vote`) VALUES (?, ?, ?)");
            $stmt->bind_param("isi", $user->id, $this->id, $vote);
            $stmt->execute();
        } else {
            $vote = 0;
        }
        } else {
        $stmt = $conn->prepare("INSERT INTO `comment_votes` (`user`, `id`, `vote`) VALUES (?, ?, ?)");
        $stmt->bind_param("isi", $user->id, $this->id, $vote);
        $stmt->execute();
        }
        return $vote;
    }

    public function getReplies() {
        return loadDBObjects("comments", "`post`='{$this->post}' AND `parent`='{$this->id}' ORDER BY date ASC", "Comment");
    }

}  
?>