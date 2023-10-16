<?php

session_start();
session_destroy();

header('Location: ../webpages/index.php');