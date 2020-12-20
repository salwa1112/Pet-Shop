<?php
include("utils/models.php");
include("utils/connectiondb.php");

session_start();

include("template/check_session.php");
$conn = new ConnectionMySQL();

if(isset($_GET['pet_id'])){
    $petId = (int)htmlspecialchars($_GET['pet_id']) ;
    // delete pet and stay on home.php page
    if($conn->deletePet($petId)){
        Helpers::redirect("home.php");
    }else{
        // if the pet has record to sold to any customer it can be deleted
        Helpers::redirect("home.php?notDeleted=true");
    }

}else{
    Helpers::redirect("home.php");
}


?>
