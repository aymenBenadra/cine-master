<!DOCTYPE html>
<html lang="en">
<?php require_once APPROOT . '/views/includes/head.php'; ?>

<body>
    <?php require_once APPROOT . '/views/includes/navbar.php'; ?>

    <?php
    if(!isset($_SESSION['user'])){
    }

    ?>
    <section class="posts">
        <h1 class="posts__header"><?= !isset($data['cat']) ? "All" : ($data['cat'] == 1 ? "Movies" : "Series") ?> Posts</h1>
        <?php
        if (isset($data['posts']) && !empty($data['posts'])) :
            $post = $data['posts'][0];
        ?>
            <div class="card text-center posts__featured">
                <div class="card-header">
                    Featured
                </div>
                <div class="card-body">
                    <h5 class="card-title"><?= $post->title ?></h5>
                    <p class="card-text"><?= implode(' ', array_slice(explode(' ', $post->description), 0, 4)); ?>...</p>
                    <a href="/post?id=<?= $post->id ?>" class="btn btn-primary">Read more</a>
                </div>
                <div class="card-footer text-muted">
                    <?php
                    $date = new DateTime($post->created_at);
                    $now = new DateTime();
                    echo $date->diff($now)->format('%a days - %h hours - %i minutes - %s seconds ago');
                    ?>
                </div>
            </div>
        <?php
        endif;
        ?>
        <div class="posts__content">
            <?php
            if (isset($data['posts'])) :
                foreach ($data['posts'] as $post) :
            ?>
                    <div class="card">
                        <img src="assets/uploads/<?= $post->photo ?>" class="card-img-top" alt="<?= $post->title ?>">
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
                <p class="posts__content-error">No posts found</p>
            <?php endif; ?>
        </div>
    </section>
    <div class="categories">
        <ul class="categories__list">
            <li class="categories__list-item"><a href="/">All</a></li>
            <li class="categories__list-item"><a href="/category?cat=1">Movies</a></li>
            <li class="categories__list-item"><a href="/category?cat=2">Series</a></li>
        </ul>
    </div>

    <?php require_once APPROOT . '/views/includes/footer.php'; ?>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-ka7Sk0Gln4gmtz2MlQnikT1wXgYsOg+OMhuP+IlRH9sENBO0LRn5q+8nbTov4+1p" crossorigin="anonymous"></script>
</body>

</html>