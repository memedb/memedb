<?php

class Library extends DBObject {

    function __construct() {
        parent::__construct("s", "libraries");
    }

    public static function create($name, $posts, $icon, $canUpload, $user) {
        $lib = new Library();
        $lib->name = $name;
        $lib->id = $name;
        $lib->posts = $posts;
        $lib->icon = $icon;
        $lib->canUpload = $canUpload;
        $lib->visibility = 2;
        $lib->user = $user->id;
        return $lib;
    }

    public static function loadFromUser($user) {
        $libs = loadDBObjects("libraries", "user={$user->id}", "Library");
        array_unshift($libs,
        Library::create("POSTS", loadDBObjects("posts", "source={$user->id} AND original IS NULL", "Post"), "photo_library", true, $user),
        Library::create("REPOSTS", loadDBObjects("posts", "source={$user->id} AND original IS NOT NULL", "Post"), "repeat", false, $user),
        Library::create("FAVORITES", loadDBObjects("posts", "id IN (SELECT post FROM favorites WHERE user={$user->id})", "Post"), "start", false, $user)
        );
        return $libs;
    }

    public static function loadFromId($id) {
        $lib = loadDBObject("libraries", "id='{$id}'", "Library");
        return $lib;
    }

    public function getPosts() {
        if ($this->posts)
        return $this->posts;
        logger("library='{$this->id}' AND source={$this->user}");
        return loadDBObjects("posts", "library='{$this->id}' AND source={$this->user}", "Post");
    }

    public function fixVars() {}

    public static function printActivityContainerHtml($timestamp, $libs) {
        $dateStr = date("d M Y", $timestamp);
        ?>
        <div class="exp-card">
            <div class="exp-card-title">
            <h1 class="card-title">+ New Library</h1>
            <h2 class="card-date"><?=$dateStr?></h2>
            </div>
            <div class="exp-card-content">
            <?php
                foreach ($libs as $lib) {
                $lib->printActivityHtml();
                }

                if (sizeof($libs) == 1) {
                ?>
                    <div class="c-button-hold">
                    <a href="">
                        <button class="post-btn closePost" style="float: right">VIEW</button>
                    </a>
                    </div>
                <?php
                }
            ?>
            </div>
        </div>
        <?php
    }

    public function printActivityHtml() {
        ?>
        <div class="exp-card-block">
        <div class="exp-card-square">
            <i class="material-icons card-icon">
            library_books
            </i>
        </div>
        <h1 class="card-library-title"><?=$this->name?></h1>
        </div>
        <?php
    }
}
  
?>