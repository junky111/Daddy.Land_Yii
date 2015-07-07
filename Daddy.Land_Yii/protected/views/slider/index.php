<?
$this->title = "Слайдер";
?><ul class="users slides">
    <li>
        <form method="post" action="/slider/create">
            <input type="text" name="name" placeholder="Название слайда"><input type="submit" value="Создать">
        </form>
    </li>
    <?
        foreach ($slides as $slide) {
            ?> <li><a href='/slider/edit/<?= $slide->id ?>'><?= $slide->name ?></a> <?= $slide->visible ? "<a class='back' href='/slider/hide/".$slide->id."'>Скрыть</a>" : "<a class='back' href='/slider/show/".$slide->id."'>Показать</a>" ?></li> <?
        }
    ?>
</ul>