<?php
session_start();
session_destroy();
//go to the entry point of the application
header("Location: index.php"); //go to index.php
?>
