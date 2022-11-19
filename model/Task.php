<?php

class TaskException extends Exception{ }

class Task {
    private $_id;
    private $_title;
    private $_description;
    private $_deadline;
    private $_completed;

    public function __construct($id,$title,$description,$deadline,$completed){
        $this->setId($id);
        $this->setTitle($title);
        $this->setDescription($description);
        $this->setDeadline($deadline);
        $this->setCompleted($completed);
    }

    // Getters
    public function getId() {
        return $this->_id;
    }

     public function getTitle() {
        return $this->_title;
    }

    public function getDescription() {
        return $this->_description;
    }

    public function getDeadline() {
        return $this->_deadline;
    }

    public function getCompleted() {
        return $this->_completed;
    }

    // Setters
    public function setId($id)
    {
        if($id !== null && (!is_numeric($id) || $id < 1 || $id > 9223372036854775807 || $this->id !== null )){
            throw new TaskException("Task ID error");
        }

        $this->_id = $id;
    }

    public function setTitle($title)
    {
        if(strlen($title) < 1 || strlen($title) > 255){
            throw new TaskException("Title error");
        }

        $this->_title = $title;
    }

    public function setDescription($description)
    {
        if(($description !== null) && (strlen($description) > 16777215)){
            throw new TaskException("Task Description Error");
        }

        $this->_description = $description;
    }

    public function setDeadline($deadline)
    {   // making sure that given deadline is a valid date time
        if(($deadline !== null) && date_format(date_create_from_format("d/m/y H:i",$deadline),"d/m/y H:i") != $deadline){
            throw new TaskException("Task deadline date time error");
        }

        $this->_deadline = $deadline;
    }

    public function setCompleted($completed)
    {
        if(strtoupper($completed) !== 'Y' || strtoupper($completed) !== 'N'){
            throw new TaskException("Invalid enum type for task completion");
        }

        $this->_completed = $completed;
    }

    // Special array created for returning the api info as an associative array which will later be encoded according to the json format
    public function returnTaskAsArray(){
        $task = array();
        $task['id'] = $this->getId();
        $task['title'] = $this->getTitle();
        $task['description'] = $this->getDescription();
        $task['deadline'] = $this->getDeadline();
        $task['completed'] = $this->getCompleted();

        // returning the array to be encoded according to the json format
        return $task;
    }


}