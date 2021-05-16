<!DOCTYPE html>
<html xmlns="http://www.w3.org/1999/html">
<head>
    <meta charset="utf-8"/>
    <link rel="stylesheet" href="style.css"/>
    <link rel="stylesheet" href="style_article.css"/>
    <link rel="stylesheet" href="styleEvenement.css"/>
    <link rel="stylesheet" media="screen and (max-width: 1280px)" href="style_petitecran.css"/>
    <link rel="shortcut icon" href="images/1_generales/logoAgora.ico"/>
    <title>Agora</title>
</head>

<body>
<div>
    <?php include("header.php"); ?>
</div>

<div>
    <article id="PresentationAgora">
        <h2>Qui sommes-nous ?</h2>
        <p>Raptim igitur properantes ut motus sui rumores celeritate nimia praevenirent, vigore corporum ac levitate confisi per flexuosas semitas ad summitates collium tardius evadebant. et cum superatis difficultatibus arduis ad supercilia venissent fluvii Melanis alti et verticosi, qui pro muro tuetur accolas circumfusus, augente nocte adulta terrorem quievere paulisper lucem opperientes. arbitrabantur enim nullo inpediente transgressi inopino adcursu adposita quaeque vastare, sed in cassum labores pertulere gravissimos. Ex his quidam aeternitati se commendari posse per statuas aestimantes eas ardenter adfectant quasi plus praemii de figmentis aereis sensu carentibus adepturi, quam ex conscientia honeste recteque factorum, easque auro curant inbracteari, quod Acilio Glabrioni delatum est primo, cum consiliis armisque regem superasset Antiochum. quam autem sit pulchrum exigua haec spernentem et minima ad ascensus verae gloriae tendere longos et arduos, ut memorat vates Ascraeus, Censorius Cato monstravit. qui interrogatus quam ob rem inter multos... statuam non haberet malo inquit ambigere bonos quam ob rem id non meruerim, quam quod est gravius cur inpetraverim mussitare.</p>
    </article>
    <article id="DerniersArticles">
        <h2>Nos derniers articles</h2>
        <?php
        $bdd = new PDO('mysql:host=localhost;dbname=brains;charset=utf8', 'root', 'root');
        $articles = $bdd->prepare('SELECT * FROM articles ORDER BY datedermodif DESC LIMIT 2');
        $articles->execute();
        while ($article = $articles->fetch()) { ?>
            <a href="article.php?article=<?php echo $article['id']; ?>" target="_blank">
                <div id="rectangle_derniersarticles">
                    <img class="images_article" src=<?php echo $article['image']; ?>" alt="image de l'article <?php echo $article['titre']; ?>"/>
                    <h3><?php echo $article['titre']; ?></h3>
                </div>
            </a>
        <?php } ?>
    </article>
    <article id="ProcahinsEvenements">
        <h2>Nos prochains événements</h2>
        <?php
        $bdd = new PDO('mysql:host=localhost;dbname=brains;charset=utf8', 'root', 'root');
        $evenements = $bdd->prepare('SELECT * FROM evenements ORDER BY date DESC LIMIT 2');
        $evenements->execute();
        while ($evenement = $evenements->fetch()) { ?>
            <a href="evenement.php?evenement=<?php echo $evenement['id']; ?>" target="_blank">
                <div id="rectangle_derniersarticles">
                    <img class="images_article" src="images/articles/<?php echo $evenement['image']; ?>" alt="image de l'article <?php echo $article['titre']; ?>"/>
                    <h3><?php echo $evenement['Titre']; ?></h3>
                    <p class="dateDeModif"> <?php echo $evenement['date']; ?></p>
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
