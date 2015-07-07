<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of Comment
 *
 * @author ako
 */
class Comment extends CActiveRecord
{
    private $user;
    public function tableName() {
        return "comments";
    }
    public static function model($className = __CLASS__)
    {
        return parent::model($className);
    }
    public function getPost() {
        return User::model()->findByPk($this->pid);
    }
    public function getUser() {
        return $this->user==null ? $this->user = User::model()->findByPk($this->uid) : $this->user;
    }
    public function isAbleToEdit($user) {
        return $user!=null && ($user->group>1 || ($this->time + 86400 > time() && $this->uid==$user->id)) && !$user->isBanned();
    }
}
