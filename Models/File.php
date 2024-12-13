<?php
require_once __DIR__ . "/../core/Model.php";

class FileModel extends Model {
    private $create_file_table = "
        CREATE TABLE IF NOT EXISTS `file` (
            id INT PRIMARY KEY AUTO_INCREMENT,
            task_id INT REFERENCES `task` (id) ON DELETE CASCADE,
            location VARCHAR(256) NOT NULL,
            type ENUM('file', 'folder') NOT NULL
        );
    ";
    private $insert_file = "INSERT INTO `file` (task_id, location, type) VALUES (?, ?, ?)";
    private $get_files = "SELECT * FROM `file` WHERE task_id = ?";
    private $delete_file = "DELETE FROM `file` WHERE task_id = ? AND type = ?";
    private $get_all_by_files = "SELECT * FROM `file` WHERE task_id = ? AND type = 'file'";
    private $get_all_by_folders = "SELECT * FROM `file` WHERE task_id = ? AND type = 'folder'";

    public function __construct() {
        parent::__construct();
        $this->createFile();
    }

    public function createFile() {
        $this->create($this->create_file_table);
    }

    public function createNewFile($task_id, $location, $type) {
        $this->insert($this->insert_file, [$task_id, $location, $type], "iss");
    }

    public function deleteFile($id, $type) {
        $this->delete($this->delete_file, [$id, $type] , "is");
    }

    public function getAllFilesByTask($task_id) {
        return $this->fetch($this->get_files, [$task_id],"i");
    }

    public function getAllByFiles($task_id) {
        return $this->fetch($this->get_all_by_files, [$task_id],"i");
    }

    public function getAllByFolder($task_id) {
        return $this->fetch($this->get_all_by_folders, [$task_id],"i");
    }
}