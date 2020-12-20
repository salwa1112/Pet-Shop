<?php
session_start();
//all includes files
include("utils/helpers.php");
include("utils/connectiondb.php");
include("utils/models.php");

// Define variables and set to empty values
$userName = $password = $userAndPassNoExits = "";
$userNameError = $passwordError = "";
$isFormValid = true;

//Validate if session exit, if it is true redirect to home page
if (isset($_SESSION[Helpers::getSessionUserLogged()])) {
    Helpers::redirect("home.php");
}

//valiadte if username & password is empty
if ($_SERVER["REQUEST_METHOD"] == "POST") {

    if (empty($_POST["username"])) { //if username is empty
        $userNameError = "Username is required";
        $isFormValid = false;
    } else {
        $userName = $_POST["username"];
    }

    if (empty($_POST["password"])) { //if password is empty
        $passwordError = "Password is required";
        $isFormValid = false;
    } else {
        $password = $_POST["password"];
    }

    if ($isFormValid == true) {
        $conn = new ConnectionMySQL();
        $result = $conn->loginWithUserAndPassword($userName, $password);

        if ($result == null) { //when one of the input is wrong
            $userAndPassNoExits = "<h3>User and password are wrong</h3>";
        } else {
            $_SESSION[Helpers::getSessionUserLogged()] = serialize($result);
            Helpers::redirect("home.php"); //redirect to home page
        }
    }
}
?>
<!doctype html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <title>Sign In to Pet Store</title>

    <!-- Bootstrap core CSS -->
    <link href="assets/css/bootstrap.min.css" rel="stylesheet">

    <!-- Custom styles for this template -->
    <link href="assets/css/signin.css" rel="stylesheet">
</head>
<body class="text-center bg-imge">
<form class="form-signin" action="<?php echo $_SERVER['PHP_SELF'] ?>" method="POST">
    <!-- logo -->
    <img class="mb-4" src="assets/img/bg.jpg" style="float:left" alt="" width="72" height="72"> 
    <h1 class="h3 mb-3 font-weight-normal">Please sign in</h1>
    <hr/>
    <hr/>
    <?php echo $userAndPassNoExits; ?>
    <!-- <label for="username" class="sr-only">User name</label> -->
    <input type="text" class="form-control" id="username" name="username" value="<?php echo $userName; ?>"
           placeholder="User name"/>
    <span class="label label-danger"><?php echo $userNameError; ?></span><br/>


    <!-- <label for="password" class="sr-only">Password</label> -->
    <input type="password" class="form-control" id="password" name="password" value="<?php echo $password; ?>"
           placeholder="Password"/>
    <span class="label label-danger"><?php echo $passwordError; ?></span>

    <hr/>
   <button class="btn btn-lg btn-primary btn-block" type="submit">Sign in</button>
    <p class="mt-5 mb-3 text-muted">&copy; Made By Salwa, Esra, Semra (2020)</p>
</form>
</body>
</html>
