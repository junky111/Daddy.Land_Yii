<?php
$this->title = "Добавить видео";
$this->scripts = <<<"SCRIPTS"
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
    popup = window.open("/image.manager", "Загрузчик картинок", "height=300, width=450, top=300, left=300, scrollbars=1, status=no, resizable=no");
    popup.document.write(msg);
});
if(location.href.indexOf("#error")>-1) {
    var splits = location.href.split("-");
    var res = "";
    if(splits[splits.length-1]==="logo") res += "Не загружена картинка для видео";
    if(splits[splits.length-1]==="content") res += "Нет основного содержания для видео";
    if(splits[splits.length-1]==="title") res += "Не заполнен заголовок для видео";
    if(splits[splits.length-1]==="tags") res += "Не заполнены теги видео";
    if(splits[splits.length-1]==="emptytags") res += "Присутствуют пустые теги";
    $("#error-container").html("<div class='error'>"+res+"</div>");
}
$("input.link").change(function() {
    var ffz = $(this).val().split(/[=\/]/);
    if($(this).val().indexOf("twitch.tv")>-1) {
        $("input[name='PostForm[type]']").val("3");
        $("#preview").html('<center><object type="application/x-shockwave-flash" height="480" width="853" id="live_embed_player_flash" data="http://www.twitch.tv/widgets/live_embed_player.swf?channel='+ffz[ffz.length-1]+'" bgcolor="#000000"><param name="allowFullScreen" value="true" /><param name="allowScriptAccess" value="always" /><param name="allowNetworking" value="all" /><param name="movie" value="http://www.twitch.tv/widgets/live_embed_player.swf" /><param name="flashvars" value="hostname=www.twitch.tv&channel='+ffz[ffz.length-1]+'&auto_play=true&start_volume=25" /></object></center>').show(250);
    }
    if($(this).val().indexOf("youtu")>-1) {
        $("input[name='PostForm[type]']").val("2");
        $("#preview").html('<center><iframe width="853" height="480" src="//www.youtube.com/embed/'+ffz[ffz.length-1]+'?rel=0" frameborder="0" allowfullscreen></iframe></center>').show(250);
    }
});
SCRIPTS;
?>
<div class="post">
    <? if(Env::getCurrentUser()==null) { ?>
        <div class="addpost-needauth">
            Перед добавлением видео необходимо <a href="<?= Env::getVKAuthLink() ?>">авторизоваться</a>.
        </div>
    <? } else { ?>
        <? if(Env::getCurrentUser()->isBanned()) { ?>
            <div class="addpost-needauth">
                Вы не можете постить видео.
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
        <form method="POST" class="addpost addvideo">
            <div class="meta">
                <input type="text" class="title" name="PostForm[title]" placeholder="Заголовок видео" value="<?= Yii::app()->request->cookies['post_title'] ?>">
                <div class="info">
                    <div class="author">
                        <a href="http://vk.com/<?= Env::getCurrentUser()->vkuri ?>" target="_blank">
                            <b><?= Env::getCurrentUser()->nickname ?></b><u>vk.com/<?= Env::getCurrentUser()->vkuri ?></u><img src="<?= Env::getCurrentUser()->avatar ?>">
                        </a>
                    </div>
                </div>
            </div>
            <input name="PostForm[content]" class="link" placeholder="Ссылка на видео/twitch канал" value="<?= Yii::app()->request->cookies['post_content'] ?>">
            <div id="preview"></div>
            <input type="hidden" name="PostForm[type]" value="<?= Yii::app()->request->cookies['post_type']!=null ? Yii::app()->request->cookies['post_type'] : "1" ?>">
            <input type="hidden" name="PostForm[logo]" value="<?= Yii::app()->request->cookies['post_logo'] ?>"> 
            <div class="tags-div">
                <label for="tagsinput" id="tags-label" style="cursor:text;">Теги: </label>
                <input type="text" name="PostForm[tags]" id="tagsinput" placeholder="Dota 2, Железо" class="tags" value="<?= Yii::app()->request->cookies['post_tags'] ?>">
            </div><br>
            <input type="submit" value="Отправить">
            <div class="manager_button">Загрузчик картинок</div>
            <div class="buttons_line"></div>
        </form>
        <br>
    <? }} ?>
</div>