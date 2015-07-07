<?php
/**
 * Description of LogoWidget
 *
 * @author ako
 */
class NewsPanelWidget extends CWidget {
    
    public $postsAmount = 25;
    public $newsPerPage = 20;
    public $maxPages = 0;
    public $offset = 0;
    public function init() {
        
    }
    public function run() {
        $this->maxPages = round(Yii::app()->db->createCommand("SELECT COUNT(*) FROM posts")->queryScalar()/$this->newsPerPage);
        $this->offset = empty($_GET['page']) || (int)$_GET['page']<1 ? 1 : ((int)$_GET['page']);
        $criteria=new CDbCriteria;
        $criteria->select='*';
        $criteria->condition = '`admin` = 1 and `visible` = 1';
        $criteria->limit = 5;
        $criteria->order = "id desc";
        $adminPosts = Post::model()->findAll($criteria);
        $criteria2=new CDbCriteria;
        $criteria2->select='*';
        $criteria2->condition = '`admin` = 0 and `visible` = 1';
        $criteria2->order = "id desc";
        $criteria2->limit = $this->postsAmount - count($adminPosts);
        $criteria2->offset = ($this->offset-1)*$this->newsPerPage;
        $userPosts = $this->fixArray(Post::model()->findAll($criteria2));
        $this->render("newspanel", array("userPosts"=>$userPosts, "adminPosts"=>$adminPosts, "tags"=>$this->getMostPopularTags(array_merge($userPosts, $adminPosts))));
    }
    private function getMostPopularTags($posts) {
        $tags_map = array();
        foreach($posts as $post) {
            foreach($post->getTags() as $tag) {
                if(empty($tags_map[$tag->name])) {
                    $tags_map[$tag->name] = array();
                    $tags_map[$tag->name][0] = 0;
                    $tags_map[$tag->name][1] = $tag;
                } else {
                    $tags_map[$tag->name][0]++;
                }
            }
        }
        ksort($tags_map);
        return array_slice($tags_map,0,5);
    }
    private function fixArray($arr) {
        while(count($arr)<$this->postsAmount) {
            $arr[] = $arr[rand(0, count($arr)-1)];
        }
        return $arr;
    }
}
