<?php

include_once('../require/header.php');

if (isset($_POST['submit'])) {
    $snippet_id = $_POST['snippet_id'];
    $title = $_POST['title'];
    $language = $_POST['language'] ?? 'txt';
    $snippet = $_POST['snippet'];
    $password = $_POST['password'] ?? '';

    $directory = '../snippets/';
    $filename = $directory . $snippet_id . '.' . $language;
    $file = fopen($filename, 'w');

    if ($file === false) {
        die("Failed to open file: $filename");
    }

    if (fwrite($file, $snippet) === false) {
        die("Failed to write to file: $filename");
    }

    fclose($file);

    try {
        $query_add = "INSERT INTO `snippets` (`snippet_id`, `title`, `language`, `snippet`, `password`) VALUES
                (:snippet_id, :title, :language, :snippet, :password)";
        $statement = $conn->prepare($query_add);

        $data = [
            ':snippet_id' => $snippet_id,
            ':title' => $title,
            ':language' => $language,
            ':snippet' => $snippet,
            ':password' => $password,
        ];

        $query_execute = $statement->execute($data);

        if ($query_execute) {
            $_SESSION['message'] = "Updated Successfully";
            header("Location: ./index.php");
        } else {
            $_SESSION['message'] = "Not Updated";
        }
    } catch (PDOException $e) {
        echo $e->getMessage();
    }
}
