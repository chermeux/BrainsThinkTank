<?php
session_start();
if (!isset($_SESSION["admin"]) or !$_SESSION["admin"]) {
    header('Location: /../../index.php');
    exit();
}
?>


<?php
$id_val = "-1";
$user_val = "";
$email_val = "";
$user_valide = "";
$email_valide = "";
$password_valide = "";
if (isset($_GET['id'])) {
    $id_val = $_GET['id'];
    $bdd = new PDO('mysql:host=localhost;dbname=brains;charset=utf8', 'root', 'root');
    $req = $bdd->prepare("SELECT name, email from user where id = ?");
    $req->execute(array($_GET["id"]));
    if (! ($data = $req->fetch())) {
        $error = "Evenement non trouvé";
    }
    else {
        $user_val = $data["name"];
        $email_val = $data["email"];
    }
}

if (isset($_POST['new'])) {
    $update = TRUE;
    if (! isset($_POST["id"])) {
        $error = "id pas definie";
        $update = FALSE;
    } else {
        $id_val = $_POST['id'];
    }
    if (! isset($_POST["user"])) {
        $error = "user pas definie";
        $update = FALSE;
    } else {
        $user_val = $_POST['user'];
        $user_valide = "is-valid";
    }
    if (! isset($_POST["email"])) {
        $error = "email pas definie";
        $update = FALSE;
        $email_valide = "is-invalid";
    } else if (!filter_var($_POST["email"], FILTER_VALIDATE_EMAIL)) {
        $error = "email pas valide";
        $update = FALSE;
        $email_val = $_POST['email'];
        $email_valide = "is-invalid";
    } else {
        $email_val = $_POST['email'];
        $email_valide = "is-valid";
    }
    if (!isset($_POST["password"])) {
        $error = "password pas definie";
        $update = FALSE;
        $password_valide = "is-invalid";
    } else {
        $password_valide = "is-valide";
        $password_val = $_POST['password'];
    }

    if ($update){
        $bdd = new PDO('mysql:host=localhost;dbname=brains;charset=utf8', 'root', 'root');
        if ($id_val == -1) {
            $req = $bdd->prepare("INSERT INTO brains.user (id, NAME, email, PASSWORD)
                VALUES (null, ?, ?, ?);");
            $req->execute(array($user_val, $email_val, password_hash($password_val, PASSWORD_DEFAULT )));
        } else {
            $req = $bdd->prepare("UPDATE brains.user t
SET t.NAME = ?,
t.EMAIL = ?,
t.PASSWORD = ?
WHERE t.id = ?");
            $req->execute(array($user_val, $email_val, password_hash($password_val, PASSWORD_DEFAULT )));
        }
        $message = "Modification effectuée";
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
<h1 class="text-center">Editer un utilisateur</h1>
<form enctype="multipart/form-data" method="post" action="/admin/connexion.php" class="container border border-secondary border-2 rounded-3 m-5 mx-auto p-2">
    <div class="form-floating mb-3">
        <div class="form-floating mb-3">
            <input id="id" type="text" class="form-control" value="<?php echo $id_val ?>" name="id" readonly>
            <label for="id" class="form-label">Id</label>
        </div>
        <div class="form-floating mb-3">
        <input id="nom" type="text" class="form-control <?php echo $user_valide ?>" value="<?php echo $user_val ?>" name="nom" required>
        <label for="nom" class="form-label">Pseudo</label>
        </div>
        <div class="form-floating mb-3">
        <input id="email" type="email" class="form-control <?php echo $email_valide ?>" value="<?php echo $email_val?>" name="email" required>
        <label for="email">Adresse email</label>
        </div>
        <div class="form-floating mb-3">
            <input id="password" type="password" class="form-control <?php echo $password_valide ?>" value="" name="password" required>
            <label for="password">Password</label>
        </div>
    </div>
    <input type="submit" class="btn btn-primary" value="Envoyer">
</form>
