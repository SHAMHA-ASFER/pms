<?php
require_once __DIR__ ."/../core/Model.php";

class TaskDeveloperModel extends Model {
    private $create_task_developer_table = "
        CREATE TABLE IF NOT EXISTS `task_developer`(
            dev_id INT REFERENCES `user` (id) ON DELETE CASCADE,
            task_id INT REFERENCES `task` (id) ON DELETE CASCADE,
            PRIMARY KEY (dev_id, task_id)
        );
    ";
    private $insert_dev = "INSERT INTO `task_developer` (dev_id, task_id) VALUES (?, ?);";
    private $get_task = "SELECT task_id FROM `task_developer` WHERE dev_id = ?";
    private $get_dev = "SELECT dev_id FROM `task_developer` WHERE task_id = ?";
    private $delete = "DELETE FROM `task_developer` WHERE dev_id = ?";

    public function __construct() {
        parent::__construct();
        $this->createTaskDeveloper();
    }

    public function createTaskDeveloper() {
        $this->create($this->create_task_developer_table);
    }

    public function createNewTaskDeveloper($div_id, $task_id) {
        $this->insert($this->insert_dev, [$div_id, $task_id], "ii");
    }

    public function getAllTasks($dev_id) {
        return $this->fetch($this->get_task, [$dev_id], "i");
    }

    public function getAllDevelopers($task_id) {
        return $this->fetch($this->get_dev, [$task_id], "i");
    }

    public function removeDeveloper($div_id) {
        $this->delete($this->delete, [$div_id], "i");
    }
}