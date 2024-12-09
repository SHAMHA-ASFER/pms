<?php
require_once __DIR__ ."/../Models/Project.php";
require_once __DIR__ ."/../Models/Task.php";
require_once __DIR__ ."/../Models/User.php";
require_once __DIR__ ."/../Models/ProjectAnalyzer.php";
require_once __DIR__ ."/../Models/ProjectDeveloper.php";
require_once __DIR__ ."/../Models/ProjectQA.php";

class PMController extends Controller{
    private $projectModel;
    private $userModel;
    private $projectAnalyzerModel;
    private $projectDeveloperModel;
    private $projectQAModel;
    private $taskModel;

    public function __construct(){
        parent::__construct();
        $this->initNav();
        $this->projectModel = new ProjectModel();
        $this->projectAnalyzerModel = new ProjectAnalyzerModel();
        $this->projectDeveloperModel = new ProjectDeveloperModel();
        $this->projectQAModel = new ProjectQAModel();
        $this->userModel = new UserModel();
        $this->taskModel = new TaskModel();
    }

    public function index(){
        include_once __DIR__ ."/../views/pm/index.php";
    }

    public function manageAnalyzer() {
        $result = $this->projectModel->getAllProjects();
        include_once __DIR__ ."/../views/pm/manage_analyzer.php";
    }

    public function manageDeveloper() {
        include_once __DIR__ ."/../views/pm/manage_developer.php";
    }

    public function manageQA() {
        include_once __DIR__ ."/../views/pm/manage_qa.php";
    }

    public function createProject() {
        if ($_SERVER['REQUEST_METHOD'] == "POST") {
            $project = $_POST['project'];
            $description = $_POST['description'];
            $day = $_POST['day'];
            $month = $_POST['month'];
            $year = $_POST['year'];
            $this->createFolder($project);
            $this->projectModel->createNewProject($project, $description, $_SESSION['id'], $year . "-" . $month . "-" . $day);
        }
        $this->redirect("/manager/dashboard");
    }
    
    public function addAnalyzer() {
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            $pro_id = $_POST['pro_id'];
            $user_id = $_POST['analyzer'];
            try {
                $this->projectAnalyzerModel->createNewProjectAnalyzer($pro_id, $user_id);
            } catch (mysqli_sql_exception $e) {
                
            }
        }
        $this->redirect('/manager/handle/analyzer');
    }

    public function removeAnalyzer(){
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            $pro_id = $_POST['pro_id'];
            $user_id = $_POST['user_id'];
            $this->projectAnalyzerModel->removeAnalyzer($pro_id,$user_id);
        }
        $this->redirect('/manager/handle/analyzer');
    }

    public function addDeveloper(){
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            $pro_id = $_POST['pro_id'];
            $user_id = $_POST['user_id'];
            try{
                $this->projectDeveloperModel->createNewProjectDeveloper($pro_id,$user_id);
            }catch (mysqli_sql_exception $e) {
            }
            $this->redirect('/manager/handle/developer');
        }
    }

    public function removeDeveloper(){
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            $pro_id = $_POST['pro_id'];
            $user_id = $_POST['user_id'];
            $this->projectDeveloperModel->removeDeveloper($pro_id,$user_id);
        }
        $this->redirect('/manager/handle/developer');

    }

    public function addQA(){
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            $pro_id = $_POST['pro_id'];
            $user_id = $_POST['user_id'];
            try{
                $this->projectQAModel->createNewProjectQA($pro_id,$user_id);
            }catch(mysqli_sql_exception $e) {
            }
        $this->redirect('/manager/handle/qa');
    }
    
    
}
    public function removeQA(){
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            $pro_id = $_POST['pro_id'];
            $user_id = $_POST['user_id'];
            $this->projectQAModel->removeQAs($pro_id,$user_id);
        }
        $this->redirect('/manager/handle/qa');
    }
}