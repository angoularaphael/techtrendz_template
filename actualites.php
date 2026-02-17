<?php
require_once __DIR__ . "/lib/config.php";
require_once __DIR__ . "/lib/pdo.php";
require_once __DIR__ . "/lib/article.php";
require_once __DIR__ . "/templates/header.php";

// @todo On doit appeler getArticles pour récupérer les articles et faire une boucle pour les afficher
// $articles = getArticles($pdo);
$articles = getArticles($pdo);

?>

<h1>TechTrendz Actualités</h1>
<div class="row text-center">
    <?php foreach ($articles as $article) { ?>
        <div class="col-md-4 my-2 d-flex">
            <div class="card">
                <?php if (isset($article['image']) && $article['image'] != '') { ?>
                    <img src="<?= _ARTICLES_IMAGES_FOLDER_ . $article['image'] ?>" class="card-img-top" alt="<?= htmlspecialchars($article['title']) ?>">
                <?php } else { ?>
                    <img src="<?= _ASSETS_IMAGES_FOLDER_ . 'default-article.jpg' ?>" class="card-img-top" alt="<?= htmlspecialchars($article['title']) ?>">
                <?php } ?>
                <div class="card-body">
                    <h5 class="card-title"><?= htmlspecialchars($article['title']) ?></h5>
                    <a href="actualite.php?id=<?= $article['id'] ?>" class="btn btn-primary">Lire la suite</a>
                </div>
            </div>
        </div>
    <?php } ?>

</div>

<?php require_once __DIR__ . "/templates/footer.php"; ?>