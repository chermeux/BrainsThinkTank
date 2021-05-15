<?php
$bdd = new PDO("mysql:host=localhost;dbname=brains;charset=utf8", "root", "root");
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
        $bdd = new PDO("mysql:host=localhost;dbname=brains;charset=utf8", "root", "root");
        $evenements = $bdd->prepare('SELECT * FROM evenements WHERE id = ?');
        $evenements->execute(array($_GET['evenement']));
        $event = $evenements->fetch();
        ?>
        <h2><?php echo $event['Titre']; ?></h2>
        <article>
            <?php echo $event['image']; ?>
            <?php echo $event['date']; ?>
            <?php echo $event['lieu']; ?>
        </article>
        <article>
            <?php echo $event['texte']; ?>
        </article>
    </div>

    <div>
        <?php include("footer.php"); ?>
    </div>
</body>
</html>
