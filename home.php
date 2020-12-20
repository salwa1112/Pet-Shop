<?php
/**
 * Home.php is the main page, where it shows all pets that store into database
 */

//Includes some php files
include("utils/models.php");
include("utils/connectiondb.php");

//Start a session
session_start();

//Include check_session.php
include("template/check_session.php");

//Create a instance for ConnectionMySQL()
$conn = new ConnectionMySQL();
$categoriesList = $conn->fetchCategories();
$isSearchByCriteria = false;
$notDeleted = false;
$errorMessage = "";
//Fetch a pets list from database
$petsList = "";

//all the validation for user input
//show not deleted pet list
if ($_SERVER["REQUEST_METHOD"] == "GET") {
    $petsList = $conn->fetchPets(); //connection.php
    if (isset($_GET['notDeleted'])) {
        $notDeleted = $_GET['notDeleted'];
    }
}

//validation for search pet by name ans category
if ($_SERVER["REQUEST_METHOD"] == "POST") {

    if (isset($_POST['input_search_with_name'])) {

        if (empty($_POST['input_search_with_name'])) {
            $errorMessage = "Name is required to search";
            $petsList = $conn->fetchPets();
        } else {
            $searchByName = $_POST['input_search_with_name'];
            $petsList = $conn->fetchPetsByCriteria($searchByName, "name"); 
            $isSearchByCriteria = true;

        }
    }else if (empty($_POST['select_search_with_category'])) {
        $errorMessage = "You must select one category";
        $petsList = $conn->fetchPets();
    } else {
        $searchByCategory = $_POST['select_search_with_category'];
        $petsList = $conn->fetchPetsByCriteria($searchByCategory, "category");
        $isSearchByCriteria = true;

    }


}

?>
<!doctype html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <title>PETSTORE - Home</title>

    <!-- Bootstrap core CSS -->
    <link href="assets/css/bootstrap.min.css" rel="stylesheet">

    <!-- Custom styles -->
    <link href="assets/css/style.css" rel="stylesheet">

</head>

<body>
    <!-- include header.php -->
<?php include("template/header.php") ?>

<div class="container marketing">
    <!-- if the pet is sold already -->
    <?php if ($notDeleted) { ?>
        <h1 class="alert alert-danger text-center">This pet could not be deleted</h1>
        <?php
    } ?>

    <?php if ($petsList) { ?>
        <div class="row">
            <form class="form-inline" action="<?php echo $_SERVER['PHP_SELF'] ?>" method="post">
                <div class="form-group">
                    <!-- search pet by name -->
                    <label for="input_search_with_name">Search by name:&nbsp;</label>
                    <input type="text" name="input_search_with_name" id="input_search_with_name" class="form-control">&nbsp;
                    <input type="submit" class="btn btn-secondary" value="Search" id="btn_search_with_name"
                           name="btn_search_with_name"/>
                </div>
            </form>

            &nbsp;&nbsp;
            <form class="form-inline" action="<?php echo $_SERVER['PHP_SELF'] ?>" method="post">
                <div class="form-group">
                    <!-- search pet by category -->
                    <label for="select_search_with_category">Search by Category:</label>&nbsp;
                    <select id="select_search_with_category" name="select_search_with_category" class="form-control">
                        <option value="">- Select -</option>
                        <?php foreach ($categoriesList as $category) { //categoriesList declare in edit_pet.php
                            ?>
                            <option value="<?php echo $category->getId(); ?>" ?>
                                <?php echo "{$category->getName()}" ?>
                            </option>
                            <?php
                        }
                        ?>
                    </select>&nbsp;
                    <input type="submit" class="btn btn-success" value="Search" id="btn_search_with_category"
                           name="btn_search_with_category"/>
                </div>
            </form>
        </div>
        <div class="row">
             <!-- print error massage -->
            <p class="text text-danger font-weight-bold"><?php if ($errorMessage) {
                    echo $errorMessage;
                } ?></p>
        </div>
        <br/>
        <div class="row">
            <?php
            // get images
            if ($petsList) {
                foreach ($petsList as $pet) {
                    ?>
                    <div class="col-lg-4">
                        <?php if ($pet->getPhoto() == null) { ?>
                            <img src="uploads/not-found.png" width="200" height="200"/>
                            <?php
                        } else { ?>
                            <img src="uploads/<?php echo $pet->getPhoto(); ?>" width="200" height="200"/>
                            <?php
                        } ?>

                        <h2><?php echo $pet->getName(); ?></h2>
                        <!-- if the pet is sold to a costumer -->
                        <p class="text-success font-weight-bold"><?php
                            if ($pet->getIsSold()) {
                                echo "SOLD OUT";
                            }
                            ?></p>
                            <!-- pet description -->
                        <p><?php echo substr($pet->getDescription(), 0, 200) . "..."; ?></p>
                        <p>
                            <a class="btn btn-dark" href="edit_pet.php?id_pet=<?php echo $pet->getId(); ?>"
                               role="button">Edit</a>
                            <a class="btn btn-danger" href="delete_pet.php?pet_id=<?php echo $pet->getId(); ?>"
                               role="button">Delete</a>
                        </p>
                    </div><!-- /.col-lg-4 -->
                    
                    <?php
                }
            } else {
                //if unknown pet name is entered
                echo "<h1>Pets not found.</h1>";
            }
            ?>

        </div><!-- /.row -->

        <hr class="featurette-divider">
        <!-- if there is no pet under selected category -->
        <?php
    } else { ?> 
        <h2>Pets not found</h2>
        <?php if ($isSearchByCriteria) { ?>
            <a href="<?php echo $_SERVER['PHP_SELF'] ?>" class="btn btn-secondary">Clicking to show all pets</a>
            <?php
        }
    } ?>
</div><!-- /.container -->
<footer class="footer">&copy; Made By Salwa, Esra, Semra (2020)</footer>
</body>
</html>
