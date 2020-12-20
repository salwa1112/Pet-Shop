<?php
?>
<!-- header part for all the pages except login.php and sign_out.php -->
<header>
    <nav class="navbar navbar-expand-md navbar-dark fixed-top bg-dark">
        <a class="navbar-brand" href="#">PETSTORE</a>
        <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarCollapse"
                aria-controls="navbarCollapse" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarCollapse">
            <ul class="navbar-nav mr-auto">
                <li class="nav-item">
                    <a class="nav-link" href="home.php">Home</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="new_pet.php">New Pet</a>
                </li>

                <li class="nav-item">
                    <a class="nav-link" href="new_customer.php">New Customer</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="customers.php">Customers</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="sell_pet.php">Sell</a>
                </li>
            </ul>
            <ul class="navbar-nav px-3">
                <li class="nav-item text-nowrap">
                    <?php
                    // The unserialize() function converts serialized data back into actual data.
                    $currentUserLogged = unserialize($_SESSION[Helpers::getSessionUserLogged()]);
                    ?>
                    <a class="nav-link" href="sign_out.php">
                        <span style="color: white;font-weight: bold;"><?php echo "{$currentUserLogged->getFirstName()} {$currentUserLogged->getLastName()}"; ?></span>
                        Sign out
                    </a>
                </li>
            </ul>
        </div>
    </nav>
</header>
