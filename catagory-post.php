<?php
include 'partials/header.php';


// fetch posts if id is set
if (isset($_GET['id'])) {
    $id = filter_var($_GET['id'], FILTER_SANITIZE_NUMBER_INT);
    $query = "SELECT * FROM posts WHERE category_id = $id ORDER BY date_time DESC";
    $result = $connection->query($query);
} else {
    header('location:' . ROOT_URl . 'blog.php');
    die();
}
?>


<header class="category__title">
    <h2>
        <?php
        // fetch category from categories table using category_id of post
        $category_id = $id;
        $category_query = "SELECT * FROM categories WHERE id=$category_id";
        $category_result = $connection->query($category_query);
        $category = $category_result->fetch(PDO::FETCH_ASSOC);

        echo $category['title'];
        ?>
    </h2>
</header>
<!--==============END OF FEATURED====================-->



<section class="posts">
    <div class="container post__container">
        <?php while ($post = $result->fetch(PDO::FETCH_ASSOC)) : ?>
            <article class="post">
                <div class="post__thumbnail">
                    <img src="./images/<?= $post['thumbnail'] ?>">
                </div>
                <div class="post__info">
                    <a href="<?= ROOT_URl ?>catagory-post.php?id=<?= $category['id'] ?>" class="category__button">
                        <?= $category['title'] ?>
                    </a>

                    <h3 class="post__title">
                        <a href="<?= ROOT_URl ?>post.php?id=<?= $post['id'] ?>"><?= $post['title'] ?></a>
                    </h3>
                    <p class="post__body">
                        <?= substr($post['body'], 0, 150) ?>...
                    </p>
                    <div class="post__author">
                        <?php
                        //fetch author from users table using author_id
                        $author_id = $post['author_id'];
                        $author_query = "SELECT * FROM users WHERE id=$author_id";
                        $author_result = $connection->query($author_query);
                        $author = $author_result->fetch(PDO::FETCH_ASSOC);
                        ?>
                        <div class="post_author-avatar">
                            <img src="./images/<?= $author['avatar'] ?>">
                        </div>
                        <div class="post__author-info">
                            <h5>By: <?= "{$author['firstname']} {$author['lastname']}" ?></h5>
                            <small>
                                <?= date("M d, Y - H:i", strtotime($post['date_time'])) ?>
                            </small>
                        </div>
                    </div>
                </div>
            </article>
        <?php endwhile ?>
    </div>
</section>
<!--==============END OF POSTS====================-->



<section class="category__buttons">
    <div class="container category__buttons-container">
        <?php
        $all_categories_query = "SELECT * FROM categories";
        $all_categories = $connection->query($all_categories_query);
        ?>

        <?php while ($category = $all_categories->fetch(PDO::FETCH_ASSOC)) : ?>
            <a href="<?= ROOT_URl ?>catagory-post.php?id=<?= $category['id'] ?>" class="category__button">
                <?= $category['title'] ?>
            </a>
        <?php endwhile ?>
    </div>
</section>

<!--==============END OF CATEGORY BUTTONS====================-->

<?php
include 'partials/footer.php'
?>