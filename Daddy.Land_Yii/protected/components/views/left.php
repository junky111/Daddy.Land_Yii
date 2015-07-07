<div class="left-container">
    <div class="menu"></div>
    <div class="menu-lay">
        <div class="logo">
            <a href="<?= Yii::app()->homeUrl ?>">
                <img src="<?= Yii::app()->request->baseUrl ?>/images/biglogo.png" width="90">
            </a>
        </div>
        <p>Daddy Land</p>
        <a href="<?= Yii::app()->homeUrl ?>">Главная</a>
        <a href="http://vk.com/daddyland" target="_blank">Паблик ВКонтакте</a>
        <a href="http://twitch.tv/dotadaddy" target="_blank">Твичанский</a>
    </div>
    <div class="login">
        <?= Env::getCurrentUser()==null ? "" : "<img src=\"".Env::getCurrentUser()->avatar."\" width=\"50\">" ?></div>
    <div class="login-lay">
        <? if(Env::getCurrentUser()==null) { ?>
        <a href="<?= Env::getVKAuthLink() ?>" class="log-link">Войти через VK</a>
        <? } else { ?>
            <div class="logo">
                <!--<a href="user?<?= Env::getCurrentUser()->id ?>">-->
                    <img src="<?= Env::getCurrentUser()->avatar ?>" width="100">
                <!--</a>-->
            </div>
            <p><?= Env::getCurrentUser()->nickname ?></p>
            <a href="http://vk.com/<?= Env::getCurrentUser()->vkuri ?>" target="_blank">Страница ВКонтакте</a>
            <? if(Env::getCurrentUser()->group>2) { ?>
                <a href="/list/3">Админы</a>
                <a href="/list/2">Редакторы</a>
                <a href="/slider/">Слайдер</a>
            <? } ?>
            <? if(Env::getCurrentUser()->group>1) { ?>
                <a href="/list/0">Баны</a>
            <? } ?>
            <a href="/login/logout">Выход</a>
        <? } ?>
    </div>
    <div class="hinttext">
        <?= Yii::app()->params['hintText'] ?>
    </div>
</div>