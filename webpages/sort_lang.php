<?php
session_start();

$_SESSION['lang'] = $_POST['lang'];
header('Location: index.php');
exit();