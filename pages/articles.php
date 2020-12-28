<?php
try
{
    $bdd = new PDO("mysql:host=localhost;dbname=", "root", "");
    $bdd ->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
}
catch(Exception $e)
{
    die("Une erreur a été trouvé : " . $e->getMessage());
}
$bdd->query("SET NAMES UTF8");

if (isset($_GET["s"]) AND $_GET["s"] == "Rechercher")
{
    $_GET["terme"] = htmlspecialchars($_GET["terme"]); //pour sécuriser le formulaire contre les intrusions html
    $terme = $_GET["terme"];
    $terme = trim($terme); //pour supprimer les espaces dans la requête de l'internaute
    $terme = strip_tags($terme); //pour supprimer les balises html dans la requête

    if (isset($terme))
    {
        $terme = strtolower($terme);
        $select_terme = $bdd->prepare("SELECT TITRE, TEXTE FROM ARTICLES WHERE TITRE LIKE ? OR TEXTE LIKE ?");
        $select_terme->execute(array("%".$terme."%", "%".$terme."%"));
    }
    else
    {
        $message = "Vous devez entrer votre requete dans la barre de recherche";
    }
}
?>



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
            <form action ="" method = "get" enctype="multipart/form-data">
                <input type = "search" name = "terme">
                <input type = "submit" name = "s" value = "Rechercher">
            </form>
            <?php
            while($terme_trouve = $select_terme->fetch())
            {?>

            <a href="<?= $terme_trouve['LIEN'] ?>" target="_blank"> // TODO Rajouter lien dans bdd
            <div id="rectangle_derniersarticles">
                <img class="images_article" src="images/articles/<?= $terme_trouve['IMAGE'] ?>"/>
                <h3><?= $terme_trouve['TITRE'] ?></h3>
                <p class="dateDeModif"> <?= $terme_trouve['DATEDEMODIF'] ?></p>
            </div>
            </a>
            <?=}
            $select_terme->closeCursor();
            ?>
        </div>
        <h2>Tous nos articles ! </h2>
        <article>
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
            <a href="<?= $artiun['LIEN'] ?>" target="_blank"> // TODO Rajouter lien dans bdd
                <div id="rectangle_derniersarticles">
                    <img class="images_article" src="images/articles/<?= $artiun['IMAGE'] ?>"/>
                    <h3><?= $artiun['TITRE'] ?></h3>
                    <p class="dateDeModif"> <?= $artiun['DATEDEMODIF'] ?></p>
                </div>
            </a>

        </article>
    </div>

    <div>
        <?php include("footer.php"); ?>
    </div>
</body>
</html>
