<?php
require_once('api.php');
$post = post::loadFromId($_GET['id']);
$user = user::loadFromId($post->source);
$is_self = false;
if (isset($_GET['SID']))
    $self = user::loadFromSession($_GET['SID']);
$is_self = (isset($self) && $self->id == $user->id);
?>

<div class="meme-preview-box-hover">
    <div class="m-text-box color">
        <div class="m-pp">

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
            <div class="m-likes" onclick="upvotePost('<?=$post->id?>', this);">
            <i class="material-icons m-icon hoverable">keyboard_arrow_up</i>
            <h1 class="m-header"><?=shortNum($post->getUpvotes());?></h1>
            </div>
            <div class="m-reposts">
            <i class="material-icons m-icon hoverable" style="font-size: 23px; margin-top: 1px;">repeat</i>
            <h1 class="m-header"><?=$post->getRepostCount();?></h1>
            </div>
            <div class="m-comments">
            <i class="material-icons m-icon hoverable" style="font-size: 22px; position: relative; top: 4px;">chat_bubble_outline</i>
            <h1 class="m-header">572</h1>
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


            <div class="m-comment">
                <div class="m-c-text-box">
                <div class="c-pp">
                </div>
                <div class="c-names">
                    <h1 class="c-OP">Gaetan Almela</h1>
                    <h1 class="c-handle">@Al</h1>
                </div>
                </div>
                <div class="m-c-para">
                <p class="c-para">
                    Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam</p>
                </div>
                <div class="comment-image"></div>
                <div class="m-c-reviews">
                <div class="m-comment-likes">
                    <i class="material-icons m-comment-icon hoverable">keyboard_arrow_up</i>
                    <h1 class="m-header-comment">522</h1>
                </div>
                <button class="c-op-1 c-reply" style="top: 5px; margin-left: 7px;  ">REPLY</button>
                <i class="material-icons hoverable" style="top: 3px;">more_horiz</i>
                </div>
                <div class="comment-replies">
                <div class="reply-comment">
                    <h1 class="c-OP">Gaetan Almela</h1>
                    <p class="c-para small">
                    Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua.</p>
                    <div class="m-c-reviews reply">
                    <div class="m-comment-likes">
                        <i class="material-icons m-comment-icon reply hoverable">keyboard_arrow_up</i>
                        <h1 class="m-header-comment reply">522</h1>
                    </div>
                    <button class="c-op-1 c-reply reply" style="top: 5px; margin-left: 7px;  ">REPLY</button>
                    <i class="material-icons hoverable" style="top: 2px;   font-size: 24px;">more_horiz</i>
                    </div>
                </div>
                <div class="reply-comment">
                    <h1 class="c-OP">Gaetan Almela</h1>
                    <p class="c-para small">
                    Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor.</p>
                    <div class="comment-image reply"></div>
                    <div class="m-c-reviews reply">
                    <div class="m-comment-likes">
                        <i class="material-icons m-comment-icon reply hoverable">keyboard_arrow_up</i>
                        <h1 class="m-header-comment reply">522</h1>
                    </div>
                    <button class="c-op-1 c-reply reply" style="top: 5px; margin-left: 7px;  ">REPLY</button>
                    <i class="material-icons hoverable" style="top: 2px;   font-size: 24px;">more_horiz</i>
                    </div>
                </div>
                <div class="m-c-reviews" style="margin-left: 0px;">
                    <button class="c-op-1 c-reply" style="top: 5px; margin-left: 0px;  ">SHOW MORE</button>
                </div>
                </div>
            </div>


            <div class="m-comment">

                <div class="m-c-text-box">
                <div class="c-pp">

                </div>
                <div class="c-names">
                    <h1 class="c-OP">Gaetan Almela</h1>
                    <h1 class="c-handle">@Al</h1>
                </div>
                </div>

                <div class="m-c-para">
                <p class="c-para">
                    <span style="font-family: Roboto;font-weight: 700;color: #222;">@bobmandude9889
                    </span> Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip
                    ex ea commodo consequat. Duis aute irure dolor.</p>

                </div>
                <div class="m-c-reviews">
                <div class="m-comment-likes">
                    <i class="material-icons m-comment-icon hoverable">keyboard_arrow_up</i>
                    <h1 class="m-header-comment">522</h1>
                </div>
                <button class="c-op-1 c-reply" style="top: 5px; margin-left: 7px;  ">REPLY</button>
                <i class="material-icons hoverable" style="top: 3px;">more_horiz</i>
                </div>
            </div>
            <div class="m-comment">

                <div class="m-c-text-box">
                <div class="c-pp">

                </div>
                <div class="c-names">
                    <h1 class="c-OP">Gaetan Almela</h1>
                    <h1 class="c-handle">@Al</h1>
                </div>
                </div>

                <div class="m-c-para">
                <p class="c-para">
                    Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor.</p>

                </div>
                <div class="m-c-reviews">
                <div class="m-comment-likes">
                    <i class="material-icons m-comment-icon hoverable">keyboard_arrow_up</i>
                    <h1 class="m-header-comment">522</h1>
                </div>
                <button class="c-op-1 c-reply" style="top: 5px; margin-left: 7px;  ">REPLY</button>
                <i class="material-icons hoverable" style="top: 3px;">more_horiz</i>
                </div>
            </div>
            <div class="m-comment">

                <div class="m-c-text-box">
                <div class="c-pp">

                </div>
                <div class="c-names">
                    <h1 class="c-OP">Gaetan Almela</h1>
                    <h1 class="c-handle">@Al</h1>
                </div>
                </div>

                <div class="m-c-para">
                <p class="c-para">
                    Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor.</p>

                </div>
                <div class="m-c-reviews">
                <div class="m-comment-likes">
                    <i class="material-icons m-comment-icon hoverable">keyboard_arrow_up</i>
                    <h1 class="m-header-comment">522</h1>
                </div>
                <button class="c-op-1 c-reply" style="top: 5px; margin-left: 7px;  ">REPLY</button>
                <i class="material-icons hoverable" style="top: 3px;">more_horiz</i>
                </div>
            </div>
            <div class="m-comment">

                <div class="m-c-text-box">
                <div class="c-pp">

                </div>
                <div class="c-names">
                    <h1 class="c-OP">Gaetan Almela</h1>
                    <h1 class="c-handle">@Al</h1>
                </div>
                </div>

                <div class="m-c-para">
                <p class="c-para">
                    Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor.</p>

                </div>
                <div class="m-c-reviews">
                <div class="m-comment-likes">
                    <i class="material-icons m-comment-icon hoverable">keyboard_arrow_up</i>
                    <h1 class="m-header-comment">522</h1>
                </div>
                <button class="c-op-1 c-reply" style="top: 5px; margin-left: 7px;  ">REPLY</button>
                <i class="material-icons hoverable" style="top: 3px;">more_horiz</i>
                </div>
            </div>
            <div class="m-comment">

                <div class="m-c-text-box">
                <div class="c-pp">

                </div>
                <div class="c-names">
                    <h1 class="c-OP">Gaetan Almela</h1>
                    <h1 class="c-handle">@Al</h1>
                </div>
                </div>

                <div class="m-c-para">
                <p class="c-para">
                    Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor.</p>

                </div>
                <div class="m-c-reviews">
                <div class="m-comment-likes">
                    <i class="material-icons m-comment-icon hoverable">keyboard_arrow_up</i>
                    <h1 class="m-header-comment">522</h1>
                </div>
                <button class="c-op-1 c-reply" style="top: 5px; margin-left: 7px;  ">REPLY</button>
                <i class="material-icons hoverable" style="top: 3px;">more_horiz</i>
                </div>
            </div>
            </div>
        </div>
        </div>
        <div class="comment-box">
        <h1 class="reply-header">In reply to <b>@bobmandude9889</b></h1>
        <textarea name="name" rows="1" cols="10" wrap="hard" class="hover-post-textarea" style="margin-top: 22px;"></textarea>
        <div class="comment-options">
            <button class="material-icons m-meme-icon">video_library</button>
            <button class="material-icons m-meme-icon" style="margin: 0 5px;">gif</button>
            <button class="material-icons m-meme-icon">add_photo_alternate</button>
            <button class="material-icons m-meme-icon main">send</button>
        </div>
        </div>
    </div>

</div>