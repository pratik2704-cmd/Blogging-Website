<?php
session_start();
require 'config/database.php';

if (isset($_POST['submit'])) {

    $firstname = trim(filter_var($_POST['firstname'], FILTER_SANITIZE_FULL_SPECIAL_CHARS));
    $lastname  = trim(filter_var($_POST['lastname'], FILTER_SANITIZE_FULL_SPECIAL_CHARS));
    $username  = trim(filter_var($_POST['username'], FILTER_SANITIZE_FULL_SPECIAL_CHARS));
    $email     = filter_var(trim($_POST['email']), FILTER_VALIDATE_EMAIL);
    $createpassword  = trim($_POST['createpassword']);
    $confirmpassword = trim($_POST['confirmpassword']);
    $is_admin = filter_var($_POST['userrole'], FILTER_SANITIZE_NUMBER_INT);
    $avatar   = $_FILES['avatar'];

    if (!$firstname) {
        $_SESSION['add-user'] = "Please enter your First Name";
    } elseif (!$lastname) {
        $_SESSION['add-user'] = "Please enter your Last Name";
    } elseif (!$username) {
        $_SESSION['add-user'] = "Please enter your Username";
    } elseif (!$email) {
        $_SESSION['add-user'] = "Please enter a valid Email";
    } elseif ($is_admin === null || $is_admin === '') {
        $_SESSION['add-user'] = "Please select user role";
    } elseif (strlen($createpassword) < 8) {
        $_SESSION['add-user'] = "Password must be at least 8 characters";
    } elseif ($createpassword !== $confirmpassword) {
        $_SESSION['add-user'] = "Passwords do not match";
    } elseif (empty($avatar['name'])) {
        $_SESSION['add-user'] = "Please add Avatar";
    } else {

        $hashed_password = password_hash($createpassword, PASSWORD_DEFAULT);

        // CHECK USERNAME OR EMAIL EXISTS
        $user_check_query = "SELECT id FROM users WHERE username='$username' OR email='$email'";
        $user_check_result = $connection->query($user_check_query);

        if ($user_check_result->rowCount() > 0) {
            $_SESSION['add-user'] = "Username or Email already exists";
        } else {

            $time = time();
            $avatar_name = $time . '_' . $avatar['name'];
            $avatar_tmp  = $avatar['tmp_name'];
            $avatar_path = '../images/' . $avatar_name;

            $allowed_ext = ['png', 'jpg', 'jpeg'];
            $ext = strtolower(pathinfo($avatar_name, PATHINFO_EXTENSION));

            if (!in_array($ext, $allowed_ext)) {
                $_SESSION['add-user'] = "Avatar must be png, jpg or jpeg";
            } elseif ($avatar['size'] > 1000000) {
                $_SESSION['add-user'] = "Avatar must be less than 1MB";
            } else {

                move_uploaded_file($avatar_tmp, $avatar_path);

                // INSERT USER
                $insert_user_query = "
                INSERT INTO users (firstname, lastname, username, email, password, avatar, is_admin)
                VALUES ('$firstname', '$lastname', '$username', '$email', '$hashed_password', '$avatar_name', '$is_admin')
                ";

                $insert_result = $connection->query($insert_user_query);

                if ($insert_result) {
                    $_SESSION['add-user-success'] = "New user $firstname $lastname added successfully.";
                    header('location:' . ROOT_URl . 'admin/manage-user.php');
                    exit();
                } else {
                    $_SESSION['add-user'] = "Registration failed. Try again.";
                }
            }
        }
    }

    if (isset($_SESSION['add-user'])) {
        $_SESSION['add-user-data'] = $_POST;
        header('location:' . ROOT_URl . 'admin/add-user.php');
        exit();
    }
} else {
    header('location:' . ROOT_URl . 'admin/add-user.php');
    exit();
}
