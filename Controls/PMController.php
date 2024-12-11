<?php
require_once __DIR__ ."/../Models/Project.php";
require_once __DIR__ ."/../Models/Task.php";
require_once __DIR__ ."/../Models/User.php";
require_once __DIR__ ."/../Models/Document.php";
require_once __DIR__ ."/../Models/ProjectAnalyzer.php";
require_once __DIR__ ."/../Models/ProjectDeveloper.php";
require_once __DIR__ ."/../Models/ProjectQA.php";
require_once __DIR__ ."/../Models/TaskDeveloper.php";
require_once __DIR__ ."/../Models/TaskQA.php";

class PMController extends Controller{
    private $projectModel;
    private $userModel;
    private $projectAnalyzerModel;
    private $projectDeveloperModel;
    private $projectQAModel;
    private $taskModel;
    private $taskDeveloperModel;
    private $taskQAModel;
    private $documentModel;

    public function __construct(){
        parent::__construct();
        $this->initNav();
        $this->projectModel = new ProjectModel();
        $this->projectAnalyzerModel = new ProjectAnalyzerModel();
        $this->projectDeveloperModel = new ProjectDeveloperModel();
        $this->projectQAModel = new ProjectQAModel();
        $this->userModel = new UserModel();
        $this->taskModel = new TaskModel();
        $this->taskDeveloperModel = new TaskDeveloperModel();
        $this->taskQAModel = new TaskQAModel();
        $this->documentModel = new DocumentModel();
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

    public function manageTask() {
        include_once __DIR__ ."/../views/pm/manage_task.php";
    }

    public function manageDocument() {
        include_once __DIR__ ."/../views/pm/manage_document.php";
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

    public function createTask() {
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            $pro_id = $_POST['pro_id'];
            $task = $_POST['task'];
            $description = $_POST['description'];
            $day = $_POST['day'];
            $month = $_POST['month'];
            $year = $_POST['year'];
            $this->taskModel->createNewTask($task, $description, $day."-".$month."-".$year, $_SESSION['id'], $pro_id);
        }
        $this->redirect('/manager/handle/task?page=task&id=' . $pro_id);
    }

    public function assignMember() {
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            $pro_id = $_POST['pro_id'];
            $task_id = $_POST['task_id'];
            $role = $_POST['role'];
            $mem_id = $_POST['mem_id'];
            try {
                if ($role == 'DEV') {
                    $this->taskDeveloperModel->createNewTaskDeveloper($mem_id, $task_id);
                } else {
                    $this->taskQAModel->createNewTaskQA($mem_id, $task_id);
                } 
            } catch (mysqli_sql_exception $e) { 
            }
            $this->redirect('/manager/handle/task?page=task&id=' . $pro_id);   
        }
    }

    public function removeMember() {
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            $id = $_POST['id'];
            $dev = $_POST['dev'];
            $qa = $_POST['qa'];
            $task = $_POST['task'];
            $mem_type = $_POST['mem_type'];
            if ($mem_type == 'DEV') {
                $this->taskDeveloperModel->removeDeveloper($dev);
            } else if ($mem_type == 'QA') {
                $this->taskQAModel->removeQA($qa);
            } else if ($mem_type == 'BOTH') {
                $this->taskDeveloperModel->removeDeveloper($dev);
                $this->taskQAModel->removeQA($qa);
            } else if ($mem_type == 'TASK') {
                $this->taskDeveloperModel->removeDeveloper($dev);
                $this->taskQAModel->removeQA($qa);
                $this->taskModel->deleteTask($task);
            }
        }
        $this->redirect('/manager/handle/task?page=task&id=' . $id);
    }

    public function updateStatus() {
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            $id = $_POST['id'];
            $doc = $_POST['doc'];
            $status = $_POST['status'];
            $this->documentModel->setStatus($doc, $status);  
        }
        $this->redirect('/manager/handle/doc?page=task&id=' . $id);      
    }

    public function changeStatus() {
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            $pro_id = $_POST['pro_id'];
            $status = $_POST['status'];
            $this->projectModel->updateStatus($pro_id, $status);
        }
        $this->redirect('/manager/dashboard');
    }

    public function Project() {
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            $pro_id = $_POST['pro_id'];
            $this->projectModel->deleteProject($pro_id);
        }
        $this->redirect('/manager/dashboard');
    }
}   