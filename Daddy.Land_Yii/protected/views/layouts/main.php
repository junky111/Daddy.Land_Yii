<!DOCTYPE html>
<html>
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
        <title><?= $this->title ?> | DaddyLand</title>
        <script src="/js/jquery.min.js"></script>
        <script src="/js/daddyland.js"></script>
        <?
            foreach ($this->stylesUrls as $style) {
                ?><link rel="stylesheet" type="text/css" href="<?= $style ?>" /><?
            }
            foreach ($this->scriptsUrls as $script) {
                ?><script src="<?= $script ?>"></script><?
            }
        ?>
        <link rel="stylesheet" type="text/css" href="<?= Yii::app()->request->baseUrl ?>/styles/style.css">
        <script>
            <?= $this->scriptRun ?>
            $(document).ready(function() {
                <? if(!empty($this->initBullets)) { ?>
                    DaddyLand.initializeRightBullets($("<?= $this->initBullets ?>").outerHeight());
                <? } else { ?>
                    DaddyLand.disableRightBullets();
                <? } ?>
                <?= $this->scripts ?>
            });
        </script>
    </head>
    <body>
        <div class="global global-index">
            <?php $this->widget("application.components.LeftWidget") ?>
            <?php $this->widget("application.components.RightWidget") ?>
            <? echo $content; ?>
        </div>
    </body>
</html>
