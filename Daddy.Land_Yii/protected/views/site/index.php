<?php $this->initBullets = ".slider-container"; ?>
<?php
$this->scriptsUrls[] = "/js/easing.js";
$this->scriptsUrls[] = "/js/rhinoslider-1.05.min.js";
$this->scripts = <<<'SCRIPTS'
$('#slider').rhinoslider({
    easing: 'easeInOutQuint',
    controlsMousewheel: false,
    controlsKeyboard: false,
    controlsPlayPause: false,
    showBullets: 'never',
    prevText: '',
    nextText: '',
    showTime: 7000,
    autoPlay: true,
    randomOrder: true
});
$(".global-index .filters .showTag").click(function() {
    DaddyLand.selectIndexTag($(this).attr("data-type"));
});
SCRIPTS;
?>
<?php $this->widget("application.components.SliderWidget") ?>
<?php $this->widget("application.components.NewsPanelWidget") ?>