<?php
require_once('api.php');
$repost = false;
$reposter = null;
$post = post::loadFromId($_GET['id']);
if ($post->original != null) {
    $reposter = user::loadFromId($post->source);
    $post = post::loadFromId($post->original);
    $repost = true;
}
$user = user::loadFromId($post->source);
$self = null;
$is_self = false;
if (isset($_GET['SID']))
    $self = user::loadFromSession($_GET['SID']);
$is_self = (isset($self) && $self->id == $user->id);

function printVotes($obj, bool $comment) {
    ?>
    <i class="material-icons m<?= $comment ? "-comment" : "" ?>-icon hoverable<?= $obj->getVote($self) == 1 ? " vote-selected" : "" ?>" onclick="upvote<?= $comment ? "Comment" : "Post" ?>('<?=$obj->id?>');">keyboard_arrow_up</i>
    <h1 class="m-header<?= $comment ? "-comment" : "" ?>" id="votes_<?=$obj->id?>"><?=shortNum($obj->getVotes());?></h1>
    <i class="material-icons m<?= $comment ? "-comment" : "" ?>-icon hoverable<?= $obj->getVote($self) == -1 ? " vote-selected" : "" ?>" onclick="downvote<?= $comment ? "Comment" : "Post" ?>('<?=$obj->id?>');">keyboard_arrow_down</i>
    <?php
}

function printComment(comment $cmt, bool $reply) {
    $cUser = user::loadFromId($cmt->user);
    ?>
    
    <div class="<?= $reply ? "reply" : "m" ?>-comment">
        <?php if (!$reply) {?>
        <div class="m-c-text-box">
            <div class="c-pp">
                <?php $cUser->printImage(25, "border: inherit; border-radius: inherit;"); ?>
            </div>
            <div class="c-names">
        <?php } ?>
                <a href="<?=$cUser->getLink()?>"><h1 class="c-OP"><?=$cUser->name;?></h1></a>
        <?php if (!$reply) {?>
                <h1 class="c-handle">@<?=$cUser->handle;?></h1>
            </div>
        </div>
        <div class="m-c-para">
        <?php } ?>
        <?php
            $split = explode("\n", $cmt->text);
            foreach ($split as $line) {
            ?>
            <p class="c-para<?= $reply ? " small" : "" ?>" style="min-height: 1em;">
                <?=$line?>
            </p>
        <?php }
        if (!$reply) {?>
        </div>
        <?php } ?>
        <!-- <div class="comment-image"></div> -->
        <div class="m-c-reviews<?= $reply ? " reply" : "" ?>">
            <div class="m-comment-likes">
                <?php printVotes($cmt, true); ?>
            </div>
            <button class="c-op-1 c-reply<?= $reply ? " reply" : "" ?>" style="top: 5px; margin-left: 7px;" onclick="reply('<?=$cmt->id?>', '<?=$cUser->handle?>');">REPLY</button>
            <i class="material-icons hoverable" style="top: 3px;">more_horiz</i>
        </div>
        <?php if (!$reply) {?>
        <div class="comment-replies">
            <?php
                $replies = $cmt->getReplies();
                $i = 0;
                foreach ($replies as $reply) {
                    $rUser = user::loadFromId($reply->user);
                    printComment($reply, true);
                    if ($i == 1) {
                ?>
                    <div class="comments_hidden" id="hidden_<?=$reply->parent?>" style="display: none;">
                <?php
                    }
                    $i++;
                }
                if ($i >= 2) {
                ?>
                    </div>
                    <div class="m-c-reviews" style="margin-left: 0px;">
                        <button class="c-op-1 c-reply" style="top: 5px; margin-left: 0px;" onclick="showMore('<?=$reply->parent?>', this);">SHOW MORE</button>
                        <button class="c-op-1 c-reply" style="top: 5px; margin-left: 0px; display: none;" onclick="showLess('<?=$reply->parent?>', this);">SHOW LESS</button>
                    </div>
                <?php } ?>
        </div>
        <?php } ?>
    </div>
    <?php
}
?>

