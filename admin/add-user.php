<?php
include 'partials/header.php';

//get back form data if there was error
$firstname = $_SESSION['add-user-data']['firstname']  ?? null;
$lastname = $_SESSION['add-user-data']['lastname']  ?? null;
$username = $_SESSION['add-user-data']['username']  ?? null;
$email = $_SESSION['add-user-data']['email']  ?? null;
$createpassword = $_SESSION['add-user-data']['createpassword']  ?? null;
$confirmpassword = $_SESSION['add-user-data']['confirmpassword']  ?? null;


//delete session data
unset($_SESSION['add-user-data']);
?>



<section class="form__section">
    <div class="container form__section-container">
        <h2>Add User</h2>
        <?php if (isset($_SESSION['add-user'])) : ?>
            <div class="alert__message error">
                <p>
                    <?= $_SESSION['add-user'];
                    unset($_SESSION['add-user']);
                    ?>
                </p>
            </div>

        <?php endif ?>
        <form action="<?= ROOT_URl ?>admin/add-user-logic.php" enctype="multipart/form-data" method="POST">
            <input type="text" name="firstname" <?= $firstname ?> placeholder="First Name">
            <input type="text" name="lastname" <?= $lastname ?> placeholder="Last Name">
            <input type="text" name="username" <?= $username ?> placeholder="Username">
            <input type="email" name="email" <?= $email ?> placeholder="Email">
            <input type="password" name="createpassword" <?= $createpassword ?> placeholder="Create Password">
            <input type="password" name="confirmpassword" <?= $confirmpassword ?> placeholder="Confirm Password">
            <select name="userrole">
                <option value="0">Author</option>
                <option value="1">Admin</option>
            </select>
            <div class="form__control">
                <label for="avatar">User Avatar</label>
                <input type="file" name="avatar" id="avatar">
            </div>
            <button type="submit" name="submit" class="btn">Add User</button>
        </form>
    </div>
</section>




<?php
include '../partials/footer.php'
?>