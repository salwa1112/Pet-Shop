<?php
include("utils/models.php");
include("utils/connectiondb.php");


session_start();
// check session expireed or not
include("template/check_session.php");
$conn = new ConnectionMySQL();

//variable for show error messages
$nameCustomerError = $emailCustomerError = $phoneNumberCustomerError = $addressCustomerError = "";
//create object for custome class
$customer = new Customer();

if ($_SERVER['REQUEST_METHOD'] == "POST") {

    $isValidForm = true;

    //Validate all input
    if (empty($_POST['customer_name'])) {
        $nameCustomerError = "Name is required";
        $isValidForm = false;
    } else {
        $customer->setName($_POST['customer_name']);
    }

    if (empty($_POST['customer_email'])) {
        $emailCustomerError = "Email is required";
        $isValidForm = false;
    } else {
        $customer->setEmail($_POST['customer_email']);
    }

    if (empty($_POST['customer_phone'])) {
        $phoneNumberCustomerError = "Phone number is required";
        $isValidForm = false;
    } else {
        $customer->setPhoneNumber($_POST['customer_phone']);
    }

    if (empty($_POST['customer_address'])) {
        $addressCustomerError = "Address is required";
        $isValidForm = false;
    } else {
        $customer->setAddress($_POST['customer_address']);
    }

    // isValidForm=true then it redirect to the customers page 
    if ($isValidForm) {
        $result = $conn->addCustomer($customer);
        if($result){
            //TODO Redirect to customers list customers.php
            Helpers::redirect("customers.php");
        }
    }

}

?>
<!doctype html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <title>PetStore - Create a new customer</title>

    <!-- Bootstrap core CSS -->
    <link href="assets/css/bootstrap.min.css" rel="stylesheet">

    <!-- Custom styles -->
    <link href="assets/css/style.css" rel="stylesheet">
</head>

<body>
<?php include("template/header.php") ?>

<div class="container col-sm-3">
    <h1>New Customer</h1>
    <form action="<?php echo $_SERVER['PHP_SELF']; ?>" method="post">
        <!-- name,email, phone number,address  -->
        <div class="form-group">
            <label for="customer_name">Name:</label>
            <input type="text" name="customer_name" id="customer_name" placeholder="Name" class="form-control"
                   value="<?php echo $customer->getName() ?>">
            <span class="text-danger"><?php echo $nameCustomerError ?></span>
        </div>
        <div class="form-group">
            <label for="customer_email">Email:</label>
            <input type="text" name="customer_email" id="customer_email" placeholder="Email" class="form-control"
                   value="<?php echo $customer->getEmail() ?>">
            <span class="text-danger"><?php echo $emailCustomerError ?></span>
        </div>
        <div class="form-group">
            <label for="customer_phone">Phone number:</label>
            <input type="tel" name="customer_phone" id="customer_phone" placeholder="Phone number" class="form-control"
                   value="<?php echo $customer->getPhoneNumber() ?>">
            <span class="text-danger"><?php echo $phoneNumberCustomerError ?></span>
        </div>
        <div class="form-group">
            <label for="customer_address">Address:</label>
            <input type="text" name="customer_address" id="customer_address" placeholder="Address" class="form-control"
                   value="<?php echo $customer->getAddress() ?>">
            <span class="text-danger"><?php echo $addressCustomerError ?></span>
        </div>
        <input type="submit" name="btn_new_customer" id="btn_new_customer" value="Submit" class="btn btn-secondary"/>

    </form>
</div>

</body>
</html>
