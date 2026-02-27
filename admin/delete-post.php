<?php
require 'config/database.php';

if (isset($_GET['id'])) {
    $id = filter_var($_GET['id'], FILTER_SANITIZE_NUMBER_INT);

    // fetch post from database in order to delete thumbnail from images folder
    $query = "SELECT * FROM posts WHERE id=$id";
    $result = $connection->query($query);

    // make sure only 1 record/post was fetched
    if ($result && $result->rowCount() == 1) {
        $post = $result->fetch(PDO::FETCH_ASSOC);
        $thumbnail_name = $post['thumbnail'];
        $thumbnail_path = '../images/' . $thumbnail_name;

        if ($thumbnail_path) {
            unlink($thumbnail_path);

            // delete post from database
            $delete_post_query = "DELETE FROM posts WHERE id=$id";
            $delete_post_result = $connection->query($delete_post_query);

            if ($delete_post_result) {
                $_SESSION['delete-post-success'] = "Post deleted successfully";
            }
        }
    }
}

header('location:' . ROOT_URl . 'admin/');
die();
