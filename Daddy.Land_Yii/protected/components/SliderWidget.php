<?php
/**
 * Description of LogoWidget
 *
 * @author ako
 */
class SliderWidget extends CWidget {
    public function init() {
        
    }
    public function run() {
        
        $criteria=new CDbCriteria;
        $criteria->select='*';
        $criteria->condition = '`visible` = 1';
        $criteria->order = "id desc";
        $this->render("slider", array("slides"=>Slide::model()->findAll($criteria)));
    }
}
