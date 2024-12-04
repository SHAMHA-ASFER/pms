<?php
require_once __DIR__ ."/../core/Model.php";

class DocumentModel extends Model{
    private $create_documnet_table = "
        CREATE TABLE IF NOT EXISTS `document`(
            id INT AUTO_INCREMENT PRIMARY KEY,
            name VARCHAR(100) NOT NULL,
            created_date DATE DEFAULT (CURRENT_TIMESTAMP),
            last_modified DATE DEFAULT (CURRENT_TIMESTAMP),
            created_by INT REFERENCES user(id)             
        );
    ";

    private $new = "INSERT INTO `document`(name , created_by) VALUES (? , ?);";
    private $update_document = "UPDATE `document` SET name = ?, last_modified = CURRENT_TIMESTAMP WHERE id = ?";
    private $modify_content = "UPDATE `document` last_modified = CURRENT_TIMESTAMP WHERE id = ?";
    private $get_document = "SELECT FROM `document` WHERE id = ?";
    private $get_all_document = "SELECT * FROM  `document`";
    private $delete_document = "DELETE FROM `document` WHERE id = ?";


    public function __construct(){
        parent::__construct();
        $this->createDocumnet();
    }

    public function createDocumnet(){
        $this->create($this->create_documnet_table);
    }

    public function createNewDocument($name,$created_by){
        $this->insert($this->new,[$name,$created_by],"si");
    }

    public function updateDocument($id){
        $this->update($this->update_document,[$id],"i");
    }

    public function deleteDocument($id){
        $this->delete($this->delete_document,[$id],"i");
    }

    public function get_document($id){
        return $this->fetch($this->get_document,[$id],"i");
    }

    public function get_all_document(){
        return $this->fetch($this->get_all_document);
    }

    

}
?>