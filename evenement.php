<?php
$bdd = new PDO("mysql:host=localhost;dbname=brains", "root", "root");
if(isset($_GET['evenement']) AND !empty($_GET['evenement']))
{
        $evenement = (int) $_GET['evenement'];
        $evenements = $bdd->prepare('SELECT * FROM evenements WHERE id = ?');
        $evenements->execute([$evenement]);
        $event = $evenements->fetch();
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
        $evenements = $bdd->prepare('SELECT * FROM evenements WHERE id = ?');
        $evenements->execute(array($_GET['id']));
        $event = $evenements->fetch();
        ?>
        <h2><?php $event['Titre'] ?></h2>
        <article>
            <?php $event['image'] ?>
            <?php $event['date']?>
            <?php $event['lieu']?>
        </article>
        <article>
            <?php $event['texte']?>
        </article>
    </div>

    <div>
        <?php include("footer.php"); ?>
    </div>
</body>
</html>
