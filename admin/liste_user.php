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
<div class="container border border-secondary border-2 rounded-3 m-5 mx-auto p-2">
    <h1>
        Liste User
    </h1>
    <ul class="list-group">
        <?php
        $bdd = new PDO("mysql:host=localhost;dbname=brains", "root", "root");
        $req = $bdd->prepare("select id, name from user");
        $req->execute();
        while ($data = $req->fetch()) { ?>
            <a href="editUser.php?id=<?php echo $data["id"]?>"> <li class="list-group-item"><?php echo $data["name"] ?></li></a>
        <?php } ?>
    </ul>

</div>
</body>
</html>