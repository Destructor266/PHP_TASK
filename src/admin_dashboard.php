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
    <title>Task Management</title>
</head>
<body>
    <a href="./user_form_write.php">Create user</a>
    <a href="./user_form_delete.php">Delete user</a>
    <a href="./user_form_update.php">Update user</a>
    <a href="./logout.php">Logout <?php echo $_SESSION['usuari']->getUsername()?></a>
    <table>
        <tr>
            <th>ID</th>
            <th>Username</th>
            <th>Email</th>
            <th>Password</th>
        </tr>
        <?php 
            $users = $_SESSION['usuari']->readClients();
            for ($i=0; $i < sizeof($users); $i++) {        
        ?>
            <tr>
                <td><?php echo "{$users[$i]->getID()}" ?></td>
                <td><?php echo "{$users[$i]->getUsername()}" ?></td>
                <td><?php echo "{$users[$i]->getEmail()}" ?></td>
                <td><?php echo "{$users[$i]->getPassword()}" ?></td>
            </tr>
        <?php
            }
        ?> 
    </table>
</body>
</html>