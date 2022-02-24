<nav class="navbar navbar-light bg-light sticky-top">
    <div class="container-fluid justify-content-around">
        <div class="d-flex align-items-center">
            <a href="/" class="text-decoration-none"><span class="navbar-brand mb-0 h1">Cine Master</span></a>
        </div>
        <div class="d-flex align-items-center">
            <?php
            if (isset($_SESSION['user'])) :
                $user = unserialize($_SESSION['user']);
            ?>
                <a href="/post/create">
                    <button class="btn btn-success" style="margin-right: 5px;">+</button>
                </a>
                <a href="/profile">
                    <button class="btn btn-outline-primary" style="margin-right: 5px;"><?= $user->username ?></button>
                </a>
                <a href="/logout">
                    <button class="btn btn-outline-secondary">Logout</button>
                </a>
            <?php else : ?>
                <a href="/register">
                    <button class="btn btn-outline-success" style="margin-right: 5px;">Register</button>
                </a>
                <a href="/login">
                    <button class="btn btn-outline-secondary">Login</button>
                </a>
            <?php endif; ?>
        </div>
    </div>
</nav>