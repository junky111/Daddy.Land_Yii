<div class="filters">
    Самые популярные теги: 
    <?
        $first = true;
        foreach($tags as $tag) {
            ?><?= $first ? "" : ", " ?><span><a class='showTag' data-type='<?= $tag[1]->name ?>'><?= $tag[1]->name ?></a></span><?
            $first = false;
        }
    ?>
</div>
<div class="news">
    <?
        $generateChance = 70;
        $blockedPoints = array();
        $adminLine = true;
        for($q = 0; $q < $this->postsAmount / 5; $q++) {
            ?><div class="line"><?
            for($qi = $q*5; $qi < $q*5+5 && $qi < $this->postsAmount; $qi++) {
                $styleBig = false;
                if(in_array($qi, $blockedPoints)) {continue;}
                if($qi!=$q*5+4 && $q != 4) {
                    if(rand(0, 100)<$generateChance && !in_array($qi+1, $blockedPoints) && !in_array($qi+5, $blockedPoints) && !in_array($qi+6, $blockedPoints)) {
                        $generateChance = 5;
                        $styleBig = true;
                        $blockedPoints[] = $qi;
                        $blockedPoints[] = $qi +1;
                        $blockedPoints[] = $qi +5;
                        $blockedPoints[] = $qi +6;
                    } else {
                        $generateChance += 10;
                    }
                }
                $us = true;
                if($adminLine) {
                    $us = true;
                } else {
                    $us = false;
                }
                if(count($adminPosts)==0) {
                    $us = false;
                }
                
                $p = $us ? array_shift($adminPosts) : array_shift($userPosts);
                switch($p->type) {
                    case 1:
                        ?><a class="new <?= $styleBig ? "big" : "" ?>" href="post/<?= $p->id ?>" data-type="<?= join(",",$p->getTagsAsStrings()) ?>" style='left:<?= ($qi % 5)*200 ?>px;top:<?= $q*160 ?>px;'>
                        <div class="title"><?= $p->title ?></div>
                        <div class="cont"><div class="new-image" style="background-image: url(<?= $p->logo ?>);background-size: cover;background-position:center;"></div></div>
                        </a><?
                        break;
                    case 2:
                        ?><a class="new youtube-new <?= $styleBig ? "big" : "" ?>" data-type="<?= join(",",$p->getTagsAsStrings()) ?>" style='left:<?= ($qi % 5)*200 ?>px;top:<?= $q*160 ?>px;'>
                        <div class="title"><?= $p->title ?></div>
                        <div class="cont"><div class="new-image" style="background-image: url(<?= $p->logo ?>);background-size: cover;background-position:center;"></div></div>
                        <div class="lay youtube-lay" data-type="<?= $p->content ?>=youtube"></div>
                        </a><?
                       break;
                    case 3:
                        ?><a class="new twitch-new <?= $styleBig ? "big" : "" ?>" data-type="<?= join(",",$p->getTagsAsStrings()) ?>" style='left:<?= ($qi % 5)*200 ?>px;top:<?= $q*160 ?>px;'>
                        <div class="title"><?= $p->title ?></div>
                        <div class="cont"><div class="new-image" style="background-image: url(<?= $p->logo ?>);background-size: cover;background-position:center;"></div></div>
                        <div class="lay twitch-lay" data-type="<?= $p->content ?>=twitch"></div>
                        </a><?
                        break;
                    }
            }
            ?></div><?
            $adminLine = false;
        }
    ?>
</div>
<div class="pages">
    <?
        $start = 1;
        if($this->offset>5) $start = $this->offset-5;
        for($i = $start; $i<$start+10; $i++) {
            if($i>$this->maxPages) break;
            ?> <a href="?page=<?= $i ?>"<?= ($this->offset)==$i ? "style='color:white;'" : "" ?>><?= $i ?></a> <?
        }
    ?>
</div>