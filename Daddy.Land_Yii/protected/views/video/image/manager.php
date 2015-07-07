<!DOCTYPE html>
<html>
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
        <title>Загрузчик картинок</title>
        <link rel="stylesheet" type="text/css" href="/styles/style.css">
        <script src="/js/jquery.min.js"></script>
        <script src="/js/daddyland.js"></script>
        <script>
            $(document).ready(function() {
                
                DaddyLand.uploadImageHandler("form.form-image-uploader", function(resp) {
                    if(resp!==null) {
                        var k = resp.split("/");
                        var newImage = $( "<div/>", {
                            class: 'image-line',
                            html: "<div class='image-preview' style='background-image: url("+resp+");background-size: cover;'></div><div class='image-link'><a href=\""+resp+"\">Ссылка на "+k[k.length-1]+"</a></div>"
                        });
                        newImage.insertAfter(".image-line:first-child");
                    }});
                });
        </script>
    </head>
    <body>
        <div class="imagemanager">
            <div class="image-line">
                <div class="image-uploader">
                    <form method="POST" class="form-image-uploader">
                        <input id="ytImage_image" type="hidden" value="" name="Image[image]">
                        <input name="Image[image]" class='fileInput' id="Image_image" type="file">
                    </form>
                    Загрузить картинку <span></span>
                </div>
            </div>
            <? foreach ($me->getImages() as $image) { ?>
                <? if($image=="." || $image=="..") continue; ?>
                <? $im = explode("/", $image);?>
                <div class="image-line">
                    <div class='image-preview' style='background-image: url("/image/view/?url=u<?= $me->id ?>/<?= $im[count($im) -1] ?>");background-size: cover;'></div>
                    <div class='image-link'><a href="/image/view/?url=u<?= $me->id ?>/<?= $im[count($im) -1] ?>">Ссылка на <?= $im[count($im) -1] ?></a></div>
                </div>
            <? } ?>
        </div>
    </body>
</html>
