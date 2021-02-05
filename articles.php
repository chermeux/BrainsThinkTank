<?php
$bdd = new PDO("mysql:host=localhost;dbname=", "root", "");
if (isset($_GET['s'])) {
    $req = $bdd->prepare("select * from evenement
                                where match(Titre, texte) against ('?' IN BOOLEAN MODE)
                                order by match(Titre, texte) against ('?' IN BOOLEAN MODE) DESC
                                LIMIT 20");
    $req->execute([$_GET['s'],$_GET['s']]);
}
else {
    $req = $bdd->prepare("select * from evenement order by date DESC limit 20");
    $req->execute();
}
?>

<!DOCTYPE html>
<html xmlns="http://www.w3.org/1999/html">
    <head>
        <meta charset="utf-8"/>
        <link rel="stylesheet" href="style.css"/>
        <link rel="stylesheet" media="screen and (max-width: 1280px)" href="style_petitecran.css"/>
        <link rel="shortcut icon" href="images/1_generales/logo_brains.ico" /> //TODO mettre l'image dans le dossier et créer le dossier
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
            while($terme_trouve = $select_terme->fetch())
            {?>

            <a href="<?php $terme_trouve['LIEN'] ?>" target="_blank"> // TODO Rajouter lien dans bdd
            <div id="rectangle_derniersarticles">
                <img class="images_article" src="images/articles/<?php $terme_trouve['IMAGE'] ?>"/>
                <h3><?php $terme_trouve['TITRE'] ?></h3>
                <p class="dateDeModif"> <?php $terme_trouve['DATEDEMODIF'] ?></p>
            </div>
            </a>
         <?php}

         ?>
        </div>
        <h2>Tous nos articles ! </h2>
        <article>
            <?php
            $articles = $bdd->query('SELECT * FROM ARTICLES');
            while($arti = $articles->fetch())
            {?>
                <a href="<?php $arti['LIEN'] ?>" target="_blank">
                    <div id="rectangle_derniersarticles">
                        <img class="images_article" src="images/articles/<?php $arti['IMAGE'] ?>"/>
                        <h3><?php $arti['TITRE'] ?></h3>
                        <p class="dateDeModif"> <?php $arti['DATEDEMODIF'] ?></p>
                    </div>
                </a>
            <?php}
            $select_terme->closeCursor();
            ?>
        </article>
    </div>

    <div>
        <?php include("footer.php"); ?>
    </div>
</body>
</html>
