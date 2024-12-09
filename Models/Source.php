<?php

require_once __DIR__ ."/../core/Model.php";

class SourceModel extends Model{
    private $create_source_table = "
    CREATE TABLE IF NOT EXISTS `source`(
        id INT AUTO_INCREMENT PRIMARY KEY,
        name VARCHAR(100),
        location TEXT,
        last_modified DATE DEFAULT (CURRENT TIMESTAMP),
        task_id INT REFERENCES task(task_id) ON DELETE CASCADE
    );
    ";

    private $new = "INSERT INTO `file` (name , location) VALUES (?,?)";
    private $update_source = "UPDATE `file` SET name = ? , last_modified = CURRENT_TIMESTAMP WHERE id = ? ";
    private $delete_source = "DELETE FROM `file` WHERE id = ? "; 

    public function __construct(){
        parent::__construct();
        $this->createSource();
    }

    public function createSource(){
        $this->create($this->create_source_table);
    }

    public function createNewSource($name,$location){
        $this->insert($this->new,[$name,$location],"ss");
    }

    public function deleteSource($id){
        $this->delete($this->delete_source,[$id],"i");
    }

}


?>