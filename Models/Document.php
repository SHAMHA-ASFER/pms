<?php
require_once __DIR__ ."/../core/Model.php";

class DocumentModel extends Model{
    private $create_documnet_table = "
        CREATE TABLE IF NOT EXISTS `document`(
            id INT AUTO_INCREMENT PRIMARY KEY,
            pro_id INT REFERENCES project (id) ON DELETE CASCADE,
            name VARCHAR(100) NOT NULL,
            location VARCHAR(100) NOT NULL,
            status ENUM('pending', 'accepted') DEFAULT 'pending',
            last_modified DATE DEFAULT (CURRENT_TIMESTAMP),
            updated_by INT REFERENCES user(id) ON DELETE CASCADE            
        );
    ";
    private $new = "INSERT INTO `document`(name , pro_id, location, updated_by) VALUES (?,?,?,?);";
    private $update_document = "UPDATE `document` SET location = ?, last_modified = CURRENT_TIMESTAMP WHERE id = ?";
    private $get_document = "SELECT * FROM `document` WHERE id = ?";
    private $get_all_document_by_project = "SELECT * FROM  `document` WHERE pro_id = ?";
    private $get_all_document = "SELECT * FROM  `document`";
    private $delete_document = "DELETE FROM `document` WHERE id = ?";
    private $update_status = "UPDATE `document` SET status = ? WHERE id = ?";
    private $status = "SELECT COLUMN_TYPE FROM INFORMATION_SCHEMA.COLUMNS WHERE TABLE_NAME = 'document' AND COLUMN_NAME = 'status' AND TABLE_SCHEMA = 'projects';";
    

    public function __construct(){
        parent::__construct();
        $this->createDocumnet();
    }

    public function createDocumnet(){
        $this->create($this->create_documnet_table);
    }

    public function createNewDocument($name, $pro_id, $location, $updated_by){
        $this->insert($this->new,[$name, $pro_id, $location, $updated_by],"sisi");
    }

    public function deleteDocument($id){
        $this->delete($this->delete_document,[$id],"i");
    }

    public function updateDocument($location, $id) {
        $this->update($this->update_document, [$location, $id], "si");
    }

    public function getDocument($id){
        return $this->fetch($this->get_document,[$id],"i");
    }

    public function getAllDocumentsByProject($pro_id){
        return $this->fetch($this->get_all_document_by_project, [$pro_id],"i");
    }

    public function getAllDocuments(){
        return $this->fetch($this->get_all_document);
    }

    public function setStatus($id, $status) {
        $this->update($this->update_status,[$status,$id],"si");
    }

    public function getStatus(){
        return $this->fetch($this->status);
    }
}