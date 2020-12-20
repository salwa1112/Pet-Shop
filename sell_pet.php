<?php
include("utils/models.php");
include("utils/connectiondb.php");

session_start();
include("template/check_session.php");
$conn = new ConnectionMySQL();
$customersList = $conn->fetchAllCustomers();
$petsList = $conn->fetchPets();
$petIdSelected = $customerIdSelected = "";
$petIdSelectedError = $customerIdSelectedError = $soldMessage = "";
$isValidForm = true;
$isExitPetAndCustomer = true;

if ($_SERVER['REQUEST_METHOD'] == "POST") {

    if (empty($_POST['customer'])) {
        $customerIdSelectedError = "Customer is required";
        $isValidForm = false;
    } else {
        $customerIdSelected = (int)$_POST['customer'];
    }

    if (empty($_POST['pet'])) {
        $petIdSelectedError = "Pet is required";
        $isValidForm = false;
    } else {
        $petIdSelected = (int)$_POST['pet'];
    }

    if ($isValidForm) {
        //Step 1 - Validate pet has been sold
        $isSold = $conn->validatePetIsSold($petIdSelected);
        if ($isSold) {
            $petIdSelectedError = "This is sold out";
        } else {
            $result = $conn->petSold($petIdSelected, $customerIdSelected);
            $soldMessage = '<h4 class="text-success">Pet has been sold, thanks for you purchase</h4>';
        }
        header('Location: '.$_SERVER['REQUEST_URI']);
    }
}

?>
<!doctype html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <title>PetStore - Sell pet to Customer</title>

    <!-- Bootstrap core CSS -->
    <link href="assets/css/bootstrap.min.css" rel="stylesheet">

    <!-- Custom styles -->
    <link href="assets/css/style.css" rel="stylesheet">

</head>

<body>
<?php include("template/header.php") ?>
<br/>
<!-- get sales record -->
<div class="container">
    <h1>Sell Pet to Customer</h1>
    <?php echo $soldMessage; ?>
    <form action="<?php echo $_SERVER['PHP_SELF']; ?>" method="post">
        <?php if ($customersList) { ?>
            <div class="form-group">
                <label for="customer" class="font-weight-bold">Customers:</label>
                <select name="customer" id="customer" class="form-control">
                    <option value="">- Select Customer</option>
                    <?php foreach ($customersList as $customer) { ?>
                        <option value="<?php echo $customer->getId() ?>" <?php if ($customerIdSelected == $customer->getId()) {
                            echo 'selected="selected"';
                        } ?>>
                            <?php echo $customer->getName() ?>
                        </option>
                    <?php } ?>
                </select>
                <span class="text-danger font-weight-bold"><?php echo $customerIdSelectedError; ?></span>
            </div>
        <?php } else {
            echo '<h3>Customers no found, you must to create at least one customer to sell </h3>';
            $isExitPetAndCustomer = false;
        } ?>

        <?php if ($petsList) { ?>
            <div class="form-group">
                <label for="pet" class="font-weight-bold">Pets:</label>
                <select name="pet" id="pet" class="form-control">
                    <option value="">- Select Pet</option>
                    <?php foreach ($petsList as $pet) { ?>
                        <option value="<?php echo $pet->getId() ?>" <?php if ($petIdSelected == $pet->getId()) {
                            echo 'selected="selected"';
                        } ?>>
                            <?php echo $pet->getName() ?>
                        </option>
                    <?php } ?>
                </select>
                <span class="text-danger font-weight-bold"><?php echo $petIdSelectedError; ?></span>

            </div>
        <?php } else {
            echo '<h3>Pets no found, you must to create at least one pet to sell </h3>';
            $isExitPetAndCustomer = false;
        } ?>

        <?php if ($isExitPetAndCustomer) { ?>
            <button type="submit" name="btn_sell" class="btn btn-secondary">Sell it</button>
            <?php
        } ?>
      
    </form>

    <div class="row">
    <!-- sales record in the table format -->
            <h1>Sales Record</h1>
            <table class="table table-bordered table-striped table-hover">
                <thead class="thead-dark">
                <tr>
                    <th>No.</th>
                    <th>Pet Name</th>
                    <th>Customer Name</th>
                </tr>
                </thead>
                <tbody>
                <?php
                $counter = 0;
                // iterate petList
                foreach ($petsList as $pet) {
                    ++$counter;
                    ?>
                    <tr>
                    <!-- get all information of the sold pet -->
                        <td><?php echo $counter; ?></td>
                        <td><?php echo $pet->getName(); ?></td>
                        <td><?php 
                         if($pet->getIsSold() != null){
                            $findCustomer = $conn->findCustomerById($pet->getIsSold());
                            if($findCustomer != null){
                                $customerInfo = $findCustomer;
                                echo $customerInfo->getName() ;
                            }
                        }                        
                        ?></td>
                    </tr>
                    <?php
                }
                ?>
                </tbody>
            </table>

        </div>
</div>
</body>
</html>

