<?php
$bdd = new PDO("mysql:host=localhost;dbname=brains", "root", "root");
if (isset($_GET['s'])) {
    $req = $bdd->prepare("SELECT * FROM articles WHERE MATCH (texte) AGAINST (? IN NATURAL LANGUAGE MODE) LIMIT 20;");
    $req->execute([$_GET['terme']]);
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
            <input type = "search" name = "terme"/>
            <input type = "submit" name = "s" value = "Rechercher"/>
        </form>
        <?php
        if(isset($req) AND !empty($req))
        {
            while($terme_trouve = $req->fetch()) { ?>
                <a href="article.php?article=<?php echo $terme_trouve['id'];?>" target="_blank">
                    <div id="rectangle_derniersarticles">
                        <img class="images_articles" src="<?php echo $terme_trouve['image']; ?>"/>
                        <h3><?php echo $terme_trouve['titre']; ?></h3>
                        <p class="Date"> <?php echo $terme_trouve['datedermodif']; ?></p>
                    </div>
                </a>
            <?php }
        } ?>
    </div>
    <h2>Tous nos articles !</h2>
    <article id="c">
        <?php
        $articles = $bdd->prepare('SELECT * FROM articles');
        $articles->execute();
        while($arti = $articles->fetch()) { ?>
            <a href="article.php?article=<?php echo $arti['id']; ?>" target="_blank">
                <div id="rectangle_derniersarticles">
                    <img class="images_articles" src="<?php echo $arti['image']; ?>"/>
                    <h3><?php echo $arti['titre']; ?></h3>
                    <p class="Date"> <?php echo $arti['datedermodif']; ?></p>
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
