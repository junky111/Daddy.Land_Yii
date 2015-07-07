<?php
/**
 * Description of User
 *
 * @author ako
 */
class User extends CActiveRecord
{
    private $dir = "";
    public function tableName() {
        return "users";
    }
    public static function model($className = __CLASS__)
    {
        return parent::model($className);
    }
    public function isBanned() {
        return $this->group == 0;
    }
    public function getImages() {
        $this->dir = "./images/uploads/u".$this->id;
        $images = scandir($this->dir);
        usort($images, array('User',  'compare_time'));
        return $images;
    }
    public function getNextImageId() {
        $this->lastimage++;
        $this->update();
        return $this->lastimage;
    }
    public function compare_time($a, $b)
    {

        $timeA = filemtime("$this->dir/$a");
        $timeB = filemtime("$this->dir/$b");

        if($timeA == $timeB) return 0;

        return ($timeA > $timeB) ? -1 : 1;
    }
}
