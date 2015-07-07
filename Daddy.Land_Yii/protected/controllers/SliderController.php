<?php
/**
 * Description of SliderController
 *
 * @author ako
 */
class SliderController extends Controller{
    public function actionIndex() {
        $criteria=new CDbCriteria;
        $criteria->select='*';
        $criteria->order = "id desc";
        $this->render("index", array("slides"=>Slide::model()->findAll($criteria)));
    }
    public function actionGenerate() {
        if(isset($_POST['SlideForm']))
        {
            $error = "";
            if(empty($_POST['SlideForm']['name'])) $error = "name";
            if(empty($_POST['SlideForm']['content'])) $error = "content";
            if(Env::getCurrentUser()==null) $error = "auth";
            if(Env::getCurrentUser()->isBanned()) $error = "banned";
            if(!empty($error)) {
                Env::setCookie("slider_content", $_POST['SlideForm']['content']);
                Env::setCookie("slider_name", $_POST['SlideForm']['name']);
                $this->redirect('/post/create/#error-'.$error);
            } else {
                Env::deleteCookie("slider_content");
                Env::deleteCookie("slider_name");
                $slide = new Slide;
                $slide->name = Env::clear($_POST['SlideForm']['name']);
                $slide->content = $_POST['SlideForm']['content'];
                $slide->save();
                $this->redirect('/slider');
            }
        }
    }
    public function actionCreate() {
        $this->render('create');
    }
    public function actionEdit($id) {
        if(isset($_POST['SlideForm']))
        {
            $error = "";
            if(empty($_POST['SlideForm']['name'])) $error = "name";
            if(empty($_POST['SlideForm']['content'])) $error = "content";
            if(Env::getCurrentUser()==null) $error = "auth";
            if(Env::getCurrentUser()->isBanned()) $error = "banned";
            if(!empty($error)) {
                Env::setCookie("slider_content", $_POST['SlideForm']['content']);
                Env::setCookie("slider_name", $_POST['SlideForm']['name']);
                $this->redirect('/slider/edit/#error-'.$error);
            } else {
                Env::deleteCookie("slider_content");
                Env::deleteCookie("slider_name");
                $slide = Slide::model()->findByPk($id);
                $slide->name = Env::clear($_POST['SlideForm']['name']);
                $slide->content = $_POST['SlideForm']['content'];
                $slide->update();
                $this->redirect('/slider');
            }
        } else {
            $this->render('edit', array("slide"=>Slide::model()->findByPk($id)));
        }
    }
    public function actionHide($id) {
        $slide = Slide::model()->findByPk($id);
        $slide->visible = 0;
        $slide->update();
        $this->redirect('/slider/');
    }
    public function actionShow($id) {
        $slide = Slide::model()->findByPk($id);
        $slide->visible = 1;
        $slide->update();
        $this->redirect('/slider/');
    }
    public function checkAccess($user) {
        if($user==null || $user->group<3) {throw new AccessException();}
    }
}
