<?php
require_once __DIR__ ."/../core/Model.php";

class TaskModel extends Model{
    private $create_task_table = "
    CREATE TABLE IF NOT EXISTS `task`(
        id INT AUTO_INCREMENT PRIMARY KEY,
        name VARCHAR(100) NOT NULL,
        description TEXT,
        deadline DATE,
        status ENUM('not started', 'in progress', 'completed'),
        created_by INT REFERENCES user(id),
        assignee INT REFERENCES user(id),
        project_id INT REFERENCES project(id)
    );
    ";
    private $new = "INSERT INTO `task` (name,description,deadline,status,created_by,assignee,project_id) VALUES (?,?,?,?,?,?,?);";
    private $update_taskName = "UPDATE `task` SET name = ? WHERE id = ?";
    private $update_deadline = "UPDATE `task` SET deadline = ? WHERE id = ?";
    private $update_description = "UPDATE `task` SET deadline = ? WHERE id = ?";
    private $delete_task = "DELETE FROM `task` WHERE id = ?";

    //assign

    public function __construct(){
        parent::__construct();
        $this->createTask();
    }

    public function createTask(){
        $this->create($this->create_task_table);
    }

    public function createNewTask($name,$description,$deadline,$status,$created_by,$assignee,$project_id){
        $this->insert($this->new,[$name,$description,$deadline,$status,$created_by,$assignee,$project_id],"ssisssi");
    }

    public function updateTaskName($id,$name){
        $this->update($this->update_taskName,[$id,$name],"is");
    }

    public function updateDeadline($id,$deadline){
        $this->update($this->update_deadline,[$id,$deadline],"ii");
    }

    public function updateDescription($id,$description){
        $this->update($this->update_description,[$id,$description],"is");
    }

    public function deleteTask($id){
        $this->delete($this->delete_task,[$id],"i");
    }
}
?>