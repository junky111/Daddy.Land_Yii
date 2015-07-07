<? 
$this->title = "Списки пользователей";
?>
<ul class="users">
    <li>
        <form method="post" action="/list/add/<?= $id ?>">
            <input type="text" name="param" placeholder="id123123 или никнейм"><input type="submit" value="Добавить">
        </form>
    </li>
    <?
        foreach($users as $user) {
            ?> <li><img src="<?= $user->avatar ?>" width='50'><a href='http://vk.com/<?= $user->vkuri ?>'><?= $user->nickname ?></a> <a class='back' href='/list/delete/<?= $user->id ?>'>Отменить</a></li> <?
        }
    ?>
</ul>