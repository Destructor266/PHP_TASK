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
    <form action="./task_form_update.php" method="post">
        <label for="idTask">ID: </label>
        <input type="text" name="idTask" id="idTask"><br>
        <label for="nameTask">Name: </label>
        <input type="text" name="nameTask" id="nameTask"><br>
        <label for="desc">Description: </label>
        <textarea name="desc" id="desc" cols="30" rows="10"></textarea><br>
        <label for="dateTask">Date: </label>
        <input type="date" name="dateTask" id="dateTask"><br>
        <label for="state">State: </label>
        <select name="state" id="state">
            <option value="0">START</option>
            <option value="1">WIP</option>
            <option value="2">FINALIZED</option>
        </select>
        <button type="submit">Submit</button>
    </form>
</body>
</html>


<?php
    if (isset($_POST['idTask']) && isset($_POST['nameTask']) && isset($_POST['desc']) && isset($_POST['dateTask']) && isset($_POST['state'])){
        $task = new Task($_POST['idTask'],$_POST['nameTask'],$_POST['desc'],$_POST['dateTask'], $_POST['state']);
        if ($_SESSION['usuari']->checkID($task)){
            $_SESSION['usuari']->updateTask($task);
        }
        
    }
    
?>