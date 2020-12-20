<?php
class Helpers{
    //static method to redirect to given url
    public static function redirect($url){
        header("Location:".$url);
        die();
    }
    // return static string
    public static function getSessionUserLogged(){
        return "UserLoginSession";
    }
    
}
?>