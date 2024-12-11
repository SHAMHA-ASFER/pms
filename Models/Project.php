<?php
require_once __DIR__ ."/../core/Model.php";

class ProjectModel extends Model{
    private $create_project_table = "
        CREATE TABLE IF NOT EXISTS `project` (
            id INT AUTO_INCREMENT PRIMARY KEY,
            name VARCHAR(100) NOT NULL, 
            description TEXT NOT NULL,
            create_date DATE DEFAULT (CURRENT_TIMESTAMP),
            deadline DATE NOT NULL,
            status ENUM('completed', 'pending') DEFAULT 'pending',
            created_by INT REFERENCES user(user_id) ON DELETE CASCADE
        );
    ";
    private $new = "INSERT INTO `project` (name, description, created_by, deadline) VALUES (?,?,?,?);";
    private $update_status = "UPDATE `project` SET status = ? WHERE id = ?";
    private $delete_project = "DELETE FROM `project` WHERE id = ? ";
    private $get_all = "SELECT * FROM `project`";
    
    private $get_name = "SELECT name FROM `project` WHERE id = ?";

    public function __construct(){
        parent::__construct();
        $this->createProject();
    }

    public function createProject(){
        $this->create($this->create_project_table);
    }

    public function createNewProject($name,$description,$created_by,$deadline){
        $this->create($this->new,[$name,$description,$created_by, $deadline],"ssis");
    }

    public function deleteProject($id){
        $this->delete($this->delete_project,[$id],"i");
    }

    public function getAllProjects() {
        return $this->fetch($this->get_all);
    }

    public function getName($id) {
        return $this->fetch($this->get_name,[$id],"i");
    }

    public function updateStatus($pro_id, $status) {
        $this->update($this->update_status, [$status, $pro_id], "si");
    }
}