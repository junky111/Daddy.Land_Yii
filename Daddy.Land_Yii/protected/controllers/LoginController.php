<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of LoginController
 *
 * @author ako
 */
class LoginController extends Controller {
    public function actionIndex() {
        $this->redirect("/auth/vklogin");
    }
    
    public function actionLogout() {
        unset(Yii::app()->session['uid']);
        $this->redirect(Yii::app()->request->getUrlReferrer());
    }
    public function actionSuccess() {
        $this->redirect(Yii::app()->homeUrl);
    }
    public function actionError() {
        $this->render("error");
    }
}
