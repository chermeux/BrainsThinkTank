<?php
$bdd = new PDO("mysql:host=localhost;dbname=", "root", "");
if(isset($_GET['evenement']) AND !empty($_GET['evenement']))
{
        $evenement = (int) $_GET['evenement'];
        $evenements = $bdd->prepare('SELECT * FROM EVENEMENTS WHERE ID = ?');
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
            $evenements = $bdd->prepare('SELECT * FROM EVENEMENTS WHERE ID = ?');
            $evenements->execute([$_GET['ID']]);
            $event = $evenements->fetch();
        ?>
        <h2><?php $event['TITRE'] ?></h2>
        <article>
            <?php $event['IMAGE'] ?>
            <?php $event['DATE']?>
            <?php $event['LIEU']?>
        </article>
        <article>
            <?php $event['TEXTE']?>
        </article>
    </div>

    <div>
        <?php include("footer.php"); ?>
    </div>
</body>
</html>
