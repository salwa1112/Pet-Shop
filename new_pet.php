<?php
include("utils/models.php");
include("utils/connectiondb.php");

session_start();
include("template/check_session.php");
$conn = new ConnectionMySQL();
$categoriesList = $conn->fetchCategories();

$pet = new Pet();
$petPhoto = "";
// error messages
$categoryIdError = $petNameError = $petBreedError = $petBirthError = $petDescriptionError = $petPhotoError = "";
$isFormValid = true;

//if it is true then create or update pet
if (isset($_POST["submit"])) {


    //Validate all input fields
    if ($_POST["category_id"] < 0) {

        $categoryIdError = "Category is required";
        $isFormValid = false;

    } else {
        $pet->setCategory($_POST["category_id"]);
    }

    if (empty($_POST['pet_name'])) {
        $petNameError = "Name is required";
        $isFormValid = false;
    } else {
        $pet->setName($_POST['pet_name']);
    }

    if (empty($_POST['pet_breed'])) {
        $petBreedError = "Breed is required";
        $isFormValid = false;
    } else {
        $pet->setBreed($_POST['pet_breed']);
    }

    if (empty($_POST['pet_birth'])) {
        $petBirthError = "Birth is required";
        $isFormValid = false;
    } else {
        $pet->setDateBirth($_POST['pet_birth']);
    }

    if (empty($_POST['pet_description'])) {
        $petDescriptionError = "Description is required";
        $isFormValid = false;
    } else {
        $pet->setDescription($_POST['pet_description']);
    }

    //Validate to upload photo
    if (!empty($_FILES["pet_photo"]["name"])) {
        $petPhoto = uniqid().basename($_FILES["pet_photo"]["name"]);
        $uploadDir = "uploads/";
        $targetFile = $uploadDir .$petPhoto;
        $uploadOk = 1;
        $imageFileType = strtolower(pathinfo($targetFile, PATHINFO_EXTENSION));


        //unvalid file for uploding image
        $check = getimagesize($_FILES["pet_photo"]["tmp_name"]);
        if ($check != false) {
            $uploadOk = 1;
        } else {
            $petPhotoError = "File is not an image.";
            $isFormValid = false;
            $uploadOk = 0;
        }

        // Check if file already exists
        if (file_exists($targetFile)) {
            $petPhotoError = "Sorry, file already exists.";
            $isFormValid = false;
            $uploadOk = 0;
        }

        // Check file size
        if ($_FILES["pet_photo"]["size"] > 500000) {
            $petPhotoError = "Sorry, your file is too large.";
            $isFormValid = false;
            $uploadOk = 0;
        }

        // Allow certain file formats
        if ($imageFileType != "jpg" && $imageFileType != "png" && $imageFileType != "jpeg"
            && $imageFileType != "gif") {
            $petPhotoError = "Sorry, only JPG, JPEG, PNG & GIF files are allowed.";
            $isFormValid = false;
            $uploadOk = 0;
        }

        // Check if $uploadOk is set to 0 by an error
        if ($uploadOk == 0) {
            $petPhotoError = "Sorry, your file was not uploaded.";
            $isFormValid = false;

        } else {
            // if everything is ok, try to upload file
            if (move_uploaded_file($_FILES["pet_photo"]["tmp_name"], $targetFile)) {

            } else {
                $petPhotoError = "Sorry, there was an error uploading your file.";
                $isFormValid = false;

            }
        }
    }else {}


    //SET
    if ($isFormValid) {

        //Create a pet
        if (!empty($petPhoto)) {
            $pet->setPhoto($petPhoto); //set the pet photo to pet object
        }
        //if add pet is successful, will go to the home.php
        $isInserted = $conn->addPet($pet);
        if ($isInserted) {
            Helpers::redirect("home.php");
        }

    }

}

?>
<!doctype html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="generator" content="Jekyll v4.1.1">
    <title>PetStore - Create a new Pet</title>

    <!-- Bootstrap core CSS -->
    <link href="assets/css/bootstrap.min.css" rel="stylesheet">


    <!-- Customs information input boxes -->
    <link href="assets/css/style.css" rel="stylesheet">
</head>

<body>
<?php include("template/header.php") ?>

<div class="container col-sm-3">
    <h3 class="text-center">Create a new Pet</h3>

    <form action="<?php echo $_SERVER['PHP_SELF']; ?>" method="post" enctype="multipart/form-data">
        <div class="form-group">
            <label for="category_id">Category</label>
            <select class="form-control" id="category_id" name="category_id">
                <option value="-1">- Select -</option>
                <?php foreach ($categoriesList as $category) {
                    ?>
                    <option value="<?php echo $category->getId(); ?>" <?php if ($pet->getCategory() == $category->getId()) {
                        echo 'selected="selected"';
                    } ?>>
                        <?php echo "{$category->getName()}" ?>
                    </option>
                    <?php
                }
                ?>
            </select>
            <span class="text-danger"><?php echo $categoryIdError ?></span>
        </div>

        <div class="form-group">
            <label for="pet_name">Name and Price</label>
            <input type="text" class="form-control" id="pet_name" name="pet_name" placeholder="Name & Price"
                   value="<?php echo $pet->getName(); ?>">
            <span class="text-danger"><?php echo $petNameError ?></span>
        </div>

        <div class="form-group">
            <label for="pet_breed">Breed</label>
            <input type="text" class="form-control" id="pet_breed" name="pet_breed" placeholder="Breed"
                   value="<?php echo $pet->getBreed(); ?>">
            <span class="text-danger"><?php echo $petBreedError; ?></span>
        </div>
        <div class="form-group">
            <label for="pet_birth">Date Birth</label>
            <input type="date"  class="form-control" id="pet_birth" name="pet_birth" placeholder="dd-mm-yyyy"
                   value="<?php echo $pet->getDateBirth(); ?>">
            <span class="text-danger"><?php echo $petBirthError; ?></span>
        </div>
        <div class="form-group">
            <label for="pet_description">Description</label>
            <textarea cols="5" rows="5" class="form-control" id="pet_description"
                      name="pet_description"><?php echo $pet->getDescription(); ?></textarea>
            <span class="text-danger"><?php echo $petDescriptionError; ?></span>
        </div>
        <div class="form-group">
            <label for="pet_photo">Photo</label>
            <input type="file" name="pet_photo" id="pet_photo">
            <span class="text-danger"><?php echo $petPhotoError; ?></span>
        </div>
        <button type="submit" class="btn btn-primary" name="submit">Submit</button>
    </form>
</div>

</body>
</html>
