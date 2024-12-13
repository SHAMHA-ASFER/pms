<?php
require_once __DIR__ ."/../Models/Task.php";
require_once __DIR__ ."/../Models/TaskQA.php";
require_once __DIR__ ."/../Models/Project.php";
require_once __DIR__ ."/../Models/File.php";
require_once __DIR__ ."/../Models/ProjectQA.php";
require_once __DIR__ ."/../Models/User.php";

class QAController extends Controller{
    private $taskModel;
    private $taskQAModel;
    private $projectModel;
    private $projectQAModel;
    private $fileModel;
    private $userModel;

    public function __construct(){
        parent::__construct();
        $this->initNav();
        $this->taskModel = new TaskModel();
        $this->projectModel = new ProjectModel();
        $this->fileModel = new FileModel();
        $this->projectQAModel = new ProjectQAModel();
        $this->userModel = new UserModel();
        $this->taskQAModel = new TaskQAModel();
    }

    public function index(){
        include_once __DIR__ ."/../views/qa/QA.php";
    }

    public function updateTaskStatus() {
        if ($_SERVER["REQUEST_METHOD"] == "POST") {
            $pro_id = $_POST['pro_id'];
            $task_id = $_POST['task_id'];
            $status = $_POST['status'];
            $this->taskModel->updateTaskStatus($task_id, $status);
        }
        $this->redirect('/qa/dashboard?page=task&id=' . $pro_id);
    }

    public function downloadTask() {
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            $task_id = $_POST['task_id'];
            $pro_id = $_POST['pro_id'];
            $project_name = "";
            $projects = $this->projectModel->getName($pro_id);
            while ($project = $projects->fetch_assoc() ) {
                $project_name = $project["name"];
            }
            $sources = $this->fileModel->getAllByFiles($task_id);
            $files = [];
            while ($source = $sources->fetch_assoc()) {
                $files[] = __DIR__ . "/../assets/projects/" .$project_name . "/src/" .$source['location'];
            }
            $zip = new ZipArchive();
            $zipFile = $project_name . ".zip";
            if ($zip->open($zipFile, ZipArchive::CREATE) === true) {
                foreach($files as $file) {
                    if (file_exists($file)) {
                        $absPath = realpath($file);
                        if ($handle = fopen($absPath, "r")) {
                            fclose($handle);
                        } 
                        // $zip->addFile($file, basename($file));
                    }
                }
            }
            $zip->close();
            // header('Content-Type: application/zip');
            // header('Content-Disposition: attachment; filename="' . $zipFile . '"');
            // header('Content-Length: ' . filesize($zipFile));
            // readfile($zipFile);
            // unlink($zipFile);
        }
        // $this->redirect('/qa/dashboard?page=task&id=' . $pro_id);
    }
}