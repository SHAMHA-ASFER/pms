<?php
require_once __DIR__ ."/../core/Model.php";

class TaskQAModel extends Model {
    private $create_task_qa_table = "
        CREATE TABLE IF NOT EXISTS `task_qa`(
            qa_id INT REFERENCES `user` (id) ON DELETE CASCADE,
            task_id INT REFERENCES `task` (id) ON DELETE CASCADE,
            PRIMARY KEY (qa_id, task_id)
        );
    ";
    private $insert_qa = "INSERT INTO `task_qa` (qa_id, task_id) VALUES (?, ?);";
    private $get_task = "SELECT task_id FROM `task_qa` WHERE qa_id = ?";
    private $get_qa = "SELECT qa_id FROM `task_qa` WHERE task_id = ?";
    private $delete = "DELETE FROM `task_qa` WHERE qa_id = ?";

    public function __construct() {
        parent::__construct();
        $this->createTaskQa();
    }

    public function createTaskQa() {
        $this->create($this->create_task_qa_table);
    }

    public function createNewTaskQa($qa_id, $task_id) {
        $this->insert($this->insert_qa, [$qa_id, $task_id], "ii");
    }

    public function getAllTasks($qa_id) {
        return $this->fetch($this->get_task, [$qa_id], "i");
    }

    public function getAllQas($task_id) {
        return $this->fetch($this->get_qa, [$task_id], "i");
    }

    public function removeQA($qa_id) {
        $this->delete($this->delete, [$qa_id], "i");
    }
}