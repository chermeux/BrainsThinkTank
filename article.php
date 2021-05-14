<?php
$bdd = new PDO("mysql:host=localhost;dbname=brains", "root", "root");
if(isset($_GET['article']) AND !empty($_GET['article']))
{
        $article = (int) $_GET['article'];
        $articles = $bdd->prepare('SELECT * FROM articles WHERE id = ?');
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
            $bdd = new PDO("mysql:host=localhost;dbname=brains", "root", "root");
            $articles = $bdd->prepare('SELECT titre, image, datedermodif, texte FROM articles WHERE id = :id');
            $articles->execute(array('id' => $_GET['id']));
            $arti = $articles->fetch();
        ?>
        <h2><?php $arti['titre'] ?></h2>
        <article>
            <?php $arti['image'] ?>
            <?php $arti['datedermodif']?>
        </article>
        <article>
            <?php $arti['texte']?>
        </article>
    </div>

    <div>
        <?php include("footer.php"); ?>
    </div>
</body>
</html>
