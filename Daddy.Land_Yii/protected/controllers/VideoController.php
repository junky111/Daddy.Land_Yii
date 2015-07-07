<?php

/**
 * Description of VideoController
 *
 * @author ako
 */
class VideoController extends Controller{
    public function actionCreate() {
        $this->checkAddAccess(Env::getCurrentUser());
        if(isset($_POST['PostForm']))
        {
            $error = "";
            if(empty($_POST['PostForm']['title'])) $error = "title";
            if(empty($_POST['PostForm']['content'])) $error = "content";
            if(empty($_POST['PostForm']['type'])) $error = "type";
            if(empty($_POST['PostForm']['logo'])) $error = "logo";
            if($this->checkTags($_POST['PostForm']['tags'])) $error = "tags";
            if(Env::getCurrentUser()==null) $error = "auth";
            if(Env::getCurrentUser()->isBanned()) $error = "banned";
            if(!empty($error)) {
                Env::setCookie("post_logo", $_POST['PostForm']['logo']);
                Env::setCookie("post_content", $_POST['PostForm']['content']);
                Env::setCookie("post_type", $_POST['PostForm']['type']);
                Env::setCookie("post_tags", $_POST['PostForm']['tags']);
                Env::setCookie("post_title", $_POST['PostForm']['title']);
                $this->redirect('/video/create/#error-'.$error);
            } else {
                Env::deleteCookie("post_logo");
                Env::deleteCookie("post_content");
                Env::deleteCookie("post_type");
                Env::deleteCookie("post_tags");
                Env::deleteCookie("post_title");
                $post = new Post;
                $post->title = Env::clear($_POST['PostForm']['title']);
                $post->content = $_POST['PostForm']['content'];
                $post->type = Env::clear($_POST['PostForm']['type']);
                $post->logo = Env::clear($_POST['PostForm']['logo']);
                $post->uid = Env::getCurrentUser()->id;
                $post->time = time();
                $post->save();

                $post->addTags(Env::clear($_POST['PostForm']['tags']));
                $this->redirect(Yii::app()->homeUrl);
            }
        } else {
            $this->render('create');
        }
    }
    private function checkTags($tagsStr) {
        $haveEmpty = false;
        foreach(explode(",", $tagsStr) as $tag) {
            $cl = trim($tag);
            if(empty($cl) || $cl==" ") {
                $haveEmpty = true;
                break;
            }
        }
        return $haveEmpty;
    }
    public function checkAddAccess($user) {
        if($user==null || $user->isBanned()) {throw new AccessException();}
    }
}
