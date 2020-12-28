<!DOCTYPE html>
<html xmlns="http://www.w3.org/1999/html">
    <head>
        <meta charset="utf-8"/>
        <link rel="stylesheet" href="style.css"/>
        <link rel="stylesheet" media="screen and (max-width: 1280px)" href="style_petitecran.css"/>
        <link rel="shortcut icon" href="images/1_generales/logo_brains.ico" /> //TODO mettre l'image dans le dossier et créer le dossier
        <title>Brains Think Tank</title>
    </head>

<body>
    <div>
        <?php include("header.php"); ?>
    </div>

    <div>
        <div id="barre_de_recherche">

           /* CREER BARRE DE RECHERCHE */




        </div>
        <h2>Tous nos articles ! </h2>
        <article>
            <h2>Nos derniers articles</h2>
            <?php
            $datestocke = "00/00/0000";
            $idstocke = "0";
            $idstockeprecedent = "00/00/0000";
            $articles = $bdd->query('SELECT * FROM ARTICLES');
            while($arti = $articles->fetch())
            {
                if($arti['date_publi']>$datestocke) {
                    $idstockeprecedent = $idstocke;
                    $idstocke = $arti['id'];
                    $datestocke=$arti['date_publi'];
                    /*on lit la base articles, toutes les lignes et on stocke les deux id des articles qui
                    ont été publiés en dernier, comme ça ensuite on pourra afficher deux cadres avec les deux
                    dernières publications */
                }
            }
            ?>
            <?php
            $articles = $bdd->query("SELECT * FROM ARTICLES WHERE ID='{$idstockeprecedent}'");
            $artiun = $articles->fetch();
            ?>
            <a href="<?= $artiun['lien'] ?>" target="_blank"> // TODO Rajouter lien dans bdd
                <div id="rectangle_derniersarticles">
                    <img class="images_article" src="images/articles/<?= $artiun['IMAGE'] ?>"/>
                    <h3><?= $artiun['TITRE'] ?></h3>
                    <p class="dateDeModif"> <?= $artiun['DATEDEMODIF'] ?></p>
                </div>
            </a>

            <?php
            $articles = $bdd->query("SELECT * FROM ARTICLES WHERE ID='{$idstocke}'");
            $artiDeux = $articles->fetch();
            ?>
            <a href="<?= $artiDeux['lien'] ?>" target="_blank"> // TODO Rajouter lien dans bdd
                <div id="rectangle_derniersarticles">
                    <img class="images_article" src="images/articles/<?= $artiDeux['IMAGE'] ?>"/>
                    <h3><?= $artiDeux['TITRE'] ?></h3>
                    <p class="dateDeModif"> <?= $artiDeux['DATEDEMODIF'] ?></p>
                </div>
            </a>


        </article>
    </div>

    <div>
        <?php include("footer.php"); ?>
    </div>
</body>
</html>
