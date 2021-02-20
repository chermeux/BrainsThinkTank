<?php session_start();
if (! isset($_SESSION["admin"]) or ! $_SESSION["admin"]) {
    header('Location: /../../index.php');
    exit();
} ?>


<?php
$id_val = "-1";
$titre_val = "";
$texte_val = "";
$date_val = "";
$lieu_val = "";
if (isset($_GET['id'])) {
    $id_val = $_GET['id'];
    $bdd = new PDO('mysql:host=localhost;dbname=brains;charset=utf8', 'root', 'root');
    $req = $bdd->prepare("SELECT * from evenements where id = ?");
    $req->execute(array($_GET["id"]));
    if (! ($data = $req->fetch())) {
        $error = "Evenement non trouver";
    }
    else {
        $titre_val = $data["Titre"];
        $texte_val = $data["texte"];
        $ar = preg_split("/-/", $data["date"]);
        $date_val = $ar[1] . "/" . $ar[2] . "/" . $ar[0];
        $lieu_val = $data["lieu"];
    }
}

$id_valide = "";
$titre_valide = "";
$fichier_valide = "";
$texte_valide = "";
$date_valide = "";
$lieu_valide = "";
if (isset($_POST['new'])) {
    # Teste de la validite des champs
    $update = TRUE;

    if (isset($_POST['id'])) {
        $id_val = $_POST['id'];
        if (filter_var($_POST['id'], FILTER_VALIDATE_INT)) {
            $id_valide = "is-valid";
        }
        else {
            $id_valide = "is-invalid";
            $error = "id invalid";
            $update = FALSE;
        }
    }
    else {
        $id_valide = "is-invalid";
        $error = "id obligatoire";
        $update = FALSE;
    }

    #Titre
    if (isset($_POST['titre'])) {
        $titre_valide = strlen($_POST['titre']) <= 255 ? "is-valid" : "is-invalid";
        $titre_val = $_POST['titre'];
        if (strlen($_POST['titre']) > 255) {
            $update = FALSE;
            $error = "Titre trop long (> 255)";
        }
    }
    else {
        $titre_valide = "is-invalid";
        $update = FALSE;
        $error = "Titre non definie";
    }

    #fichier
    if (isset($_FILES['image']) and $_FILES['image']['error'] != 4) {
        if ($_FILES['image']['error'] == 0) {
            $ext = preg_split("[\.]",basename($_FILES['image']['name']));
            $ext = count($ext) <= 1 ? "" : $ext[count($ext) - 1];
            if ( ($ext == "png" or $ext == "jpeg" or $ext == "bmp")) {
                $fichier_valide = "is-valid";
            }
            else {
                $fichier_valide = "is-invalid";
                $update = FALSE;
                $error = "extension interdite";
            }
        }
        else
        {
            $fichier_valide = "is-invalid";
            $update = FALSE;
            if ($_FILES['image']['error'] == 1 or $_FILES['image']['error'] == 2) {
                $error = "fichier trop grops";
            }
            elseif ($_FILES['image']['error'] == 3) {
                $error = "Le fichier n'a pas ete totalement telecharger";
            }
            elseif ($_FILES['image']['error'] == 4) {
                $error = "Le fichier n'a pas ete telecharger";
            }
            else {
                $error = "Erreur cote serveur (" ^ $_FILES['image']['error'] ^ ")" ;
            }
        }
    }
    elseif (isset($_POST['id']) and $_POST['id'] == -1) {
        $fichier_valide = "is-invalid";
        $update = FALSE;
        $error = "Image n'essesaire pour la creation de nouveau evenement";
    }

    if (isset($_POST['texte'])) {
        $texte_valide = "is-valid";
        $texte_val = $_POST['texte'];
    }

    if (isset($_POST['date'])) {
        $ar = preg_split("[/]", $_POST['date']);
        if (count($ar) == 3 and checkdate($ar[1], $ar[0], $ar[2])) {
            $date_valide = "is-valid";
            $date_val = $_POST['date'];
        }
        else {
            $date_valide = "is-invalid";
            $date_val = $_POST['date'];
            $error = "date invalide";
            $update = FALSE;
        }
    }
    else {
        $date_valide = "is-invalid";
        $error = "date obligatoire";
        $update = FALSE;
    }

    #Lieu
    if (isset($_POST['lieu'])) {
        $lieu_valide = strlen($_POST['lieu']) <= 255 ? "is-valid" : "is-invalid";
        $lieu_val = $_POST['lieu'];
        if (strlen($_POST['lieu']) > 255) {
            $update = FALSE;
            $error = "lieu trop long (> 255)";
        }
    }
    else {
        $lieu_valide = "is-invalid";
        $update = FALSE;
        $error = "Lieu non definie";
    }
    if ($update) {
        $bdd = new PDO('mysql:host=localhost;dbname=brains;charset=utf8', 'root', 'root');
        $tdate = ($ar[1] . "-" . $ar[0] . "-" . $ar[2]);
        if ($id_val == -1) {
            $uploaddir = $_SERVER['CONTEXT_DOCUMENT_ROOT'] . "/uploads/";
            $uploadfile = $uploaddir . rand(100000000,1000000000) . "." . $ext;
            move_uploaded_file($_FILES['image']['tmp_name'], $uploadfile);
            $req = $bdd->prepare("INSERT INTO brains.evenements (id, image, Titre, texte, date, lieu)
                VALUES (null, ?, ?, ?, str_to_date(?,'%m/%d/%Y'), ?);");
            $req->execute(array($uploadfile, $titre_val, $texte_val, $date_val, $lieu_val));
        }
        else {
            if (isset($_FILES['image']) and $_FILES['image']['error'] != 4) {
                $uploaddir = '\\uploads\\';
                $uploadfile = $uploaddir . rand(1000000000) . "." . $ext;
                move_uploaded_file($_FILES['image']['tmp_name'], $uploadfile);
                $req = $bdd->prepare("UPDATE brains.evenements t
SET t.image = ?,
    t.Titre = ?,
    t.texte = ?,
    t.date  = str_to_date(?,'%m/%d/%Y'),
    t.lieu  = ?
WHERE t.id = ?;");
                $req->execute(array($uploadfile, $titre_val, $texte_val, $date_val, $lieu_val, $id_val));
            }
            else {
                $req = $bdd->prepare("UPDATE brains.evenements t
SET t.Titre = ?,
    t.texte = ?,
    t.date  = str_to_date(?,'%m/%d/%Y'),
    t.lieu  = ?
WHERE t.id = ?");
                $req->execute(array($titre_val, $texte_val, $date_val, $lieu_val, $id_val));
            }
        }

    }
}
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <title>/!\ Admin Only</title>
    <meta charset="utf-8"/>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta1/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-giJF6kkoqNQ00vy+HMDP7azOuL0xtbfIcaT9wjKHr8RbDVddVHyTfAAsrekwKmP1" crossorigin="anonymous">
</head>
<body>
<?php if (isset($message)): ?>
    <div class="alert alert-success" >
        <?php echo $message ?>
    </div>
<?php endif; ?>
<?php if (isset($error)): ?>
    <div class="alert alert-danger" >
        <?php echo $error ?>
    </div>
<?php endif; ?>
<h1 class="text-danger">Modifier ou cree evenement</h1>
<form enctype="multipart/form-data" method="post" action="/admin/evenement.php" class="container border border-secondary border-2 rounded-3 m-5 mx-auto p-2">
    <div class="form-floating mb-3">
        <input id="id" type="text" class="form-control <?php echo $id_valide?>" value="<?php echo $id_val?>" name="id" readonly>
        <label for="id" class="form-label">Id</label>
    </div>
    <div class="form-floating mb-3">
        <input id="titre" type="text" class="form-control <?php echo $titre_valide?>" value="<?php echo $titre_val?>" name="titre" required>
        <label for="titre" class="form-label">Titre</label>
    </div>
    <div class="mb-3">
        <label for="fichier" class="form-label">Image</label>
        <input type="hidden" name="MAX_FILE_SIZE" value="128000000" required>
        <input class="form-control <?php echo $fichier_valide?>" type="file" id="fichier" name="image" value="">
    </div>
    <label for="editor">Texte de l'evenement</label>
    <textarea name="texte" id="editor">
        <?php echo $texte_val?>
    </textarea>
    <br>
    <div class="form-floating mb-3">
        <input id="date" type="text" class="form-control datepicker <?php echo $date_valide?>" value="" name="date" required>
        <label for="date" class="form-label">Date</label>
    </div>
    <div class="form-floating mb-3">
        <input id="lieu" type="text" class="form-control <?php echo $lieu_valide?>" value="<?php echo $lieu_val?>" name="lieu" required>
        <label for="lieu" class="form-label">Lieu</label>
    </div>
    <input type="hidden" value="1" name="new">
    <input type="submit" class="btn btn-primary" value="Envoyer">
</form>

<link rel="stylesheet" href="//code.jquery.com/ui/1.12.1/themes/base/jquery-ui.css">
<script src="https://code.jquery.com/jquery-1.12.4.js"></script>
<script src="https://code.jquery.com/ui/1.12.1/jquery-ui.js"></script>
<script src="https://cdn.ckeditor.com/ckeditor5/24.0.0/classic/ckeditor.js"></script>
<script>
    ClassicEditor
        .create( document.querySelector( '#editor' ) )
        .catch( error => {
            console.error( error );
        } );
    var datepicker = $(".datepicker")
    datepicker.datepicker({
        format: 'dd/mm/yy'
    });
    <?php if ($date_val != ""): ?>
    datepicker.datepicker( "setDate", "<?php echo $date_val ?>" );
    <?php endif; ?>
</script>
</body>
</html>