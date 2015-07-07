<?php
$this->title = "Редактировать новость";
$this->scriptsUrls[] = "/styles/ckeditor/ckeditor.js";
$this->scripts = <<<"SCRIPTS"
var previewActive = false;
$(".preview_button").click(
    function() {
        previewActive = !previewActive;
        DaddyLand.postPreview(previewActive);
    });
DaddyLand.uploadImageHandler("form.biglogo", function(resp) {
    if(resp!==null) {
        $(".biglogo-uploader").css("background-image", "url("+resp+")").css("background-size", "cover").css("border", "none").css("width", "1000px").css("height", "400px");
        $(".biglogo-uploader p").css("display", "none");
        $("form.addpost input[name='PostForm[logo]']").val(resp);
    } else {
        $(".biglogo-uploader").css("background", "none").css("background-size", "cover").css("border", "1px dashed #565553").css("width", "998px").css("height", "398px");
        $(".biglogo-uploader p").css("display", "block");
        $("form.addpost input[name='PostForm[logo]']").val("");
    }
});
$(".manager_button").click(function() {
    popup = window.open("/image/manager/", "Загрузчик картинок", "height=300, width=450, top=300, left=300, scrollbars=1, status=no, resizable=no");
    popup.document.write(msg);
});
if(location.href.indexOf("#error")>-1) {
    var splits = location.href.split("-");
    var res = "";
    if(splits[splits.length-1]==="logo") res += "Не загружена картинка новости";
    if(splits[splits.length-1]==="content") res += "Нет основного содержания новости";
    if(splits[splits.length-1]==="desc") res += "Нет описания новости";
    if(splits[splits.length-1]==="title") res += "Не заполнен заголовок новости";
    if(splits[splits.length-1]==="tags") res += "Не заполнены теги новости";
    if(splits[splits.length-1]==="emptytags") res += "Присутствуют пустые теги";
    if(splits[splits.length-1]==="banned") res += "Вы в бане";
    $("#error-container").html("<div class='error'>"+res+"</div>");
}
SCRIPTS;
?>
<div class="post">
    <? if(Env::getCurrentUser()==null) { ?>
        <div class="addpost-needauth">
            Перед редактированием поста необходимо <a href="<?= Env::getVKAuthLink() ?>">авторизоваться</a>.
        </div>
    <? } else { ?>
        <? if(Env::getCurrentUser()->isBanned() || !$post->isAbleToEdit(Env::getCurrentUser())) { ?>
            <div class="addpost-needauth">
                Вы не можете редактировать новости.
            </div>
        <? } else { ?>
        <div class="post-image">
            <div class="biglogo-uploader" style="background-image: url('<?= $post->logo ?>');background-size: cover;">
                <form class="biglogo">
                    <input id="ytImage_image" type="hidden" value="" name="Image[image]">
                    <input name="Image[image]" class='fileInput' id="Image_image" type="file">
                </form>
            </div>
        </div>
        <div id="error-container"></div>
        <form method="POST" class="addpost">
            <div class="meta">
                <input type="hidden" name="PostForm" value="1">
                <input type="text" class="title" name="PostForm[title]" placeholder="Заголовок новости" value="<?= $post->title ?>">
                <div class="info">
                    <div class="author">
                        <a href="http://vk.com/<?= $post->getUser()->vkuri ?>" target="_blank">
                            <b><?= $post->getUser()->nickname ?></b><u>vk.com/<?= $post->getUser()->vkuri ?></u><img src="<?= $post->getUser()->avatar ?>">
                        </a>
                    </div>
                    <div class="counts">
                        <i class="icon-calendar"></i><b><?= date("d.m.Y H:i:s", time()) ?></b>
                        <div>
                            <span class="count-visits"><i class="icon-eye"></i><b id="views_count"><?= $post->views ?></b></span>
                            <i class="icon-bubbles"></i><b><?= $post->getCommentsCount() ?></b>
                        </div>
                    </div>
                </div>
                <textarea class="intro" name="PostForm[desc]" placeholder="Описание поста"><?= $post->desc ?></textarea>
            </div>
            <textarea id="editor1" name="PostForm[content]" rows="10" cols="80"><?= $post->content ?></textarea>
            <script>CKEDITOR.replace('editor1');</script>
            <input type="hidden" name="PostForm[type]" value="<?= $post->type ?>">
            <input type="hidden" name="PostForm[logo]" value="<?= $post->logo ?>"> 
            <div class="tags-div">
                <label for="tagsinput" id="tags-label" style="cursor:text;">Теги: </label>
                <input type="text" name="PostForm[tags]" id="tagsinput" placeholder="Dota 2, Железо" class="tags" value="<?= $post->getTagsAsString() ?>">
            </div><br>
            <input type="submit" value="Отправить">
            <div class="preview_button">Предпросмотр</div>
            <div class="manager_button">Загрузчик картинок</div>
            <div class="buttons_line"></div>
            <br>
        </form>
    <? }} ?>
</div>