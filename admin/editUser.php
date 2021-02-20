<?php
session_start();
if (!isset($_SESSION["admin"]) or !$_SESSION["admin"]) {
    header('Location: /../../index.php');
    exit();
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
<h1 class="text-center">Editer un utilisateur</h1>
<form enctype="multipart/form-data" method="post" action="/admin/evenement.php" class="container border border-secondary border-2 rounded-3 m-5 mx-auto p-2">
    <div class="form-floating mb-3">
        <div class="form-floating mb-3">
            <input id="id" type="text" class="form-control" value="" name="id" readonly>
            <label for="id" class="form-label">Id</label>
        </div>
        <div class="form-floating mb-3">
        <input id="nom" type="text" class="form-control" value="" name="nom" required>
        <label for="nom" class="form-label">Pseudo</label>
        </div>
        <div class="form-floating mb-3">
        <input id="email" type="email" class="form-control <?php if (isset($email_valide)) {echo (! $email_valide) ? "is-invalid":"is-valid";}?>" value="<?php if (isset($_POST["email"])) {echo $_POST["email"];}?>" name="email" required>
        <label for="email">Adresse email</label>
        </div>
        <div class="form-floating mb-3">
            <input id="password" type="password" class="form-control <?php if (isset($password_valide)) {echo (! $password_valide) ? "is-invalid":"is-valide";}?>" value="<?php if (isset($_POST["password"])) {echo $_POST["password"];}?>" name="password" required>
            <label for="password">Password</label>
        </div>
    </div>
    <input type="submit" class="btn btn-primary" value="Envoyer">
</form>
