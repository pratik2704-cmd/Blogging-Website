<?php
require 'config/database.php';

if (isset($_GET['id'])) {
    $id = filter_var($_GET['id'], FILTER_SANITIZE_NUMBER_INT);

    // update category_id of posts that belong to this category to id of uncategorized category
    $update_query = "UPDATE posts SET category_id=6 WHERE category_id=$id";
    $update_result = $connection->query($update_query);

    if ($update_result) {
        // delete category
        $query = "DELETE FROM categories WHERE id=$id";
        $result = $connection->query($query);

        $_SESSION['delete-category-success'] = "Category delete successfully";
    }
}

header('location:' . ROOT_URl . 'admin/manage-catagories.php');
die();
