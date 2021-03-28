<?php
$bdd = new PDO("mysql:host=localhost;dbname=", "root", "");
if (isset($_GET['s'])) {
    $req = $bdd->prepare("select * from articles
                                where match(Titre, texte) against ('?' IN BOOLEAN MODE)
                                order by match(Titre, texte) against ('?' IN BOOLEAN MODE) DESC
                                LIMIT 20");
    $req->execute([$_GET['s'],$_GET['s']]);
}
else {
    $req = $bdd->prepare("select * from ARTICLES order by DATEDERMODIF DESC limit 20");
    $req->execute();
}
?>

<!DOCTYPE html>
<html xmlns="http://www.w3.org/1999/html">
<head>
    <meta charset="utf-8"/>
    <link rel="stylesheet" href="style.css"/>
    <link rel="stylesheet" media="screen and (max-width: 1280px)" href="style_petitecran.css"/>
    <link rel="shortcut icon" href="images/1_generales/logoAgora.ico" />
    <title>Agora</title>
</head>

<body>
<div>
    <?php include("header.php"); ?>
</div>

<div>
    <div id="barre_de_recherche">
        <form action ="" method = "get" enctype="multipart/form-data">
            <input type = "search" name = "terme">
            <input type = "submit" name = "s" value = "Rechercher">
        </form>
        <?php
        while($terme_trouve = $req->fetch())
        {?>

            <a href="article.php?article=<?php $terme_trouve['ID'] ?>" target="_blank">;
                <div id="rectangle_derniersarticles">
                    <img class="images_article" src="images/articles/<?php $terme_trouve['IMAGE'] ?>"/>
                    <h3><?php $terme_trouve['TITRE'] ?></h3>
                    <p class="dateDeModif"> <?php $terme_trouve['DATEDERMODIF'] ?></p>
                </div>
            </a>
        <?php}

        ?>
    </div>
    <h2>Tous nos articles ! </h2>
    <article>
        <?php
        $articles = $bdd->prepare('SELECT * FROM ARTICLES');
        $articles->execute();
        while($arti = $articles->fetch())
        {?>
            <a href="article.php?article=<?php $arti['ID'] ?>" target="_blank">
                <div id="rectangle_derniersarticles">
                    <img class="images_article" src="images/articles/<?php $arti['IMAGE'] ?>"/>
                    <h3><?php $arti['TITRE'] ?></h3>
                    <p class="dateDeModif"> <?php $arti['DATEDERMODIF'] ?></p>
                </div>
            </a>
        <?php}
        ?>
    </article>
</div>

<div>
    <?php include("footer.php"); ?>
</div>
</body>
</html>
