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
    <title>Task Management</title>
</head>
<body>
    <a href="./task_form_write.php">Create task</a>
    <a href="./task_form_delete.php">Delete task</a>
    <a href="./task_form_update.php">Update task</a>
    <a href="./logout.php">Logout <?php echo $_SESSION['usuari']->getUsername()?></a>
    <table>
        <tr>
            <th>ID</th>
            <th>Name</th>
            <th>Description</th>
            <th>Date</th>
            <th>State</th>
        </tr>
        <?php 
            $tasks = $_SESSION['usuari']->readTasks();
            for ($i=0; $i < sizeof($tasks); $i++) {        
        ?>
            <tr>
                <td><?php echo "{$tasks[$i]->getID()}" ?></td>
                <td><?php echo "{$tasks[$i]->getName()}" ?></td>
                <td><?php echo "{$tasks[$i]->getDesc()}" ?></td>
                <td><?php echo "{$tasks[$i]->getDueDate()}" ?></td>
                <td><?php 
                    if ($tasks[$i]->getState() == 0) {
                        echo "START";
                    }else if ($tasks[$i]->getState() == 1){
                        echo "WIP";
                    }else if ($tasks[$i]->getState() == 2){
                        echo "FINALIZED";
                    }
                ?></td>
            </tr>
        <?php
            }
        ?> 
    </table>
</body>
</html>