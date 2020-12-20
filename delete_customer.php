<?php
include("utils/models.php");
include("utils/connectiondb.php");

session_start();

include("template/check_session.php");
$conn = new ConnectionMySQL();

if(isset($_GET['customer_id'])){

    $customerId = (int)htmlspecialchars($_GET['customer_id']) ;
    // delete customer and stay on customer.php page
    if($conn->deleteCustomer($customerId)){
        Helpers::redirect("customers.php");

    }else{ 
        // if the customer has record to buy any pet it can be deleted
        Helpers::redirect("customers.php?notDeleted=true");
    }

}else{
    Helpers::redirect("home.php");
}


?>
