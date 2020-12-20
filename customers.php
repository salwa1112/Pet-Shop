<?php
include("utils/models.php");
include("utils/connectiondb.php");

//check session
session_start();
include("template/check_session.php");
// create an object of ConnectionMySQL class
$conn = new ConnectionMySQL();
$customersList = "";
$showError = "";
$isSearchByCriteria = false;
$notDeleted = false;
$isCriteriaNameSelected = $isCriteriaEmailSelected = false;

//get customer list which are not deleted
if ($_SERVER['REQUEST_METHOD'] == "GET") {

    $customersList = $conn->fetchAllCustomers();

    if (isset($_GET['notDeleted'])) {
        $notDeleted = $_GET['notDeleted'];
    }
}


// search customer by selected criteria
if ($_SERVER["REQUEST_METHOD"] == "POST") {


    if (isset($_POST['search_criteria'])) {

        if (!empty($_POST['input_search_criteria'])) {

            // search customer by name
            if ($_POST['search_criteria'] == 'name') {
                $searchName = $_POST['input_search_criteria'];
                $customersList = $conn->fetchAllCustomersByCriteria($searchName, 'name');
                $isSearchByCriteria = true;
                $isCriteriaNameSelected = true;

            // search customer by email
            } elseif ($_POST['search_criteria'] == 'email') {
                $searchEmail = $_POST['input_search_criteria'];
                $customersList = $conn->fetchAllCustomersByCriteria($searchEmail, 'email');
                $isSearchByCriteria = true;
                $isCriteriaEmailSelected = true;
            }

        } else {
            // if value is not given to the input box
            $showError = '<span class="text-danger">enter a value to search</span>';
            $customersList = $conn->fetchAllCustomers();
            if ($_POST['search_criteria'] == 'name') {
                $isCriteriaNameSelected = true;

            } elseif ($_POST['search_criteria'] == 'email') {
                $isCriteriaEmailSelected = true;
            }

        }
    } else {
          // if value is not given to the input box and criteria is not selected
        $showError = '<span class="text-danger">you should select a criteria and enter a value to search</span>';
        $customersList = $conn->fetchAllCustomers();
    }

}

?>
<!doctype html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <title>PetStore - Customer List</title>

    <!-- Bootstrap core CSS -->
    <link href="assets/css/bootstrap.min.css" rel="stylesheet">

    <!-- Custom styles -->
    <link href="assets/css/style.css" rel="stylesheet">
</head>

<body>
<!-- include header.php file -->
<?php include("template/header.php") ?> 

<div class="container">
<!-- the customer can not be deleted if customer buy any pet  -->
    <?php if ($notDeleted) { ?>
        <h1 class="alert alert-danger text-center">This customer can not be deleted</h1>
        <?php
    } ?>

    <?php if ($customersList) { ?>
        <div class="row">
            <form class="form-inline" action="<?php echo $_SERVER['PHP_SELF'] ?>" method="post">
                <div class="form-group mb-2">
                    <label class="text-success" style="font-weight: bold;">Search by: &nbsp; </label>
                    <div class="custom-control custom-radio custom-control-inline">
                        <input type="radio" id="radio_search_name" name="search_criteria" value="name" class="custom-control-input"
                            <?php if($isCriteriaNameSelected){echo "checked";} ?>>
                        <label class="custom-control-label" for="radio_search_name">Name</label>
                    </div>
                    <div class="custom-control custom-radio custom-control-inline">
                        <input type="radio" id="radio_search_email" name="search_criteria" value="email" class="custom-control-input"
                            <?php if($isCriteriaEmailSelected){echo "checked";} ?>>
                        <label class="custom-control-label" for="radio_search_email">Email</label>
                    </div>
                    <?php echo $showError; ?>
                </div>
                <div class="form-group mx-sm-3 mb-2">
                    <input class="form-control" type="text" id="input_search_criteria" name="input_search_criteria"
                           placeholder="Search..">
                </div>
                <input type="submit" class="btn btn-success mb-2" value="Search" id="btn_search" name="btn_search"/>
            </form>
            <hr class="featurette-divider">

        </div>
        <div class="row">
            <h1>List of Customers</h1>
            <table class="table table-bordered table-striped table-hover">
                <thead class="thead-dark">
                <tr>
                    <th>No.</th>
                    <th>Name</th>
                    <th>Email</th>
                    <th>Phone number</th>
                    <th>Address</th>
                    <th colspan="2"></th>

                </tr>
                </thead>
                <tbody>
                <?php
                // print customer list
                $counter = 0;
                foreach ($customersList as $customer) {
                    ++$counter;
                    ?>
                    <tr>
                        <td><?php echo $counter; ?></td>
                        <td><?php echo $customer->getName(); ?></td>
                        <td><?php echo $customer->getEmail(); ?></td>
                        <td><?php echo $customer->getPhoneNumber(); ?></td>
                        <td><?php echo $customer->getAddress(); ?></td>
                        <td>
                            <a href="edit_customer.php?customer_id=<?php echo $customer->getId(); ?>"
                               class="btn btn-success">Edit</a>
                        </td>
                        <td class="text-danger">
                            <a href="delete_customer.php?customer_id=<?php echo $customer->getId(); ?>" class="btn btn-danger">Delete</a>
                        </td>

                    </tr>
                    <?php
                }
                ?>
                </tbody>
            </table>

        </div>
    <?php } else { ?>
        <h1>Customers not found</h1>

        <?php if ($isSearchByCriteria) { ?>
            <a href="<?php echo $_SERVER['PHP_SELF'] ?>" class="btn btn-secondary">Click to show all customers</a>
            <?php
        }
    } ?>
</div>

</body>
</html>

