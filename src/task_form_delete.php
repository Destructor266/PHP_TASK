<?php
    ini_set('display_errors', '1');
    ini_set('display_startup_errors', '1');
    error_reporting(E_ALL);
    require_once __DIR__ .'/./classes/client.php';
    
    session_start();
    if (!isset($_SESSION['usuari'])) {
        header("Location: error_acces.php");
    } else {
        if (!isset($_SESSION['expira']) || (time() - $_SESSION['expira'] >= 0)) {
            header("Location: logout_expira_sessio.php");
        } else if (get_class($_SESSION['usuari']) != 'Client') {
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
    <a href="./client_dashboard.php">Home</a>
    <a href="./logout.php">Logout <?php echo $_SESSION['usuari']->getUsername()?></a>
    <form action="./task_form_delete.php" method="post">
        <label for="idTask">ID: </label>
        <input type="text" name="idTask" id="idTask"><br>
        <button type="submit">Submit</button>
    </form>
</body>
</html>


<?php
    if (isset($_POST['idTask'])) {
        $_SESSION['usuari']->deleteTask($_POST['idTask']);
    }
?>