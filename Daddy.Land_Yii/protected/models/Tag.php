<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of Tag
 *
 * @author ako
 */
class Tag extends CActiveRecord {
    public function tableName() {
        return "tags";
    }
    public static function model($className = __CLASS__)
    {
        return parent::model($className);
    }
    public function toString() {
        return $this->name;
    }
}
