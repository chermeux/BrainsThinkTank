<?php
$bdd = new PDO("mysql:host=localhost;dbname=brains;charset=utf8", "root", "root");
if (isset($_GET['s'])) {
    $reqDeux = $bdd->prepare("SELECT * FROM evenements WHERE MATCH (texte) AGAINST (? IN NATURAL LANGUAGE MODE) LIMIT 20;");
    $reqDeux->execute([$_GET['terme']]);
}
?>

<!DOCTYPE html>
<html xmlns="http://www.w3.org/1999/html">
    <head>
        <meta charset="utf-8"/>
        <link rel="stylesheet" href="style.css"/>
        <link rel="stylesheet" href="styleEvenement.css"/>
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
            if(isset($reqDeux) AND !empty($reqDeux))
            {
            while($terme_trouveDeux = $reqDeux->fetch()) { ?>
            <a href="evenement.php?evenement=<?php echo $terme_trouveDeux['id'];?>" target="_blank">
            <div id="rectangle_derniersevenements">
                <img class="images_evenement" src="<?php echo $terme_trouveDeux['image']; ?>"/>
                <h3><?php echo $terme_trouveDeux['Titre']; ?></h3>
                <p class="Date"> <?php echo $terme_trouveDeux['date']; ?></p>
            </div>
            </a>
            <?php }
            } ?>
        </div>
        <h2>Tous nos événements !</h2>
        <article id="rectangle_évenements">
            <?php
            $evenements = $bdd->prepare('SELECT * FROM evenements');
            $evenements->execute();
            while($event = $evenements->fetch()) { ?>
               <a href="evenement.php?evenement=<?php echo $event['id']; ?>" target="_blank">
                    <div id="rectangle_derniersevenements">
                        <img class="images_evenement" src="<?php echo $event['image']; ?>"/>
                        <h3><?php echo $event['Titre']; ?></h3>
                        <p class="Date"> <?php echo $event['date']; ?></p>
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
