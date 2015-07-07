<?
$this->title = "Редактирование слайда";
$this->stylesUrls[] = "/styles/markitup/skins/markitup/style.css";
$this->stylesUrls[] = "/styles/markitup/sets/html/style.css";
$this->scriptsUrls[] = "/styles/markitup/jquery.markitup.js";
$this->scriptsUrls[] = "/styles/markitup/sets/html/set.js";
$this->scripts = <<<"SCRIPTS"
$(".preview_button").click(
    function() {
        previewActive = !previewActive;
        DaddyLand.postPreview(previewActive);
    });
$(".manager_button").click(function() {
    popup = window.open("/image/manager", "Загрузчик картинок", "height=300, width=450, top=300, left=300, scrollbars=1, status=no, resizable=no");
    popup.document.write(msg);
});
if(location.href.indexOf("#error")>-1) {
    var splits = location.href.split("-");
    var res = "";
    if(splits[splits.length-1]==="name") res += "Нет названия слайдера";
    if(splits[splits.length-1]==="content") res += "Нет основного содержания слайдера";
    if(splits[splits.length-1]==="banned") res += "Вы в бане";
    $("#error-container").html("<div class='error'>"+res+"</div>");
}
$('#editor1').markItUp(mySettings);
SCRIPTS;
?>
<div class="post">
    <? if(Env::getCurrentUser()==null || Env::getCurrentUser()->group<3) { ?>
        <div class="addpost-needauth">
            Недостаточно прав для редактирование слайда.
        </div>
    <? } else { ?>
        <div id="error-container"></div>
        <form method="POST" class="addpost addslide" action="/slider/edit/<?= $slide->id ?>">
            <div class="meta">
                <input type="text" class="title" name="SlideForm[name]" placeholder="Название слайда" value="<?= $slide->name ?>">
            </div>
            <textarea id="editor1" name="SlideForm[content]" rows="10" cols="80"><?= $slide->content ?></textarea>
            <br>
            <input type="submit" value="Сохранить">
            <div class="manager_button">Загрузчик картинок</div>
            <div class="buttons_line"></div>
        </form>
    <? } ?>
</div>