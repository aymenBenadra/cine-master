<!DOCTYPE html>
<html lang="en">
<?php require_once APPROOT . '/views/includes/head.php';
extract($data); ?>

<body>
    <?php require_once APPROOT . '/views/includes/navbar.php'; ?>
    <section class="profile-edit">
        <h1 class="profile-edit__header">Edit Profile</h1>
        <form action="/profile/update" method="POST" enctype="multipart/form-data" class="profile-edit__form">
            <input type="hidden" name="id" value="<?= $user->id ?>">
            <input type="text" class="form-control profile-edit__input" value="<?= $user->username ?>" placeholder="Username" name="username" id="username" required />
            <input type="file" class="form-control profile-edit__input profile-edit__input--file" onchange="preview()" id="photo" name="avatar">
            <div class="preview preview--profile d-block" id="preview">
                <img id="frame" src="/assets/uploads/<?= $user->avatar ?>" class="img-fluid" />
            </div>
            <input type="email" class="form-control profile-edit__input" placeholder="Email" name="email" id="email" value="<?= $user->email ?>" required />
            <?php
            if (isset($data['error'])) {
                echo '<p class="profile-edit__error">' . $data['error'] . '</p>';
            } else if (isset($data['status'])) {
                echo '<p class="profile-edit__status">' . $data['status'] . '</p>';
            }
            ?>
            <div class="profile-edit__actions">
                <input type="submit" value="Save" class="btn btn-outline-primary mr-1" />
                <a href="/profile">
                    <button type="button" class="btn btn-outline-secondary">Cancel</button>
                </a>
            </div>
        </form>
    </section>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-ka7Sk0Gln4gmtz2MlQnikT1wXgYsOg+OMhuP+IlRH9sENBO0LRn5q+8nbTov4+1p" crossorigin="anonymous"></script>
    <script src="/js/script.js"></script>
</body>

</html>