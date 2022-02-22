<!DOCTYPE html>
<html lang="en">
<?php require_once APPROOT . '/views/includes/head.php'; ?>

<body>
    <?php require_once APPROOT . '/views/includes/navbar.php'; ?>

    <section class="main">
        <h1 class="main__header">Posts</h1>
        <div class="main__content">
            <?php
            if (isset($data['posts'])) :
                foreach ($data['posts'] as $post) :
            ?>
                    <div class="card">
                        <img src="<?= $post->photo ?>" class="card-img-top" alt="<?= $post->title ?>">
                        <div class="card-body">
                            <h5 class="card-title"><?= $post->title ?></h5>
                            <p class="card-text"><?= implode(' ', array_slice(explode(' ', $post->description), 0, 4)); ?>...</p>
                            <a href="/posts/show?id=<?= $post->id ?>" class="btn btn-primary">Read more</a>
                        </div>
                    </div>
                <?php
                endforeach;
            else :
                ?>
                <p class="main__content-error">No posts found</p>
            <?php endif; ?>
        </div>
    </section>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-ka7Sk0Gln4gmtz2MlQnikT1wXgYsOg+OMhuP+IlRH9sENBO0LRn5q+8nbTov4+1p" crossorigin="anonymous"></script>
</body>

</html>