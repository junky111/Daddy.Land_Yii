<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of Pot
 *
 * @author ako
 */
class Post extends CActiveRecord
{
    public $tags;
    public $stringTags;
    private $user;
    public function tableName() {
        return "posts";
    }
    public static function model($className = __CLASS__)
    {
        return parent::model($className);
    }
    public function getComments($count = 20)
    {
        $criteria=new CDbCriteria;
        $criteria->select='*';
        $criteria->condition = "`pid` = ".  $this->id;
        $criteria->limit = $count;
        $criteria->order = "id desc";
        return Comment::model()->findAll($criteria);
    }
    public function getTags() {
        return $this->tags==null ? $this->tags = Tag::model()->findAll("pid=:pid", array("pid"=>$this->id)) : $this->tags;
    }
    public function getTagsAsStrings() {
        if($this->stringTags!=null) {return $this->stringTags;}
        $this->stringTags = array();
        foreach ($this->getTags() as $tag) {
            $this->stringTags[] = $tag->name;
        }
        return $this->stringTags;
    }
    public function getUser() {
        return $this->user==null ? $this->user = User::model()->findByPk($this->uid) : $this->user;
    }
    public function isAbleToEdit($user) {
        return $user!=null && ($user->group>1 || ($this->time + 86400 > time() && $this->uid==$user->id)) && !$user->isBanned();
    }
    public function getCommentsCount() {
        return Yii::app()->db->createCommand("SELECT COUNT(*) FROM comments WHERE `pid` = ".$this->id)->queryScalar();
    }
    public function clearTags() {
        Tag::model()->deleteAll("pid=:pid", array("pid"=>$this->id));
    }
    public function addTags($tagsStr) {
        foreach(explode(",", $tagsStr) as $tag) {
            $tag = trim($tag);
            $tO = new Tag;
            $tO->pid = $this->id;
            $tO->name  = $tag;
            $tO->save();
        }
    }
    public function getTagsAsString() {
        $tags = $this->getTagsAsStrings();
        $res = "";
        $first = true;
        foreach ($tags as $tag) {
            $res .= ($first ? "" : ", ").$tag;
        }
        return $res;
    }
}
