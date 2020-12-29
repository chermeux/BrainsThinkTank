<?php session_start();
if (! isset($_SESSION["admin"]) or ! $_SESSION["admin"]) {
    header('Location: /../../index.php');
} ?>


<?php
if (isset($_GET['new'])) {
    # Teste de la validite des champs
    $titre_valide = isset($_GET['Titre']) and strlen($_GET['Titre']) < 255;
    var_dump($_GET);
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

<form method="get" action="/admin/evenement.php" class="container border border-secondary border-2 rounded-3 m-5 mx-auto p-2">
    <label>
        Titre
        <input type="text" class="form-control" value="" name="titre" required>
    </label>
    <br>
    <label for="editor">Texte de l'evenement</label>
    <textarea name="content" id="editor">

    </textarea>

    <input type="hidden" value="1" name="new">
    <input type="submit" class="btn btn-primary" value="Envoyer">
</form>

<script src="https://cdn.ckeditor.com/ckeditor5/24.0.0/classic/ckeditor.js"></script>
<script>
    ClassicEditor
        .create( document.querySelector( '#editor' ) )
        .catch( error => {
            console.error( error );
        } );
</script>
</body>
</html>