<?php
include("utils/models.php");
include("utils/connectiondb.php");


session_start();
include("template/check_session.php");
$conn = new ConnectionMySQL();

$nameCustomerError = $emailCustomerError = $phoneNumberCustomerError = $addressCustomerError = "";
$customer = new Customer();

//fetch customer by ID
if($_SERVER['REQUEST_METHOD'] == "GET"){
    $customerId = (int)$_GET['customer_id'];
    if($customerId != 0){
        $findCustomer = $conn->findCustomerById($customerId);
        if($findCustomer != null){
            $customer = $findCustomer;
        }
    }

}

if ($_SERVER['REQUEST_METHOD'] == "POST") {

    $isValidForm = true;

    //Validate all input

    if(isset($_POST['customer_id'])){
        $customer->setId($_POST['customer_id']);
    }

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

   //if isValidForm is true
    if ($isValidForm) {
        $result = $conn->updateCustomer($customer);
        if($result){
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
        <input type="hidden" name="customer_id" value="<?php echo $customer->getId();?>">
        <input type="submit" name="btn_new_customer" id="btn_new_customer" value="Submit" class="btn btn-secondary"/>

    </form>
</div>

</body>
</html>
