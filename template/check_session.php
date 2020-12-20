<?php
// check user logged in session
include ("utils/helpers.php");

//if the session variable is not set
if(!isset($_SESSION[Helpers::getSessionUserLogged()])){
    Helpers::redirect("login.php");
}