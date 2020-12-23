<!DOCTYPE html>
<html xmlns="http://www.w3.org/1999/html">
    <head>
        <meta charset="utf-8"/>
        <link rel="stylesheet" href="style.css"/>
        <link rel="stylesheet" media="screen and (max-width: 1280px)" href="style_petitecran.css"/>
        <link rel="shortcut icon" href="images/1_generales/logo_brains.ico" /> /* TODO mettre l'image dans le dossier et créer le dossier */
        <title>Brains Think Tank</title>
    </head>

    <body>
        <div>
             <?php include("header.php"); ?>
         </div>

         <div>
            <article>
                <h2>Qui sommes-nous ?</h2>
                <p>Ultima Syriarum est Palaestina per intervalla magna protenta, cultis abundans terris et nitidis et <br/> civitates habens quasdam egregias, nullam nulli cedentem sed sibi vicissim velut ad perpendiculum aemulas: Caesaream, <br/> quam ad honorem Octaviani principis exaedificavit Herodes, et Eleutheropolim et Neapolim <br/> itidemque Ascalonem Gazam aevo superiore exstructas.</p>
            </article>
             <article>
                 <h2>Nos derniers articles</h2>
                 <?php
                    $datestocke = "00/00/0000";
                    $idstocke = "0";
                    $idstockeprecedent = "00/00/0000";
                    $articles = $bdd->query('SELECT * FROM articles');
                    while($arti = $articles->fetch()) {
                        if($arti['date_publi']>$datestocke) {
                            $idstockeprecedent = $idstocke;
                            $idstocke = $arti['id'];
                            $datestocke=$arti['date_publi'];
                            /*on lit la base articles, toutes les lignes et on stocke les deux id des articles qui
                            ont été publiés en dernier, comme ça ensuite on pourra afficher deux cadre avec les deux
                            dernières publications */
                       }
                    }
                 ?>
             </article>
             <article>
                 <h2>Nos prochains événements</h2>
                 <?php

                 ?>
             </article>
         </div>

         <div>
             <?php include("footer.php"); ?>
         </div>
    </body>
</html>
