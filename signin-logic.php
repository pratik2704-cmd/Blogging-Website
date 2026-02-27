<?php
session_start();
require 'config/database.php';

if (isset($_POST['submit'])) {
    $username_email = filter_var($_POST['username_email'], FILTER_SANITIZE_FULL_SPECIAL_CHARS);
    $password = filter_var($_POST['password'], FILTER_SANITIZE_FULL_SPECIAL_CHARS);

    if (!$username_email) {
        $_SESSION['signin'] = "Username and Email is required";
    } elseif (!$password) {
        $_SESSION['signin'] = "Password required";
    } else {
        $fetch_user_query = "SELECT * FROM users WHERE username='$username_email' OR email='$username_email'";
        $fetch_user_result = $connection->query($fetch_user_query);

        if ($fetch_user_result->rowCount() == 1) {
            $user_record = $fetch_user_result->fetch(PDO::FETCH_ASSOC);
            $db_password = $user_record['password'];

            if (password_verify($password, $db_password)) {
                $_SESSION['user-id'] = $user_record['id'];

                if ($user_record['is_admin'] == 1) {
                    $_SESSION['user_is_admin'] = true;
                }

                header('location:' . ROOT_URl . 'admin/');
                exit();
            } else {
                $_SESSION['signin'] = "Please check your input";
            }
        } else {
            $_SESSION['signin'] = "User not found";
        }
    }

    if (isset($_SESSION['signin'])) {
        $_SESSION['signin-data'] = $_POST;
        header('location: ' . ROOT_URl . 'signin.php');
        exit();
    }
} else {
    header('location: ' . ROOT_URl . 'signin.php');
    exit();
}
