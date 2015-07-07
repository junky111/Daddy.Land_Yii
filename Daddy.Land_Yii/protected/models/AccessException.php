<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of AccessException
 *
 * @author ako
 */
class AccessException extends Exception {
    public function AccessException($message = "К сожалению, у вас недостаточно прав для данного действия.") {
        parent::__construct($message);
    }
}
