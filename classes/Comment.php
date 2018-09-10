<?php
class Comment extends DBObject {

    function __construct() {
        parent::__construct("s", "comments");
    }

    public static function loadFromId($id) {
        $cmt = loadDBObject("comments", "id='$id'", "Comment");
        $cmt->fixVars();
        return $cmt;
    }

    public function fixVars() {
    }

    public function getVotes() {
        $conn = $GLOBALS['conn'];
        $stmt = $conn->prepare("SELECT vote FROM `comment_votes` WHERE `id`=?");
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
        $stmt = $conn->prepare("SELECT vote FROM `comment_votes` WHERE id=? AND `user`=?");
        $stmt->bind_param("si", $this->id, $user->id);
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