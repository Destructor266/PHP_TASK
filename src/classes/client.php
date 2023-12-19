<?php
require_once __DIR__ . '/../classes/user.php';
require_once __DIR__ . '/../classes/task.php';
require_once __DIR__ . '/../tools/tools.php';

class Client extends User
{
    public function __construct($id, $username, $email, $password)
    {
        parent::__construct($id, $username, $email, $password);
    }

    public function getID()
    {
        return $this->id;
    }

    public function getUsername()
    {
        return $this->username;
    }

    public function getEmail()
    {
        return $this->email;
    }

    public function getPassword()
    {
        return "*****";
    }

    public function createTask($taskCreate)
    {
        writetextfiles(DIRECTORI_TASQUES . "/" . $this->username . "/tasks", $taskCreate, "a");
    }

    public function readTasks()
    {
        $tasksArray = array();
        $tasks = readtextfiles(DIRECTORI_TASQUES . "/" . $this->username . "/tasks");
        foreach ($tasks as $task) {
            $datatask = explode(":", $task);
            $id = $datatask[0];
            $name = $datatask[1];
            $desc = $datatask[2];
            $due_date = $datatask[3];
            $state = $datatask[4];
            array_push($tasksArray, new Task($id, $name, $desc, $due_date, $state));
        }

        return $tasksArray;
    }

    public function updateTask($taskUp)
    {
        $tasks = readtextfiles(DIRECTORI_TASQUES . "/" . $this->username . "/tasks");
        $updatedTasks = array();
        foreach ($tasks as $task) {
            $datatask = explode(":", $task);
            $id = $datatask[0];
            if ($taskUp->getID() == $id) {
                $updatedTasks[] = $taskUp->__toString() . PHP_EOL;
            } else {
                $updatedTasks[] = $task . PHP_EOL;
            }
        }
        //print_r($updatedTasks);
        writetextfiles(DIRECTORI_TASQUES . "/" . $this->username . "/tasks", $updatedTasks, "w");
    }

    public function deleteTask($taskID)
    {
        $tasks = readtextfiles(DIRECTORI_TASQUES . "/" . $this->username . "/tasks");
        $updatedTasks = array();
        foreach ($tasks as $task) {
            $datatask = explode(":", $task);
            $id = $datatask[0];
            if ($taskID == $id) {
                continue;
            } else {
                $updatedTasks[] = $task . PHP_EOL;
            }
        }
        //print_r($updatedTasks);
        writetextfiles(DIRECTORI_TASQUES . "/" . $this->username . "/tasks", $updatedTasks, "w");
    }

    public function checkID($taskCheck)
    {
        $tasks = readtextfiles(DIRECTORI_TASQUES . "/" . $this->username . "/tasks");
        foreach ($tasks as $task) {
            $datatask = explode(":", $task);
            $id = $datatask[0];
            if ($taskCheck->getID() == $id) {
                return true;
            }
        }
        return false;
    }

    public function lastID()
    {
        $tasks = readtextfiles(DIRECTORI_TASQUES . "/" . $this->username . "/tasks");
        //echo sizeof($tasks);
        if (sizeof($tasks) < 1) {
            //echo sizeof($tasks);
            return "0";
        } else {
            foreach ($tasks as $task) {
                $datatask = explode(":", $task);
                $id = $datatask[0];
            }
            return $id + 1;
        }
    }

    public function __toString()
    {
        return $this->id . ":" . $this->username . ":" . $this->email . ":" . $this->password;
    }
}
