<?php
session_start();
include_once('../require/header.php');


try {
  // get the search query from the form input
  $search_query = $_POST['search'] ?? '';

  // escape special characters in the search query
  $search_query = htmlspecialchars($search_query);
  $search_query = str_replace('%', '\\%', $search_query);
  $search_query = str_replace('_', '\\_', $search_query);

  // build the SQL query
  $query = "`title` LIKE '%$search_query%'";

  // $_SESSION['search_results'] = $result->fetchAll();
  $_SESSION['search_results'] = $query;
  header("location: ./index.php");

  // close the database connection
  $conn = null;
} catch (PDOException $e) {
  echo "Database query failed: " . $e->getMessage();
}
