<?php
require_once __DIR__ . '/../classes/user.php';
require_once __DIR__ . '/../classes/client.php';
require_once __DIR__ . '/../tools/tools.php';

class Admin extends User
{
    public function __construct()
    {
        $this->id = 0;
        $this->username = "admin";
        $this->email = "1234@gmail.com";
        $this->password = "fjeclot";
    }

    public function getUsername()
    {
        return $this->username;
    }

    public function createClient($client)
    {
        writetextfiles(FITXER_USUARIS, $client, "a");
		$taskfile = DIRECTORI_TASQUES. "/" ."{$client->getUsername()}";

        if (!file_exists($taskfile)) {
			mkdir($taskfile, 0755);
            writetextfiles($taskfile."/tasks", PHP_EOL, "w");
		}
    }

    public function readClients()
    {
        $userArray = array();
        $users = readtextfiles(FITXER_USUARIS);
        foreach ($users as $user) {
            $userdate = explode(":", $user);
            $id = $userdate[0];
            $username = $userdate[1];
            $email = $userdate[2];
            $password = $userdate[3];
            array_push($userArray, new Client($id, $username, $email, $password));
        }
        return $userArray;
    }

    public function updateClient($client)
    {
        $users = readtextfiles(DIRECTORI_TASQUES . "/" . $this->username . "/tasks");
        $updatedUsers = array();
        foreach ($users as $user) {
            $userdata = explode(":", $user);
            $id = $userdata[0];
            if ($client->getID() == $id) {
                $updatedUsers[] = $client->__toString() . PHP_EOL;
            } else {
                $updatedUsers[] = $users . PHP_EOL;
            }
        }
        //print_r($updatedTasks);
        writetextfiles(FITXER_USUARIS, $updatedUsers, "w");
    }

    public function deleteUser($userID)
    {
        $users = readtextfiles(FITXER_USUARIS);
        $updatedUsers = array();
        foreach ($users as $user) {
            $datauser = explode(":", $user);
            $id = $datauser[0];
            if ($userID == $id) {
                continue;
            } else {
                $updatedUsers[] = $user . PHP_EOL;
            }
        }
        //print_r($updatedTasks);
        writetextfiles(FITXER_USUARIS, $updatedUsers, "w");
    }

    public function checkID($userCheck)
    {
        $users = readtextfiles(FITXER_USUARIS);
        foreach ($users as $user) {
            $userdata = explode(":", $user);
            $id = $userdata[0];
            if ($userCheck->getID() == $id) {
                return true;
            }
        }
        return false;
    }
    
    public function lastID()
    {
        $users = readtextfiles(FITXER_USUARIS);
        //echo sizeof($tasks);
        if (sizeof($users) < 1) {
            //echo sizeof($tasks);
            return "0";
        } else {
            foreach ($users as $user) {
                $userdata = explode(":", $user);
                $id = $userdata[0];
            }
            return $id + 1;
        }
    }
}
