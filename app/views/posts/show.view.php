<!DOCTYPE html>
<html lang="en">
<?php require_once APPROOT . '/views/includes/head.php'; ?>

<body>
    <?php require_once APPROOT . '/views/includes/navbar.php'; ?>

    <?php
    if (isset($_SESSION['user'])) {
        $user = unserialize($_SESSION['user']);
    }

    ?>
    <section class="post">
        <img class="post__photo" src="<?= "assets/uploads/".$post->photo ?>" alt="<?= $post->title ?>">
        <div class="post__content">
            <h1 class="post__title"><?= $post->title ?></h1>
            <h3 class="post__category"><?= $post->category_id == 1 ? "Movie" : "Serie" ;?></h3>
            <p class="post__description"><?= $post->description ?></p>
        </div>
    </section>
    <?php
        if ($user->id == $post->author_id) :
    ?>
    <div class="post__actions">
        <ul class="post__actions-list">
            <a href="/post/edit?id=<?= $post->id ?>" class="post__actions-item">
                <button class="btn btn-success" type="submit">Edit</button>
            </a>
            <form action="/post/destroy" method="post" class="post__actions-item">
                <input type="hidden" name="id" value="<?= $post->id ?>">
                <button class="btn btn-danger" type="submit">Delete</button>
            </form>
        </ul>
    </div>
    <?php endif; ?>
    <section class="comments">
        <div class="card">
            <div class="card-header text-center">
                Comments
            </div>
            <ul class="list-group list-group-flush">
                <?php
                if (isset($data['comments']) && !empty($data['comments'])) :
                    foreach ($data['comments'] as $comment) :
                        $date = new DateTime($comment->created_at);
                        $now = $date->diff(new DateTime())->format('%a days - %h hours - %i minutes ago');
                ?>
                        <li class="list-group-item">
                            <div class="comment">
                                <p class="comment__content"><?= $comment->content ?><br><span class="comment__time">~ <?= $now ?></span></p>
                                <?php
                                    if ($user->id == $comment->author_id) :
                                ?>
                                <form action="/comment/destroy" method="post">
                                    <input type="hidden" name="id" value="<?= $comment->id ?>">
                                    <input type="hidden" name="post_id" value="<?= $post->id ?>">
                                    <button type="submit" class="btn btn-danger btn-sm">Delete</button>
                                </form>
                                <?php
                                    endif;
                                ?>
                            </div>
                        </li>
                    <?php
                    endforeach;
                else :
                    ?>
                    <li class="list-group-item">
                        <div class="comment">
                            <p class="comment__content">No comments found</p>
                        </div>
                    </li>
                <?php endif; ?>
                <li class="list-group-item">
                    <form action="/comment/store" method="post">
                        <div class="input-group">
                            <textarea class="form-control" aria-label="content" name="content" rows="1" cols="100"></textarea>
                            <input type="hidden" name="post_id" value="<?= $post->id ?>">
                            <input type="hidden" name="author_id" value="<?= $user->id ?>">
                            <button class="btn btn-outline-secondary" type="submit">Submit</button>
                        </div>
                    </form>
                </li>
            </ul>
        </div>
    </section>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-ka7Sk0Gln4gmtz2MlQnikT1wXgYsOg+OMhuP+IlRH9sENBO0LRn5q+8nbTov4+1p" crossorigin="anonymous"></script>
</body>

</html>