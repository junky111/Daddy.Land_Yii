<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of ListController
 *
 * @author ako
 */
class ListController extends Controller {
    public function actionView($id) {
        $criteria=new CDbCriteria;
        $criteria->select='*';
        $criteria->condition = '`group` = '.(int)$id;
        $criteria->order = "id desc";
        $this->render("view", array("users"=>User::model()->findAll($criteria), "id"=>$id));
    }
    public function actionAdd($id) {
        $this->checkAdminAccess(Env::getCurrentUser(), $id);
        if(isset($_POST['param']))
        {
            $user = User::model()->find("vkid=:vkid or vkuri=:vkuri or nickname=:nickname", array("vkid"=>(int)$_POST['param'], "vkuri"=>$_POST['param'],"nickname"=>$_POST['param']));
            if($user===null) {
                $this->redirect('/list/'.$id."#error-notfound");
            } else {
                $user->group = $id;
                $user->update();
                $this->redirect('/list/'.$id);
            }
        } else {
            $this->redirect('/list/'.$id);
        }
    }
    public function actionDelete($id) {
        $user = User::model()->findByPk($id);
        $user->group = 1;
        $user->update();
        $this->redirect(Yii::app()->request->getUrlReferrer());
    }
    public function checkAccess($user) {
        if($user==null || $user->isBanned() || $user->group<2) {throw new AccessException();}
    }
    public function checkAdminAccess($user, $id) {
        if($user==null || $user->isBanned() || ($id==0 && $user->group<2) || ($id!=0 && $user->group<3)) {throw new AccessException();}
    }
}
