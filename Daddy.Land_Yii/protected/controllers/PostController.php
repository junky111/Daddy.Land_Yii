<?php

/**
 * Description of PostController
 *
 * @author ako
 */
class PostController extends Controller{
    //put your code here
    public function actionView($id) {
        $post = Post::model()->findByPk($id);
        if($post==null) {
            $this->render('notfound');
        } else {
            $post->views++;
            $post->update();
            $this->render('view',array('post'=>$post));
        }
    }
    public function actionDelete($id) {
        $post = Post::model()->findByPk($id);
        if(!$post->isAbleToEdit(Env::getCurrentUser())) {
            throw new AccessException();
        }
        $post->delete();
        $this->redirect("/");
    }
    public function actionCreate() {
        $this->checkAddAccess(Env::getCurrentUser());
        if(isset($_POST['PostForm']))
        {
            $error = "";
            if(empty($_POST['PostForm']['title'])) $error = "title";
            if(empty($_POST['PostForm']['desc'])) $error = "desc";
            if(empty($_POST['PostForm']['content'])) $error = "content";
            if(empty($_POST['PostForm']['type'])) $error = "type";
            if(empty($_POST['PostForm']['logo'])) $error = "logo";
            if($this->checkTags($_POST['PostForm']['tags'])) $error = "tags";
            if(Env::getCurrentUser()==null) $error = "auth";
            if(Env::getCurrentUser()->isBanned()) $error = "banned";
            if(!empty($error)) {
                Env::setCookie("post_logo", $_POST['PostForm']['logo']);
                Env::setCookie("post_desc", $_POST['PostForm']['desc']);
                Env::setCookie("post_content", $_POST['PostForm']['content']);
                Env::setCookie("post_type", $_POST['PostForm']['type']);
                Env::setCookie("post_tags", $_POST['PostForm']['tags']);
                Env::setCookie("post_title", $_POST['PostForm']['title']);
                $this->redirect('/post/create/#error-'.$error);
            } else {
                Env::deleteCookie("post_logo");
                Env::deleteCookie("post_desc");
                Env::deleteCookie("post_content");
                Env::deleteCookie("post_type");
                Env::deleteCookie("post_tags");
                Env::deleteCookie("post_title");
                $post = new Post;
                $post->title = Env::clear($_POST['PostForm']['title']);
                $post->desc = Env::clear($_POST['PostForm']['desc']);
                $post->content = Env::xss_clean($_POST['PostForm']['content']);
                $post->type = Env::clear($_POST['PostForm']['type']);
                $post->logo = Env::clear($_POST['PostForm']['logo']);
                $post->uid = Env::getCurrentUser()->id;
                $post->time = time();
                $post->save();

                $post->addTags(Env::clear($_POST['PostForm']['tags']));
                $this->redirect('/post/'.$post->id);
            }
        } else {
            $this->render('create');
        }
    }
    public function actionEdit($id) {
        $post = Post::model()->findByPk($id);
        if(!$post->isAbleToEdit(Env::getCurrentUser())) {
            throw new AccessException();
        }
        if(isset($_POST['PostForm']))
        {
            $error = "";
            if(empty($_POST['PostForm']['title'])) $error = "title";
            if(empty($_POST['PostForm']['desc'])) $error = "desc";
            if(empty($_POST['PostForm']['content'])) $error = "content";
            if(empty($_POST['PostForm']['type'])) $error = "type";
            if(empty($_POST['PostForm']['logo'])) $error = "logo";
            if($this->checkTags($_POST['PostForm']['tags'])) $error = "tags";
            if(Env::getCurrentUser()==null) $error = "auth";
            if(Env::getCurrentUser()->isBanned()) $error = "banned";
            if(!empty($error)) {
                Env::setCookie("post_logo", $_POST['PostForm']['logo']);
                Env::setCookie("post_desc", $_POST['PostForm']['desc']);
                Env::setCookie("post_content", $_POST['PostForm']['content']);
                Env::setCookie("post_type", $_POST['PostForm']['type']);
                Env::setCookie("post_tags", $_POST['PostForm']['tags']);
                Env::setCookie("post_title", $_POST['PostForm']['title']);
                $this->redirect('/post/edit/#error-'.$error);
            } else {
                Env::deleteCookie("post_logo");
                Env::deleteCookie("post_desc");
                Env::deleteCookie("post_content");
                Env::deleteCookie("post_type");
                Env::deleteCookie("post_tags");
                Env::deleteCookie("post_title");
                $post->title = Env::clear($_POST['PostForm']['title']);
                $post->desc = Env::clear($_POST['PostForm']['desc']);
                $post->content = Env::xss_clean($_POST['PostForm']['content']);
                $post->type = Env::clear($_POST['PostForm']['type']);
                $post->logo = Env::clear($_POST['PostForm']['logo']);
                $post->time = time();
                $post->update();
                $post->clearTags();
                $post->addTags(Env::clear($_POST['PostForm']['tags']));
                $this->redirect('/post/'.$post->id);
            }
        } else {
            $this->render('edit', array("post"=>Post::model()->findByPk($id)));
        }
    }
    public function actionComment($id) {
        $this->checkAddAccess(Env::getCurrentUser());
        $error = false;
        if(isset($_POST['CommentForm']))
        {
            if(empty($_POST['CommentForm']['content'])) $error = true;
            if(!$error) {
                $comment = new Comment;
                $comment->uid = Env::getCurrentUser()->id;
                $comment->content = Env::xss_clean($_POST['CommentForm']['content']);
                $comment->pid = $id;
                $comment->time = time();
                $comment->save();
                $this->redirect("/post/".$id."#firstcomment");
            }
        }
        $this->redirect("/post/".$id."#adderror");
    }
    public function actionClear($id) {
        $comment = Comment::model()->findByPk($id);
        if(!$comment->isAbleToEdit(Env::getCurrentUser())) {
            throw new AccessException();
        }
        $comment->delete();
        $this->redirect('/post/'.$comment->pid);
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
