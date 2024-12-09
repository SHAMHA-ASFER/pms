<?php
require_once __DIR__ ."/../core/Model.php";

class ProjectAnalyzerModel extends Model {
    private $create_project_analyzer_table = "
        CREATE TABLE IF NOT EXISTS `project_analyzer` (
            pro_id INT REFERENCES `project` (id) ON DELETE CASCADE,
            user_id INT REFERENCES `user` (id) ON DELETE CASCADE,
            PRIMARY KEY (pro_id, user_id)
        );
    ";
    private $new = "INSERT INTO `project_analyzer` (pro_id, user_id) VALUES (?,?);";
    private $get_projects = "SELECT pro_id FROM `project_analyzer` WHERE user_id = ?";
    private $get_analyzer = "SELECT user_id FROM `project_analyzer` WHERE pro_id = ?";
    private $count = "SELECT COUNT(*) as count FROM `project_analyzer` WHERE pro_id = ?";
    private $remove = "DELETE FROM `project_analyzer` WHERE user_id = ? AND pro_id = ?";

    public function __construct() {
        parent::__construct();
        $this->createProjectAnalyzer();
    }

    public function createProjectAnalyzer() {
        $this->create($this->create_project_analyzer_table);
    }

    public function createNewProjectAnalyzer($pro_id, $user_id) {
        $this->insert($this->new, [$pro_id, $user_id], "ii");
    }

    public function getAllProjects($id) {
        return $this->fetch($this->get_projects,[$id], "i");
    }

    public function getAllAnalyzers($pro_id) {
        return $this->fetch($this->get_analyzer, [$pro_id],"i");
    }

    public function getCount($pro_id) {
        return $this->fetch($this->count, [$pro_id],"i");
    }

    public function removeAnalyzer($pro_id, $user_id) {
        $this->delete($this->remove,[$user_id,$pro_id],"ii");
    }
}