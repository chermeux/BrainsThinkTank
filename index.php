<!DOCTYPE html>
<html xmlns="http://www.w3.org/1999/html">
<head>
    <meta charset="utf-8"/>
    <link rel="stylesheet" href="style.css"/>
    <link rel="stylesheet" media="screen and (max-width: 1280px)" href="style_petitecran.css"/>
    <link rel="shortcut icon" href="images/1_generales/logo_brains.ico" /> <!-- TODO mettre l'image dans le dossier et créer le dossier -->
    <title>Brains Think Tank</title>
</head>

<body>
<div>
    <?php include("header.php"); ?>
</div>

<div>
    <article>
        <h2>Qui sommes-nous ?</h2>
        <p>Ultima Syriarum est Palaestina per intervalla magna protenta, cultis abundans terris et nitidis et <br/> civitates habens quasdam egregias, nullam nulli cedentem sed sibi vicissim velut ad perpendiculum aemulas: Caesaream, <br/> quam ad honorem Octaviani principis exaedificavit Herodes, et Eleutheropolim et Neapolim <br/> itidemque Ascalonem Gazam aevo superiore exstructas.</p>
    </article>
    <article>
        <h2>Nos derniers articles</h2>
        <?php
        $bdd = new PDO('mysql:host=localhost;dbname=brains;charset=utf8', 'root', 'root');
        $articles = $bdd->prepare('SELECT * FROM ARTICLES ORDER BY datedermodif DESC LIMIT 2');
        while ($article = $articles->fetch()) { ?>
            <a href="article.php?id=<?= $article['id']?>" target="_blank">
                <div id="rectangle_derniersarticles">
                    <img class="images_article" src="images/articles/<?= $article['image'] ?>" alt="image de l'article <?= $article['titre'] ?>"/>
                    <h3><?= $article['titre'] ?></h3>
                    <p class="dateDeModif"> <?= $article['datedemotif'] ?></p>
                </div>
            </a>
        <?php } ?>
    </article>
    <article>
        <h2>Nos prochains événements</h2>
        <?php
        $bdd = new PDO('mysql:host=localhost;dbname=brains;charset=utf8', 'root', 'root');
        $articles = $bdd->prepare('SELECT * FROM evenements ORDER BY date DESC LIMIT 2');
        while ($article = $articles->fetch()) { ?>
            <a href="article.php?id=<?= $article['id']?>" target="_blank">
                <div id="rectangle_derniersarticles">
                    <img class="images_article" src="images/articles/<?= $article['image'] ?>" alt="image de l'article <?= $article['titre'] ?>"/>
                    <h3><?= $article['titre'] ?></h3>
                    <p class="dateDeModif"> <?= $article['date'] ?></p>
                </div>
            </a>
        <?php } ?>
    </article>
</div>

<div>
    <?php include("footer.php"); ?>
</div>
</body>
</html>
