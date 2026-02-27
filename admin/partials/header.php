<?php
require '../partials/header.php';

//check login status for all pages
if (!isset($_SESSION['user-id'])) {
    header('location: ' . ROOT_URl . 'signin.php');
    die();
}
