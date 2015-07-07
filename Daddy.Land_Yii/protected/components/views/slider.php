<div class='slider-container'>
    <ul id="slider">
        <?
        foreach ($slides as $slide) {
                ?><li><?= $slide->content ?></li><?
            }
        ?>
    </ul>
</div>