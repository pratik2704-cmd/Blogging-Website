<?php
require 'config/database.php';

//fetch current user from database
if (isset($_SESSION['user-id'])) {
    $id = filter_var($_SESSION['user-id'], FILTER_SANITIZE_NUMBER_INT);
    $query = "SELECT avatar FROM users WHERE id=$id";
    $result = $connection->query($query);

    $row = $result->fetch(PDO::FETCH_ASSOC);
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>PHP & PostgresSQL Blog Application with Admin panel</title>

    <!-- CUSTOM STYLESHEET -->
    <link rel="stylesheet" href="<?= ROOT_URl ?>css/style.css">

    <!-- ICONCOUNT CDN -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/@iconscout/unicons@4.0.0/css/line.css">

    <!-- GOOGLE FONT -->
    <link href="https://fonts.googleapis.com/css2?family=Montserrat:ital,wght@0,100..900;1,100..900&display=swap"
        rel="stylesheet">
</head>

<body>
    <nav>
        <div class="container nav_container">
            <a href="<?= ROOT_URl ?>" class="nav__logo">BlogifyHub</a>
            <ul class="nav__items">
                <li><a href="<?= ROOT_URl ?>blog.php">Blog</a></li>
                <li><a href="<?= ROOT_URl ?>about.php">About</a></li>
                <li><a href="<?= ROOT_URl ?>services.php">Service</a></li>
                <li><a href="<?= ROOT_URl ?>contact.php">Contact</a></li>

                <?php if (isset($_SESSION['user-id'])): ?>
                    <li class="nav__profile">
                        <div class="avatar">
                            <img src="<?= ROOT_URl ?>images/<?= $row['avatar'] ?>" alt="User Avatar">
                        </div>

                        <ul>
                            <li><a href="<?= ROOT_URl ?>admin/index.php">DashBoard</a></li>
                            <li><a href="<?= ROOT_URl ?>logout.php">Log Out</a></li>
                        </ul>
                    </li>
                <?php else : ?>
                    <li><a href="<?= ROOT_URl ?>signin.php">SignIn</a></li>
                <?php endif ?>
            </ul>

            <button id="open__nav-btn"><i class="uil uil-bars"></i></button>
            <button id="close__nav-btn"><i class="uil uil-multiply"></i></button>
        </div>
    </nav>
    <!--==============END OF NAV====================-->