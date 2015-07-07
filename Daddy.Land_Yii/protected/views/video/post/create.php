<?php
$this->title = "Добавить новость";
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
            Перед добавлением поста необходимо <a href="<?= Env::getVKAuthLink() ?>">авторизоваться</a>.
        </div>
    <? } else { ?>
        <? if(Env::getCurrentUser()->isBanned()) { ?>
            <div class="addpost-needauth">
                Вы не можете создавать новости.
            </div>
        <? } else { ?>
        <div class="post-image">
            <? if(Yii::app()->request->cookies['post_logo']!=null) { ?>
                <div class="biglogo-uploader" style="background-image: url('<?= Yii::app()->request->cookies['post_logo'] ?>');background-size: cover;">
                    <form class="biglogo">
                        <input id="ytImage_image" type="hidden" value="" name="Image[image]">
                        <input name="Image[image]" class='fileInput' id="Image_image" type="file">
                    </form>
                </div>
            <? } else { ?>
                <div class="biglogo-uploader">
                    <form class="biglogo">
                        <p>Загрузить картинку(1000x400) <span></span></p>
                        <input id="ytImage_image" type="hidden" value="" name="Image[image]">
                        <input name="Image[image]" class='fileInput' id="Image_image" type="file">
                    </form>
                </div>
            <? } ?>
        </div>
        <div id="error-container"></div>
        <form method="POST" class="addpost">
            <div class="meta">
                <input type="hidden" name="PostForm" value="1">
                <input type="text" class="title" name="PostForm[title]" placeholder="Заголовок новости" value="<?= Yii::app()->request->cookies['post_title'] ?>">
                <div class="info">
                    <div class="author">
                        <a href="http://vk.com/<?= Env::getCurrentUser()->vkuri ?>" target="_blank">
                            <b><?= Env::getCurrentUser()->nickname ?></b><u>vk.com/<?= Env::getCurrentUser()->vkuri ?></u><img src="<?= Env::getCurrentUser()->avatar ?>">
                        </a>
                    </div>
                    <div class="counts">
                        <i class="icon-calendar"></i><b><?= date("d.m.Y H:i:s", time()) ?></b>
                        <div>
                            <span class="count-visits"><i class="icon-eye"></i><b id="views_count">0</b></span>
                            <i class="icon-bubbles"></i><b>0</b>
                        </div>
                    </div>
                </div>
                <textarea class="intro" name="PostForm[desc]" placeholder="Описание поста"><?= Yii::app()->request->cookies['post_desc'] ?></textarea>
            </div>
            <textarea id="editor1" name="PostForm[content]" rows="10" cols="80"><?= Yii::app()->request->cookies['post_content'] ? Yii::app()->request->cookies['post_content'] : "Содержание поста(редактируется)" ?></textarea>
            <script>CKEDITOR.replace('editor1');</script>
            <input type="hidden" name="PostForm[type]" value="<?= Yii::app()->request->cookies['post_type'] ? Yii::app()->request->cookies['post_type'] : "1" ?>">
            <input type="hidden" name="PostForm[logo]" value="<?= Yii::app()->request->cookies['post_logo'] ?>"> 
            <div class="tags-div">
                <label for="tagsinput" id="tags-label" style="cursor:text;">Теги: </label>
                <input type="text" name="PostForm[tags]" id="tagsinput" placeholder="Dota 2, Железо" class="tags" value="<?= Yii::app()->request->cookies['post_tags'] ?>">
            </div><br>
            <input type="submit" value="Отправить">
            <div class="preview_button">Предпросмотр</div>
            <div class="manager_button">Загрузчик картинок</div>
            <div class="buttons_line"></div>
            <br>
        </form>
    <? }} ?>
</div>