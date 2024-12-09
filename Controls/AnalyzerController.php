<?php
require_once __DIR__ ."/../Models/Document.php";
require_once __DIR__ ."/../Models/Project.php";
require_once __DIR__ ."/../Models/User.php";
require_once __DIR__ ."/../Models/ProjectAnalyzer.php";

class AnalyzerController extends Controller{
    private $documentModel;
    private $projectModel;
    private $userModel;
    private $projectAnalyzerModel;

    public function __construct(){
        parent::__construct();
        $this->initNav();
        $this->projectModel = new ProjectModel();
        $this->documentModel = new DocumentModel();
        $this->userModel = new UserModel();
        $this->projectAnalyzerModel = new ProjectAnalyzerModel();
    }

    public function index(){
        $projects = $this->projectAnalyzerModel->getAllProjects($_SESSION['id']);
        $documents = $this->documentModel->getAllDocuments();
        $mdocuments = $this->documentModel->getAllDocuments();
        $model = $this->projectModel;
        include_once __DIR__ ."/../views/analyzer.php";
    }

    public function createDocument() {
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            $name = $_POST['name'];
            $pro_id = $_POST['project'];
            $project = $this->projectModel->getName($pro_id);
            $project_name = "";
            while ($row = $project->fetch_assoc()) {
                $project_name .= $row["name"];  
            }
            $path = $project_name . "/doc";
            $this->createFolder($path);
            $upload_file = __DIR__ ."/../assets/projects/" . $path . "/" . $_FILES['doc']['name'];
            move_uploaded_file($_FILES['doc']['tmp_name'], $upload_file);
            $this->documentModel->createNewDocument($name, $pro_id, $path . "/" . $_FILES['doc']['name'], $_SESSION['id']);
        }
        $this->redirect('/analyzer/dashboard');
    }

    public function updateDocument() {
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            $id = $_POST['id'];
            $pro_id = $_POST['pro_id'];
            $project = $this->projectModel->getName($pro_id);
            $project_name = "";
            while ($row = $project->fetch_assoc()) {
                $project_name .= $row["name"];  
            }
            $document_name = "";
            $doccument = $this->documentModel->getDocument($id);
            while ($row = $doccument->fetch_assoc()) {
                $document_name = $row["location"];
            }
            $path = $project_name . "/doc";
            $unlink = __DIR__ ."/../assets/projects/" . $document_name;
            $upload = __DIR__ ."/../assets/projects/" . $project_name . "/doc/" . $_FILES['doc']['name'];
            if (file_exists($unlink)) {
                unlink($unlink);
            }
            move_uploaded_file($_FILES['doc']['tmp_name'], $upload);
            $this->documentModel->updateDocument($project_name . "/doc/" . $_FILES["doc"]["name"], $id);
        }
        $this->redirect('/analyzer/dashboard');
    }

    public function deleteDocument() {
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            $id = $_POST['doc'];
            $result = $this->documentModel->getDocument($id);
            while ($row = $result->fetch_assoc()) {
                $unlink = __DIR__ .'/../assets/projects/' . $row['location'];
                if (file_exists($unlink)) {
                    unlink($unlink);
                }
            }
            $this->documentModel->deleteDocument($id);
        }
        $this->redirect('/analyzer/dashboard');
    }
}