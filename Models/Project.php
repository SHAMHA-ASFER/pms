<?php
require_once __DIR__ ."/../core/Model.php";

class ProjectModel extends Model{
    private $create_project_table = "
    CREATE TABLE IF NOT EXISTS `project` (
        id INT AUTO_INCREMENT PRIMARY KEY,
        name VARCHAR(100) NOT NULL, 
        description TEXT,
        create_date DATE DEFAULT (CURRENT_TIMESTAMP),
        deadline DATE,
        status ENUM('active', 'completed', 'pending'),
        created_by INT REFERENCES user(user_id)
    );
    ";
    private $new = "INSERT INTO `project` (name, description, status, created_by,deadline) VALUES (?,?,?,?);";
    private $update_projectName ="UPDATE `project` SET name = ? WHERE id = ?";
    private $update_description = "UPDATE `project` SET description = ? WHERE id = ?";
    //private $update_status = "";
    private $delete_project = "DELETE FROM `project` WHERE id = ? ";

    public function __construct(){
        parent::__construct();
        $this->createProject();
    }

    public function createProject(){
        $this->create($this->create_project_table);
    }

    public function createNewProject($name,$description,$status,$created_by,$deadline){
        $this->create($this->new,[$name,$description,$status,$created_by],"ssssi");
    }

    public function update_ProjectName($id,$name){
        $this->update($this->update_projectName,[$id,$name],"is");
    }

    public function update_description($id,$description){
        $this->update($this->update_description,[$id,$description],"is");
    }

    public function deleteProject($id){
        $this->delete($this->delete_project,[$id],"i");
    }

}
?>