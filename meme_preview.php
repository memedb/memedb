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
?>

<div class="meme-preview-box-hover">
    <div class="m-text-box color">
        <?php if ($repost) { ?>
            <div class="reposted">
                <i class="material-icons m-icon" style="font-size: 14px; color: #fff; top: 0">repeat</i>
                <h1 class="m-handle" style="color: #fff; position: relative; float: left; margin-left: 5px;">@<?=$reposter->handle?></h1>
            </div>
        <?php } ?>
        <div class="m-pp">
            <img src="<?= $user->getImage(); ?>" style="border: inherit; border-radius: inherit;" width="30" height="30">
        </div>
        <div class="m-names">
        <h1 class="m-OP light"><?= $user->name; ?></h1>
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
              <i class="material-icons m-icon hoverable<?= $post->getVote($self) == 1 ? " vote-selected" : "" ?>" onclick="upvotePost('<?=$post->id?>');">keyboard_arrow_up</i>
              <h1 class="m-header" id="votes_<?=$post->id?>"><?=shortNum($post->getVotes());?></h1>
              <i class="material-icons m-icon hoverable<?= $post->getVote($self) == -1 ? " vote-selected" : "" ?>" onclick="downvotePost('<?=$post->id?>');">keyboard_arrow_down</i>
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
                    ?>
                        <div class="m-comment">
                            <div class="m-c-text-box">
                            <div class="c-pp">
                            </div>
                            <div class="c-names">
                                <h1 class="c-OP"><?=$cUser->name;?></h1>
                                <h1 class="c-handle">@<?=$cUser->handle;?></h1>
                            </div>
                            </div>
                            <div class="m-c-para">
                            <?php
                                $split = explode("\n", $cmt->text);
                                foreach ($split as $line) {
                                ?>
                                <p class="c-para" style="min-height: 1em;">
                                    <?=$line?>
                                </p>
                            <?php } ?>
                            </div>
                            <!-- <div class="comment-image"></div> -->
                            <div class="m-c-reviews">
                            <div class="m-comment-likes">
                                <i class="material-icons m-comment-icon hoverable<?= $cmt->getVote($self) == 1 ? " vote-selected" : "" ?>" onclick="upvoteComment('<?=$cmt->id?>');">keyboard_arrow_up</i>
                                <h1 class="m-header-comment" id="votes_<?=$cmt->id?>"><?=$cmt->getVotes();?></h1>
                                <i class="material-icons m-comment-icon hoverable<?= $cmt->getVote($self) == -1 ? " vote-selected" : "" ?>" onclick="downvoteComment('<?=$cmt->id?>');">keyboard_arrow_down</i>
                            </div>
                            <button class="c-op-1 c-reply" style="top: 5px; margin-left: 7px;" onclick="reply('<?=$cmt->id?>', '<?=$cUser->handle?>');">REPLY</button>
                            <i class="material-icons hoverable" style="top: 3px;">more_horiz</i>
                            </div>
                            <div class="comment-replies">
                                <?php
                                    $replies = $cmt->getReplies();
                                    $i = 0;
                                    foreach ($replies as $reply) {
                                        $rUser = user::loadFromId($reply->user);
                                ?>
                                        <div class="reply-comment">
                                            <h1 class="c-OP"><?=$rUser->name?></h1>
                                            <?php
                                                $split = explode("\n", $reply->text);
                                                foreach ($split as $line) {
                                             ?>
                                                <p class="c-para small" style="min-height: 1em;">
                                                    <?=$line?>
                                                </p>
                                            <?php } ?>
                                            <div class="m-c-reviews reply">
                                            <div class="m-comment-likes">
                                                <i class="material-icons m-comment-icon hoverable<?= $reply->getVote($self) == 1 ? " vote-selected" : "" ?>" onclick="upvoteComment('<?=$reply->id?>');">keyboard_arrow_up</i>
                                                <h1 class="m-header-comment" id="votes_<?=$reply->id?>"><?=$reply->getVotes();?></h1>
                                                <i class="material-icons m-comment-icon hoverable<?= $reply->getVote($self) == -1 ? " vote-selected" : "" ?>" onclick="downvoteComment('<?=$reply->id?>');">keyboard_arrow_down</i>
                                            </div>
                                            <button class="c-op-1 c-reply reply" style="top: 5px; margin-left: 7px;" onclick="reply('<?=$cmt->id?>', '<?=$rUser->handle?>');">REPLY</button>
                                            <i class="material-icons hoverable" style="top: 2px;   font-size: 24px;">more_horiz</i>
                                            </div>
                                        </div>
                                    <?php
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
                        </div>
                    <?php } ?>
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
