<?php


/**
 * Description of Slide
 *
 * @author ako
 */
class Slide extends CActiveRecord 
{
    public function tableName() {
        return "slides";
    }
    public static function model($className = __CLASS__)
    {
        return parent::model($className);
    }
}
