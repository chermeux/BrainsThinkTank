<!DOCTYPE html>
<html xmlns="http://www.w3.org/1999/html">
<head>
    <meta charset="utf-8"/>
    <link rel="stylesheet" href="style.css"/>
    <link rel="stylesheet" media="screen and (max-width: 1280px)" href="style_petitecran.css"/>
    <link rel="shortcut icon" href="images/1_generales/logo_brains.ico" /> /* TODO mettre l'image dans le dossier et créer le dossier */
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
        $datestocke = "00/00/0000";
        $idstocke = "0";
        $idstockeprecedent = "00/00/0000";
        $articles = $bdd->query('SELECT * FROM articles');
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
        $articles = $bdd->query("SELECT * FROM articles WHERE id='{$idstockeprecedent}'");
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
        $articles = $bdd->query("SELECT * FROM articles WHERE id='{$idstocke}'");
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
    <article>
        <h2>Nos prochains événements</h2>
        <?php
        $datestocke = "00/00/0000";
        $idstocke = "0";
        $idstockeprecedent = "00/00/0000";
        $evenement = $bdd->query('SELECT * FROM evenement');
        while($event = $evenement->fetch())
        {
            if($event['date_publi']>$datestocke) {
                $idstockeprecedent = $idstocke;
                $idstocke = $event['id'];
                $datestocke=$event['date_publi'];
            }
        }
        ?>
        <?php
        $evenement = $bdd->query("SELECT * FROM evenement WHERE id='{$idstockeprecedent}'");
        $eventun = $evenement->fetch();
        ?>
        <a href="<?= $eventun['lien'] ?>" target="_blank"> // TODO Rajouter lien dans bdd
            <div id="rectangle_derniersarticles">
                <img class="images_article" src="images/articles/<?= $eventun['IMAGE'] ?>"/>
                <h3><?= $eventun['TITRE'] ?></h3>
                <div id="basCadreEvenement">
                    <p class="dateEvenement"> <?= $eventun['DATE'] ?></p>
                    <p class="LieuEvenement"> <?= $eventun['LIEU'] ?></p>
                </div>
            </div>
        </a>

        <?php
        $evenement = $bdd->query("SELECT * FROM evenement WHERE id='{$idstockeprecedent}'");
        $eventdeux = $evenement->fetch();
        ?>
        <a href="<?= $eventdeux['lien'] ?>" target="_blank"> // TODO Rajouter lien dans bdd
            <div id="rectangle_derniersarticles">
                <img class="images_article" src="images/articles/<?= $eventdeux['IMAGE'] ?>"/>
                <h3><?= $eventdeux['TITRE'] ?></h3>
                <div id="basCadreEvenement">
                    <p class="dateEvenement"> <?= $eventdeux['DATE'] ?></p>
                    <p class="LieuEvenement"> <?= $eventdeux['LIEU'] ?></p>
                </div>
            </div>
        </a>
    </article>
</div>

<div>
    <?php include("footer.php"); ?>
</div>
</body>
</html>
