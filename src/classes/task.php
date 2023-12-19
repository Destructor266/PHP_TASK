<?php
    class Task{
        private $id;
        private $name;
        private $desc;
        private $due_date;
        private $state;
        public function __construct($id, $name, $desc, $due_date, $state)
        {
            $this->id = $id;
            $this->name = $name;
            $this->desc = $desc;
            $this->due_date = $due_date;
            $this->state = $state;
        }

        public function getID(){
            return $this->id;
        }

        public function getName(){
            return $this->name;
        }

        public function getDesc(){
            return $this->desc;
        }

        public function getDueDate(){
            return $this->due_date;
        }

        public function getState(){
            return $this->state;
        }

        public function __toString()
        {
            return $this->id . ":" . $this->name . ":" . $this->desc . ":" . $this->due_date . ":" . $this->state;
        }
    }
?>