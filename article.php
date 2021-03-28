<?php
$bdd = new PDO("mysql:host=localhost;dbname=", "root", "");
if(isset($_GET['article']) AND !empty($_GET['article']))
{
        $article = (int) $_GET['article'];
        $articles = $bdd->prepare('SELECT * FROM ARTICLES WHERE ID = ?');
        $articles->execute([$article]);
        $arti = $articles->fetch();
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
        <?php
            $articles = $bdd->prepare('SELECT * FROM ARTICLES WHERE ID = ?');
            $articles->execute([$_GET['ID']]);
            $arti = $articles->fetch();
        ?>
        <h2><?php $arti['TITRE'] ?></h2>
        <article>
            <?php $arti['IMAGE'] ?>
            <?php $arti['DATEDERMODIF']?>
        </article>
        <article>
            <?php $arti['TEXTE']?>
        </article>
    </div>

    <div>
        <?php include("footer.php"); ?>
    </div>
</body>
</html>
