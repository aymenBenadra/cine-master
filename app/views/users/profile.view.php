<!DOCTYPE html>
<html lang="en">
<?php require_once APPROOT . '/views/includes/head.php'; ?>

<body>
    <?php require_once APPROOT . '/views/includes/navbar.php'; ?>

    <section class="profile">
        <h1 class="profile__username"><?= $user->username ?></h1>
        <div class="profile__avatar">
            <img src="assets/uploads/<?= $user->avatar ?>" alt="<?= $user->username ?>" class="profile__avatar-img" />
        </div>
        <div class="profile__content">
            <div class="profile__info">
                <p class="profile__info-item">
                    <span class="profile__info-label">Email:</span>
                    <span class="profile__info-value"><?= $user->email ?></span>
                </p>
            </div>
            <div class="profile__actions">
                <ul class="profile__actions-list">
                    <a href="/profile/edit?id=<?= $user->id ?>" class="profile__actions-item">
                        <button class="btn btn-success" type="submit">Edit</button>
                    </a>
                    <form action="/profile/destroy" method="post" class="profile__actions-item">
                        <input type="hidden" name="id" value="<?= $user->id ?>">
                        <button class="btn btn-danger" type="submit">Delete</button>
                    </form>
                </ul>
            </div>
            <div class="posts">
                <h2 class="posts__header">Your Posts</h2>
                <div class="posts__content">
                    <?php
                    if (isset($data['posts'])) :
                        foreach ($data['posts'] as $post) :
                    ?>
                            <div class="card" style="width: 18rem;">
                                <img src="/assets/uploads/<?= $post->photo ?>" class="card-img-top" alt="<?= $post->title ?>">
                                <div class="card-body">
                                    <h5 class="card-title"><?= $post->title ?></h5>
                                    <p class="card-text"><?= implode(' ', array_slice(explode(' ', $post->description), 0, 4)); ?>...</p>
                                    <a href="/post?id=<?= $post->id ?>" class="btn btn-primary">Read more</a>
                                </div>
                            </div>
                        <?php
                        endforeach;
                    else :
                        ?>
                        <p class="profile__content-error">No posts found</p>
                    <?php endif; ?>
                </div>

            </div>
        </div>
    </section>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-ka7Sk0Gln4gmtz2MlQnikT1wXgYsOg+OMhuP+IlRH9sENBO0LRn5q+8nbTov4+1p" crossorigin="anonymous"></script>
</body>

</html>