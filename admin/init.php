<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8"/>

    <title>/!\ Admin only</title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta1/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-giJF6kkoqNQ00vy+HMDP7azOuL0xtbfIcaT9wjKHr8RbDVddVHyTfAAsrekwKmP1" crossorigin="anonymous">
</head>
<body>

<?php

$password = "5868"; //TODO changer le password hardcoder

if (isset($_POST["password"]) && $_POST["password"] == $password) {
    ini_set("session.lifetime", "86400");
    $sessions = glob(sys_get_temp_dir().'/sess_*');
    array_map('unlink', $sessions);
    $bdd = new PDO('mysql:host=localhost;dbname=brains;charset=utf8', 'root', 'root');
    $req1 = $bdd->prepare("select * from user where name = 'admin'");
    $req1->execute();
    if ($req1->fetch()) {
        $req = $bdd->prepare("UPDATE brains.user t set t.PASSWORD = ? WHERE t.name='admin'");
    } else {
        $req = $bdd->prepare("INSERT INTO brains.user (id, NAME, email, PASSWORD) VALUES (null, 'admin', 'admin@example.com', ?);");
    }
    $req1->execute(password_hash($password, PASSWORD_DEFAULT));
    echo "admin cree";
} else { ?>
<form method="POST" action="init.php">
    <label for="password">mdp</label><input type="password" name="password" id="password">
    <input type="submit">
</form>
<?php } ?>
</body>
</html>
