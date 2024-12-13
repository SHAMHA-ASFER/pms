<?php
require_once __DIR__ ."/../core/Model.php";

class ResourceModel extends Model {
    private $create_resource_table = "
    CREATE TABLE IF NOT EXISTS `resource`(
        id INT AUTO_INCREMENT PRIMARY KEY,
        title VARCHAR(150),
        description TEXT,
        link TEXT
    );
    ";

    private $new = "INSERT INTO `resource` (title,description,link) VALUES (?,?,?);";
    private $delete_resource = "DELETE FROM `resource` WHERE id = ?";
    //private $get_resource = "SELECT ";
    private $get_all_resource = "SELECT * FROM `resource`";

    public function __construct() {
        parent::__construct();
        $this->createResource();
    }

    public function createResource(){
        $this->create($this->create_resource_table);
    }

    public function createNewResource($title,$description,$link){
        $this->insert($this->new,[$title,$description,$link],"sss");
    }

    public function deleteResource($id){
        $this->delete($this->delete_resource,[$id],"i");
    }

    public function get_all_resource(){
        return $this->fetch($this->get_all_resource);
    }

}