<div class="meme-preview-box-hover">
    <div class="m-text-box color">
        <?php if ($repost) { ?>
            <div class="reposted">
                <i class="material-icons m-icon" style="font-size: 14px; color: #fff; top: 0">repeat</i>
                <a href="<?=$reposter->getLink()?>"><h1 class="m-handle" style="color: #fff; position: relative; float: left; margin-left: 5px;">@<?=$reposter->handle?></h1></a>
            </div>
        <?php } ?>
        <div class="m-pp">
            <?php $user->printImage(30, "border: inherit; border-radius: inherit;"); ?>
        </div>
        <div class="m-names">
        <a href="<?=$user->getLink()?>"><h1 class="m-OP light"><?= $user->name; ?></h1></a>
        <h1 class="m-handle light">@<?= $user->handle; ?></h1>
        </div>
        <button id="follow-btn" onclick="followAction(this);" data-handle="<?= $user->handle?>" class="<?php echo ($is_self ? "follow-self" : ($self->isFollowing($user->id) ? "unfollow" : "follow")) ?> mp">
            <span><?= $user->getFormattedFollowerCount(); ?></span>
        </button>
    </div>
    <?php
        $size = getimagesize("./images/" . ($post->original ? $post->original : $post->id) . "." . $post->type);
        $height = ($size[1]/$size[0]) * 600;
    ?>

    <div class="m-new-container-hover" style="grid-template-rows: <?=$height;?>px minmax(150px, auto);">
        <div class="meme-img-hover">
            <img src="<?="/images/" . ($post->original ? $post->original : $post->id) . "." . $post->type;?>" style="width: 100%; height: 100%;">
        </div>
        <div class="m-desc-hover">
            <div class="m-post-info">
                <div class="m-likes">
                <?php printVotes($post, false); ?>
                </div>
                <div class="m-reposts" onclick="repost('<?=$post->id?>', this);">
                <i class="material-icons m-icon hoverable<?= $post->hasReposted($self) ? " vote-selected" : "" ?>" style="font-size: 23px; margin-top: 1px;">repeat</i>
                <h1 class="m-header"><?=$post->getRepostCount();?></h1>
                </div>
                <div class="m-comments">
                <i class="material-icons m-icon hoverable" style="font-size: 22px; position: relative; top: 4px;" onclick="focusComment();">chat_bubble_outline</i>
                <h1 class="m-header"><?=$post->getCommentCount()?></h1>
                </div>
                <div class="m-save">
                <i class="material-icons m-icon hoverable" style="float: left;">save</i>
                </div>
                <h1 class="m-date"><?= date("d M Y", strtotime($post->date)); ?></h1>
            </div>

            <p class="m-para"><?=$post->caption;?></p>

            <div class="m-tags">
            <?php
            if (count($post->tags) > 0) {
                for ($i = 0; $i < count($post->tags); $i++) {
                    $tag = $post->tags[$i];
                    ?>
                    <div class="type m"><?=$tag?></div>
                    <?php
                }
            }
            ?>
            </div>

        </div>
        <div class="m-comment-bar">
            <div class="m-comment-wrapper-hover">
                <div class="m-comments-s">
                    <?php

                    $comments = $post->getComments();
                    foreach ($comments as $cmt) {
                        $cUser = user::loadFromId($cmt->user);
                        printComment($cmt, false);
                    } ?>
                </div>
            </div>
        </div>
        <div class="comment-box">
            <h1 class="reply-header" id="reply_to" style="display: none;">In reply to <b>@bobmandude9889</b></h1>
            <textarea name="comment_text" id="comment_text" rows="1" cols="10" wrap="hard" class="hover-post-textarea"></textarea>
            <div class="comment-options">
                <button class="material-icons m-meme-icon">video_library</button>
                <button class="material-icons m-meme-icon" style="margin: 0 5px;">gif</button>
                <button class="material-icons m-meme-icon">add_photo_alternate</button>
                <button class="material-icons m-meme-icon main" onclick="postComment();">send</button>
            </div>
        </div>
    </div>

</div>
