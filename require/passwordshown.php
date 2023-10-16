<?php
session_start();
$showpassed = $_POST['showpassed'];
if ($showpassed == "yes") {
    $_SESSION['showpassed'] = "yes";
} else {
    $_SESSION['showpassed'] = "no";
}

header("Location: ../webpages/index.php");
