<?php
require 'config/database.php';

if (isset($_POST['submit'])) {

    // sanitize inputs
    $firstname = trim(filter_var($_POST['firstname'], FILTER_SANITIZE_FULL_SPECIAL_CHARS));
    $lastname  = trim(filter_var($_POST['lastname'], FILTER_SANITIZE_FULL_SPECIAL_CHARS));
    $username  = trim(filter_var($_POST['username'], FILTER_SANITIZE_FULL_SPECIAL_CHARS));
    $email     = trim(filter_var($_POST['email'], FILTER_VALIDATE_EMAIL));
    $createpassword  = $_POST['createpassword'];
    $confirmpassword = $_POST['confirmpassword'];
    $avatar = $_FILES['avatar'];

    // validation
    if (!$firstname) {
        $_SESSION['signup'] = "Please enter your First Name";
    } elseif (!$lastname) {
        $_SESSION['signup'] = "Please enter your Last Name";
    } elseif (!$username) {
        $_SESSION['signup'] = "Please enter your Username";
    } elseif (!$email) {
        $_SESSION['signup'] = "Please enter a valid Email";
    } elseif (strlen($createpassword) < 8) {
        $_SESSION['signup'] = "Password must be at least 8 characters";
    } elseif ($createpassword !== $confirmpassword) {
        $_SESSION['signup'] = "Passwords do not match";
    } elseif (empty($avatar['name'])) {
        $_SESSION['signup'] = "Please add Avatar";
    } else {

        // hash password
        $hashed_password = password_hash($createpassword, PASSWORD_DEFAULT);

        // check existing user
        $user_check_query = "SELECT id FROM users WHERE username='$username' OR email='$email'";
        $user_check_result = $connection->query($user_check_query);

        if ($user_check_result->rowCount() > 0) {
            $_SESSION['signup'] = "Username or Email already exists";
        } else {

            // avatar upload
            $time = time();
            $avatar_name = $time . '_' . $avatar['name'];
            $avatar_tmp  = $avatar['tmp_name'];
            $avatar_path = 'images/' . $avatar_name;

            $allowed_ext = ['png', 'jpg', 'jpeg'];
            $ext = strtolower(pathinfo($avatar_name, PATHINFO_EXTENSION));

            if (!in_array($ext, $allowed_ext)) {
                $_SESSION['signup'] = "Avatar must be png, jpg or jpeg";
            } elseif ($avatar['size'] > 1000000) {
                $_SESSION['signup'] = "Avatar must be less than 1MB";
            } else {
                move_uploaded_file($avatar_tmp, $avatar_path);

                // insert new user into user table
                $insert_user_query = "
                    INSERT INTO users 
                    (firstname, lastname, username, email, password, avatar, is_admin)
                    VALUES 
                    ('$firstname', '$lastname', '$username', '$email', '$hashed_password', '$avatar_name', 0)
                ";

                $insert_result = $connection->query($insert_user_query);

                if (!$insert_result) {
                    $_SESSION['signup'] = "Registration failed. Try again.";
                } else {
                    $_SESSION['signup-success'] = "Registration successful. Please login.";
                    header('location:' . ROOT_URl . 'signin.php');
                    exit();
                }
            }
        }
    }

    // redirect back if error
    if (isset($_SESSION['signup'])) {
        $_SESSION['signup-data'] = $_POST;
        header('location:' . ROOT_URl . 'signup.php');
        exit();
    }
} else {
    header('location:' . ROOT_URl . 'signup.php');
    exit();
}
