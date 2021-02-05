<!DOCTYPE html>
<html xmlns="http://www.w3.org/1999/html">
<head>
    <meta charset="utf-8"/>
    <link rel="stylesheet" href="style.css"/>
    <link rel="stylesheet" media="screen and (max-width: 1280px)" href="style_petitecran.css"/>
    <link rel="shortcut icon" href="images/1_generales/logo_brains.ico" /> <!-- TODO mettre l'image dans le dossier et créer le dossier -->
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
    <article>
        <h2>Nos derniers articles</h2>
        <?php
        $bdd = new PDO('mysql:host=localhost;dbname=brains;charset=utf8', 'root', 'root');
        $articles = $bdd->prepare('SELECT * FROM ARTICLES ORDER BY datedermodif DESC LIMIT 2');
        while ($article = $articles->fetch()) { ?>
            <a href="article.php?id=<?= $article['id']?>" target="_blank">
                <div id="rectangle_derniersarticles">
                    <img class="images_article" src="images/articles/<?= $article['image'] ?>" alt="image de l'article <?= $article['titre'] ?>"/>
                    <h3><?= $article['titre'] ?></h3>
                    <p class="dateDeModif"> <?= $article['datedemotif'] ?></p>
                </div>
            </a>
        <?php } ?>
    </article>
    <article>
        <h2>Nos prochains événements</h2>
        <?php
        $bdd = new PDO('mysql:host=localhost;dbname=brains;charset=utf8', 'root', 'root');
        $articles = $bdd->prepare('SELECT * FROM evenements ORDER BY date DESC LIMIT 2');
        while ($article = $articles->fetch()) { ?>
            <a href="article.php?id=<?= $article['id']?>" target="_blank">
                <div id="rectangle_derniersarticles">
                    <img class="images_article" src="images/articles/<?= $article['image'] ?>" alt="image de l'article <?= $article['titre'] ?>"/>
                    <h3><?= $article['titre'] ?></h3>
                    <p class="dateDeModif"> <?= $article['date'] ?></p>
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
