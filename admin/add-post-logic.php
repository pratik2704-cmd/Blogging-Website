<?php
require 'config/database.php';

if (isset($_POST['submit'])) {

    $author_id = $_SESSION['user-id'] ?? null;
    $title = filter_var($_POST['title'], FILTER_SANITIZE_FULL_SPECIAL_CHARS);
    $body = filter_var($_POST['body'], FILTER_SANITIZE_FULL_SPECIAL_CHARS);
    $category_id = filter_var($_POST['category'], FILTER_SANITIZE_NUMBER_INT);
    $is_featured = isset($_POST['is_featured']) ? 1 : 0;
    $thumbnail = $_FILES['thumbnail'];

    // validate form data
    if (!$author_id) {
        $_SESSION['add-post'] = "User not logged in";
    } elseif (!$title) {
        $_SESSION['add-post'] = "Enter post title";
    } elseif (!$category_id) {
        $_SESSION['add-post'] = "Select post category";
    } elseif (!$body) {
        $_SESSION['add-post'] = "Enter post body";
    } elseif (!$thumbnail['name']) {
        $_SESSION['add-post'] = "Choose post thumbnail";
    } else {

        // WORK ON THUMBNAIL
        $time = time();
        $thumbnail_name = $time . $thumbnail['name'];
        $thumbnail_tmp_name = $thumbnail['tmp_name'];
        $thumbnail_destination_path = '../images/' . $thumbnail_name;

        // make sure file is an image
        $allowed_files = ['png', 'jpg', 'jpeg'];
        $extension = explode('.', $thumbnail_name);
        $extension = end($extension);

        if (in_array($extension, $allowed_files)) {
            if ($thumbnail['size'] < 2000000) {
                move_uploaded_file($thumbnail_tmp_name, $thumbnail_destination_path);
            } else {
                $_SESSION['add-post'] = "File size too big. Should be less than 2mb";
            }
        } else {
            $_SESSION['add-post'] = "File should be png, jpg, or jpeg";
        }
    }

    // redirect back (with form data) to add-post page if there is any problem
    if (isset($_SESSION['add-post'])) {
        $_SESSION['add-post-data'] = $_POST;
        header('location:' . ROOT_URl . 'admin/add-post.php');
        die();
    } else {

        try {
            // set is_featured of all posts to 0 if is_featured for this post is 1
            if ($is_featured == 1) {
                $zero_all_is_featured_query = "UPDATE posts SET is_featured = 0";
                $zero_all_is_featured_result = $connection->query($zero_all_is_featured_query);

                if (!$zero_all_is_featured_result) {
                    die("Error in update featured");
                }
            }

            // insert post into database
            $query = "INSERT INTO posts (title, body, thumbnail, category_id, author_id, is_featured)
                      VALUES ('$title', '$body', '$thumbnail_name', $category_id, $author_id, $is_featured)";

            $result = $connection->query($query);

            if ($result) {
                $_SESSION['add-post-success'] = "New post added successfully";
                header('location:' . ROOT_URl . 'admin/');
                die();
            } else {
                $_SESSION['add-post'] = "Database Error";
                header('location:' . ROOT_URl . 'admin/add-post.php');
                die();
            }
        } catch (PDOException $e) {
            $_SESSION['add-post'] = "Database Error: " . $e->getMessage();
            header('location:' . ROOT_URl . 'admin/add-post.php');
            die();
        }
    }
}

header('location:' . ROOT_URl . 'admin/add-post.php');
die();
