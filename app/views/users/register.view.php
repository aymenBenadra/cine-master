<!DOCTYPE html>
<html lang="en">
<?php require_once APPROOT . '/views/includes/head.php'; ?>

<body>
    <?php require_once APPROOT . '/views/includes/navbar.php'; ?>

    <section class="register">
        <h1 class="register__header">Register</h1>
        <form action="signup" method="POST" class="register__form">
            <input type="text" class="form-control register__input" style="width: 200px" placeholder="Username" name="username" id="username" required />
            <input type="email" class="form-control register__input" style="width: 200px" placeholder="Email" name="email" id="email" required />
            <input type="password" class="form-control register__input" style="width: 200px" placeholder="password" name="password" id="password" required />
            <input type="password" class="form-control register__input" style="width: 200px" placeholder="password confirmation" name="password_confirm" id="password_confirm" required />
            <?php
            if (isset($data['error'])) {
                echo '<p class="register__error">' . $data['error'] . '</p>';
            } else if (isset($data['status'])) {
                echo '<p class="register__status">' . $data['status'] . '</p>';
            }
            ?>
            <input type="submit" value="Register" class="btn btn-outline-primary register__submit" />
        </form>
        <a class="login__link" href="login">Already have an account?</a>
    </section>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-ka7Sk0Gln4gmtz2MlQnikT1wXgYsOg+OMhuP+IlRH9sENBO0LRn5q+8nbTov4+1p" crossorigin="anonymous"></script>
</body>

</html>