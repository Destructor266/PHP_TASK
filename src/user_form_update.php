<?php
    ini_set('display_errors', '1');
    ini_set('display_startup_errors', '1');
    error_reporting(E_ALL);
    require_once __DIR__ .'/./classes/admin.php';
    
    session_start();
    if (!isset($_SESSION['usuari'])) {
        header("Location: error_acces.php");
    } else {
        if (!isset($_SESSION['expira']) || (time() - $_SESSION['expira'] >= 0)) {
            header("Location: logout_expira_sessio.php");
        } else if (get_class($_SESSION['usuari']) != 'Admin') {
            header("Location: error_autoritzacio.php");
        }
    }
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Create Task</title>
</head>
<body>
    <a href="./admin_dashboard.php">Home</a>
    <a href="./logout.php">Logout <?php echo $_SESSION['usuari']->getUsername()?></a>
    <form action="./user_form_update.php" method="post">
        <label for="idUser">ID: </label>
        <input type="text" name="idUser" id="idUser"><br>
        <label for="nameUser">Username: </label>
        <input type="text" name="nameUser" id="nameUser"><br>
        <label for="email">Email: </label>
        <input type="text" name="email" id="email"><br>
        <label for="password">Password: </label>
        <input type="password" name="password" id="password"><br>
        <button type="submit">Submit</button>
    </form>
</body>
</html>


<?php
    if (isset($_POST['idUser']) && isset($_POST['nameUser']) && isset($_POST['email']) && isset($_POST['password'])){
        $client = new Client($_POST['idUser'],$_POST['nameUser'],$_POST['email'],password_hash($_POST['password'], PASSWORD_DEFAULT));
        if ($_SESSION['usuari']->checkID($client)){
            $_SESSION['usuari']->updateClient($client);
        }
    }
?>