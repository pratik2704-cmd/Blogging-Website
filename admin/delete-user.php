<?php
require 'config/database.php';

if (isset($_GET['id'])) {
    $id = filter_var($_GET['id'], FILTER_SANITIZE_NUMBER_INT);

    // fetch user from database
    $query = "SELECT * FROM users WHERE id=$id";
    $result = $connection->query($query);
    $user = $result->fetch(PDO::FETCH_ASSOC);

    // make sure we got back only one user
    if ($result && $result->rowCount() == 1) {
        $avatar_name = $user['avatar'];
        $avatar_path = '../images/' . $avatar_name;

        // delete image if it is available
        if ($avatar_path) {
            unlink($avatar_path);
        }
    }

    // fetch all thumbnail of user's posts and delete them
    $thumbnail_query = "SELECT thumbnail FROM posts WHERE author_id=$id";
    $thumbnail_result = $connection->query($thumbnail_query);

    if ($thumbnail_result && $thumbnail_result->rowCount() > 0) {
        while ($thumbnail = $thumbnail_result->fetch(PDO::FETCH_ASSOC)) {
            $thumbnail_path = '../images/' . $thumbnail['thumbnail'];

            // delete thumbnail from images folder if exist
            if ($thumbnail_path) {
                unlink($thumbnail_path);
            }
        }
    }

    // delete from database
    $delete_user_query = "DELETE FROM users WHERE id=$id";
    $delete_user_result = $connection->query($delete_user_query);

    if (!$delete_user_result) {
        $_SESSION['delete-user'] = "Couldn't delete '{$user['firstname']}' '{$user['lastname']}'";
    } else {
        $_SESSION['delete-user-success'] = "'{$user['firstname']}' '{$user['lastname']}' deleted successfully";
    }
}

header('location:' . ROOT_URl . 'admin/manage-user.php');
die();
