<?php
session_start();
include_once('../require/config.php');

$id = $_POST['id'];
$password = $_POST['password'];

$sql = "SELECT * FROM `snippets` WHERE `snippet_id` = :id";
$stmt = $conn->prepare($sql);
$stmt->bindParam(':id', $id);
$stmt->execute();
$result = $stmt->fetch();


if($result['password'] == $password){
    $_SESSION['checked'] = "true";
}else{
    $_SESSION['checked'] = "wrong";
}


header('Location: ../webpages/snippet.php?id='.$id);

