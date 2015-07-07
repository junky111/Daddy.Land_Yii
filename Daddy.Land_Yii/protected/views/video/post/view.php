<?php
/* @var $post Post */
$this->title = $post->title;
$this->initBullets = ".post-image";
$this->scriptsUrls[] = "//vk.com/js/api/openapi.js?115";
$this->scriptRun = <<<"SCRIPTS"
    VK.init({apiId: 4328323, onlyWidgets: true});
SCRIPTS;
$this->scripts = <<<"SCRIPTS"
if(location.href.indexOf("#adderror")>-1) {
    $("#error-container").html("<div class='error'>Ошибка при добавлении комментария</div>");
}
var imgs = $("p img");
for(var i = 0; i < imgs.length; i++) {
    if(imgs.eq(i).css("width")==="920px") {
        imgs.eq(i).parent().css("padding-left", "0px").css("padding-right", "0px");
    }
}
SCRIPTS;
?>
<div class='post'>
    <? if($post==null) { ?>
        <div class="meta">
            <h1>Новость не найдена</h1>
        </div>
    <? } else { ?>
        <div class="post-image" style="background-image: url(<?= $post->logo ?>);background-size:cover;"></div>
        <div class="meta">
            <h1><?= $post->title ?></h1>
            <div class="info">
                <div class="author">
                    <a href="http://vk.com/<?= $post->getUser()->vkuri ?>" target="_blank">
                        <b><?= $post->getUser()->nickname ?></b><u>vk.com/<?= $post->getUser()->vkuri ?></u><img src="<?= $post->getUser()->avatar ?>">
                    </a>
                </div>
                <div class="counts">
                    <i class="icon-calendar"></i><b><?= date("d.m.Y H:i:s", $post->time) ?></b>
                    <div>
                        <span class="count-visits"><i class="icon-eye"></i><b id="views_count"><?= $post->views ?></b></span>
                        <i class="icon-bubbles"></i><b><?= $post->getCommentsCount() ?></b>
                    </div>
                </div>
            </div>
            <div class="intro">
                <p><?= $post->desc ?></p>
            </div>
        </div>
        <div id="vk_like"></div>
        <script type="text/javascript">
            VK.Widgets.Like("vk_like", {type: "button", verb: 1});
        </script>
        <div class="content">
            <?= $post->content ?>
            <? if($post->isAbleToEdit(Env::getCurrentUser())) { ?><div id="edit-container"><a href="/post/edit/<?= $post->id ?>">Редактировать</a> | <a href="/post/delete/<?= $post->id ?>">Удалить</a></div><? } ?>
        </div>
    <? } ?>
    <div id="error-container"></div>
    <div class="comments">
        <a id="firstcomment"></a>
        <? foreach($post->getComments(20) as $comment) { ?>
        <div class="comment" id="comment<?= $comment->id ?>" data-id="<?= $comment->id ?>">
            <div class="caption">
                <a href="http://vk.com/<?= $comment->getUser()->vkuri ?>" title="<?= $comment->getUser()->nickname ?>" class="user" rel="nofollow">
                    <b><?= $comment->getUser()->nickname ?></b>
                    <img src="<?= $comment->getUser()->avatar ?>">
                </a>
                <a href="#comment<?= $comment->id ?>" class="time">
                    <abbr class="timeago" title="<?= date("d.m.Y H:i:s", $comment->time) ?>"><?= date("d.m.Y H:i:s", $comment->time) ?></abbr><? if($comment->isAbleToEdit(Env::getCurrentUser())) {?> | <a href="/post/clear/<?= $comment->id ?>">Удалить</a><?} ?>
                </a>
            </div>
            <div class="text">
                <p><?= $comment->content ?></p>
            </div>
        </div>
        <? } ?>
        <div class="comment add-form">
            <? if(Env::getCurrentUser()!=null && $post!=null) { ?>
            <? if(Env::getCurrentUser()->isBanned()) { ?>
                Вы не можете оставлять комментарии.
            <? } else { ?>
            <form method="POST" action="/post/comment/<?= $post->id ?>" class="addcomment">
                <img src="<?= Env::getCurrentUser()->avatar ?>" width="106">
                <input type="submit" value="Отправить">
                <textarea name="CommentForm[content]"></textarea>
            </form>
            <? }} else { ?>
            Для добавления комментариев необходимо <a href="<?= Env::getVKAuthLink() ?>">авторизоваться</a>.
            <? } ?>
        </div>
    </div>
</div>