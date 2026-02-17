<?php
require_once __DIR__ . "/lib/config.php";
require_once __DIR__ . "/lib/pdo.php";
require_once __DIR__ . "/lib/article.php";
require_once __DIR__ . "/templates/header.php";


//@todo On doit récupérer l'id en paramètre d'url et appeler la fonction getArticleById récupérer l'article
$article = false;
if (isset($_GET['id']) && is_numeric($_GET['id'])) {
    $article = getArticleById($pdo, (int)$_GET['id']);
}

if ($article === false) {
    echo '<div class="alert alert-danger">L\'article n\'existe pas</div>';
    require_once __DIR__ . "/templates/footer.php";
    exit();
}
?>


<div class="row flex-lg-row-reverse align-items-center g-5 py-5">
    <div class="col-10 col-sm-8 col-lg-6">
        <?php if (isset($article['image']) && $article['image'] != '') { ?>
            <img src="<?= _ARTICLES_IMAGES_FOLDER_ . $article['image'] ?>" class="d-block mx-lg-auto img-fluid" alt="<?= htmlspecialchars($article['title']) ?>" width="700" height="500" loading="lazy">
        <?php } else { ?>
            <img src="<?= _ASSETS_IMAGES_FOLDER_ . 'default-article.jpg' ?>" class="d-block mx-lg-auto img-fluid" alt="<?= htmlspecialchars($article['title']) ?>" width="700" height="500" loading="lazy">
        <?php } ?>
    </div>
    <div class="col-lg-6">
        <h1 class="display-5 fw-bold text-body-emphasis lh-1 mb-3"><?= htmlspecialchars($article['title']); ?></h1>
        <p class="lead"><?= nl2br(htmlspecialchars($article['content'])); ?></p>
    </div>
</div>


<?php require_once __DIR__ . "/templates/footer.php"; ?>