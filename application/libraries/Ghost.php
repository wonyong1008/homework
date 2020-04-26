<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed'); 

//code by ghost 

class Ghost {
    function isKorEng($str) {
        if (!preg_match('/[^\x{1100}-\x{11FF}\x{3130}-\x{318F}\x{AC00}-\x{D7AF}a-zA-Z]/u',$str)) {
            return false;
        }
        return true;
    }
    
    function isEngNumSpecial($str) {
        $cnt = 0;
        if (preg_match('/[A-Z]/u',$str)) {
            $cnt++;
        }
        if (preg_match('/[a-z]/u',$str)) {
            $cnt++;
        }
        if(preg_match("/[!#$%^&*()?+=\/]/",$str)) {
            $cnt++;
        }
        
        return $cnt < 3 ? false : true;
    }

    function isNum($str) {
        if (!preg_match('/[^0-9]/u',$str)) {
            return true;
        }
        return false;
    }

    function isEmail($str) {
        if(preg_match("/^[_\.0-9a-zA-Z-]+@([0-9a-zA-Z][0-9a-zA-Z-]+\.)+[a-zA-Z]{2,6}$/i", $str)) {
            return true;
        }
        return false;

    }
}