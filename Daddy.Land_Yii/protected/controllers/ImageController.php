<?php

/**
 * Description of Image
 *
 * @author ako
 */
class ImageController extends Controller {
    public function actionManager() {
        $this->checkUploadAccess(Env::getCurrentUser());
        $this->renderPartial("manager", array("me"=>Env::getCurrentUser()));
    }
    public function actionUpload() {
        $user = Env::getCurrentUser();
        $this->checkUploadAccess($user);
        if(isset($_POST['Image'])){
            $model = new Image;
            $model->attributes=$_POST['Image'];
            $model->image=CUploadedFile::getInstance($model,'image');
            $imageId = $user->getNextImageId();
            @mkdir('./images/uploads/u'.$user->id);
            $model->image->saveAs('./images/uploads/u'.$user->id."/f".$imageId);
            die("/image/view?url=u".$user->id."/f".$imageId);
        }
    }
    public function actionView($url) {
        $full = "./images/uploads/".str_replace("..", "", $url);
        header('Content-Type: '.image_type_to_mime_type(exif_imagetype($full)));
        header('Content-Length: ' . filesize($full));
        echo file_get_contents($full);
        die();
    }
    public function checkUploadAccess($user) {
        if($user==null || $user->isBanned()) throw new AccessException();
    }
}
