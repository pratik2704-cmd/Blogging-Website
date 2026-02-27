<?php
include 'partials/header.php';

//fetch all post from posts table 
$query = "SELECT * FROM posts ORDER BY date_time DESC";
$posts = $connection->query($query);
?>

<section class="search__bar">
    <form class="container search__bar-container" action="<?= ROOT_URl ?>search.php" method="GET">
        <div>
            <i class="uil uil-search"></i>
            <input type="search" name="search" placeholder="Search">
        </div>
        <button type="submit" name="submit" class="btn">Go</button>
    </form>
</section>

<!--==============END OF SEARCH====================-->

<section class="posts <?= $featured ? '' : 'section__extra-margin' ?>">
    <div class="container post__container">

        <?php while ($post = $posts->fetch(PDO::FETCH_ASSOC)) : ?>
            <article class="post">
                <div class="post__thumbnail">
                    <img src="./images/<?= $post['thumbnail'] ?>">
                </div>
                <div class="post__info">

                    <?php
                    // fetch category from categories table using category_id of post
                    $category_id = $post['category_id'];
                    $category_query = "SELECT * FROM categories WHERE id=$category_id";
                    $category_result = $connection->query($category_query);
                    $category = $category_result->fetch(PDO::FETCH_ASSOC);
                    ?>

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