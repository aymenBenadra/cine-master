<!DOCTYPE html>
<html lang="en">
<?php require_once APPROOT . '/views/includes/head.php'; ?>

<body>
    <?php require_once APPROOT . '/views/includes/navbar.php'; ?>

    <section class="login">
        <h1 class="login__header">Login</h1>
        <form action="signin" method="POST" class="login__form">
            <input type="text" class="form-control login__input" style="width: 200px" placeholder="Username or Email" name="login" id="login" required />
            <input type="password" class="form-control login__input" style="width: 200px" placeholder="password" name="password" id="password" required />
            <?php
            if (isset($data['error'])) {
                echo '<p class="login__error">' . $data['error'] . '</p>';
            } else if (isset($data['status'])) {
                echo '<p class="login__status">You have successfully registered</p>';
            }
            ?>
            <input type="submit" value="Login" class="btn btn-outline-primary login__submit" />
        </form>
        <a class="login__link" href="register">Don't have an account?</a>
    </section>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-ka7Sk0Gln4gmtz2MlQnikT1wXgYsOg+OMhuP+IlRH9sENBO0LRn5q+8nbTov4+1p" crossorigin="anonymous"></script>
</body>

</html>