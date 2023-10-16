<?php
session_start();

  $_SESSION['sort'] = $_POST['sort'];

// redirect the user back to the original page
header('Location: index.php');
exit();
?>
