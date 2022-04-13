<!DOCTYPE html>
<html lang="en">
<?php require_once APPROOT . '/views/includes/head.php'; ?>

<body>
    <?php require_once APPROOT . '/views/includes/navbar.php'; ?>

    <?php
    if (isset($_SESSION['user'])) {
        $user = unserialize($_SESSION['user']);

        if($user->id != $post->author_id) {
            header('Location: /');
        }
    }

    ?>
    <!-- Create new post  -->
    <section class="post-card">
        <div class="card">
            <div class="card-header text-center">
                <h1 class="card-title">Edit post</h1>
            </div>
            <div class="card-body">
                <form action="/post/update" method="POST" enctype="multipart/form-data">
                    <ul class="list-group">
                        <input type="hidden" name="id" value="<?= $post->id ?>">
                        <input type="hidden" name="author_id" value="<?= $post->author_id ?>">
                        <li class="list-group-item">
                            <div class="form-floating">
                                <input type="text" class="form-control" id="title" name="title" placeholder="Wja3 trab" value="<?= $post->title ?>" required>
                                <label for="title">Title</label>
                            </div>
                        </li>
                        <li class="list-group-item">
                            <div class="input-group mb-3">
                                <input type="file" class="form-control" id="photo" name="photo" onchange="preview()" required>
                                <label class="input-group-text" for="photo">Photo</label>
                            </div>
                            <div class="preview" id="preview">
                                <img id="frame" src="" class="img-fluid" />
                            </div>
                        </li>
                        <li class="list-group-item">
                            <div class="form-floating">
                                <textarea class="form-control" id="description" placeholder="Description be like..." name="description" required><?= $post->description ?></textarea>
                                <label for="description">Description</label>
                            </div>
                        </li>
                        <li class="list-group-item">
                            <div class="form-floating">
                                <select class="form-select" id="category_id" aria-label="Category id select" name="category_id" required>
                                    <option value="1" <?= $post->category_id == 1 ? "selected" : ""; ?>>Movie</option>
                                    <option value="2" <?= $post->category_id == 2 ? "selected" : ""; ?>>Serie</option>
                                </select>
                                <label for="category_id">Category</label>
                            </div>
                        </li>
                        <li class="list-group-item text-center">
                            <button type="submit" class="btn btn-outline-success">Update</button>
                            <a href="/post?id=<?= $post->id ?>">
                                <button type="button" class="btn btn-outline-secondary">Cancel</button>
                            </a>
                        </li>
                    </ul>
                </form>
            </div>
        </div>
    </section>

    <?php require_once APPROOT . '/views/includes/footer.php'; ?>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-ka7Sk0Gln4gmtz2MlQnikT1wXgYsOg+OMhuP+IlRH9sENBO0LRn5q+8nbTov4+1p" crossorigin="anonymous"></script>
    <script src="/js/script.js"></script>
</body>

</html>