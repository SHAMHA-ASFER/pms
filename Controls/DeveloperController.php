 <?php
require_once __DIR__ . "/../Models/User.php";
require_once __DIR__ . "/../Models/Task.php";
require_once __DIR__ . "/../Models/File.php";
require_once __DIR__ . "/../Models/TaskDeveloper.php";
require_once __DIR__ . "/../Models/ProjectDeveloper.php";
require_once __DIR__ . "/../Models/Project.php";

class DeveloperController extends Controller
{
    private $projectModel;
    private $projectDeveloperModel;
    private $taskModel;
    private $taskDeveloperModel;
    private $userModel;
    private $fileModel;

    public function __construct()
    {
        parent::__construct();
        $this->initNav();
        $this->projectModel = new ProjectModel();
        $this->taskModel = new TaskModel();
        $this->userModel = new UserModel();
        $this->fileModel = new FileModel();
        $this->projectDeveloperModel = new ProjectDeveloperModel();
        $this->taskDeveloperModel = new TaskDeveloperModel();
    }

    public function index()
    {
        include_once __DIR__ . "/../views/dev/developer.php";
    }

    public function uploadFiles() {
        echo "<div class='mt-5'></div>";
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            $pro_id = $_POST['pro_id'];
            $task_id = $_POST['task_id'];
            $project_name = "";
            $projects = $this->projectModel->getName($pro_id);
            while ($project = $projects->fetch_assoc() ) {
                $project_name = $project["name"];
            }
            $src_path = __DIR__ . "/../assets/projects/" . $project_name . "/src";
            if (!file_exists( $src_path )) {
                $this->createFolder($project_name . "/src");
            }
            $uploadedFiles = $_FILES['source'];
            $folders = [];
            for ($i = 0; $i < count($uploadedFiles['name']); $i++) {
                $upload_file = $src_path . "/" . $uploadedFiles["full_path"][$i];
                $destination = dirname($upload_file);
                if (!is_dir($destination)) {
                    $this->addUniqueElement($folders, $destination);
                    mkdir($destination, 0777, true);
                }
                $this->fileModel->createNewFile($task_id, $uploadedFiles["full_path"][$i], 'file');
                move_uploaded_file($uploadedFiles["tmp_name"][$i], $upload_file);
            }
            $nodummies = [];
            for ($i = 0; $i < count($folders); $i++) {
                $this->addUniqueElement($nodummies, explode("/", substr($folders[$i],  mb_strlen($src_path, "UTF-8") + 1, mb_strlen($folders[$i])))[0]);
            }
            for ($i = 0; $i < count($nodummies); $i++) {
                $this->fileModel->createNewFile($task_id, $nodummies[$i],"folder");
            }
        }
        $this->redirect('/dev/dashboard?page=task&id=' . $pro_id);
    }

    public function addUniqueElement(&$array, $element) {
        if (!in_array($element, $array)) {
            $array[] = $element;
        }
    }

    public function deleteFolder($folderPath) {
        // Check if the folder exists
        if (!is_dir($folderPath)) {
            echo "The specified path is not a valid directory.";
            return false;
        }

        // Scan the folder and get all files and subfolders
        $files = array_diff(scandir($folderPath), array('.', '..')); // Ignore '.' and '..'

        // Iterate through each file and delete them
        foreach ($files as $file) {
            $filePath = $folderPath . DIRECTORY_SEPARATOR . $file;

            // If it's a directory, call the function recursively
            if (is_dir($filePath)) {
                $this->deleteFolder($filePath); // Recursively delete subfolders
            } else {
                // If it's a file, delete it
                unlink($filePath);
            }
        }

        // After all contents are deleted, remove the folder itself
        rmdir($folderPath);

        echo "Folder and its contents have been deleted.";
        return true;
    }

    public function removeFiles() {
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            echo '<div class="mt-5"></div>';
            $pro_id = $_POST['pro_id'];
            $task_id = $_POST['task_id'];
            $project_name = "";
            $projects = $this->projectModel->getName($pro_id);
            while ($project = $projects->fetch_assoc()) {
                $project_name = $project["name"];
            }
            $files = $this->fileModel->getAllByFiles($task_id);
            while ($file = $files->fetch_assoc()) {
                $file = __DIR__ . "/../assets/projects/" . $project_name . "/src/" . $file['location'];
                if (!strpos($file, "/doc/")) {
                    if (file_exists($file)) {
                        unlink($file);
                    }
                }
            }
            $this->fileModel->deleteFile($task_id, 'file');
            $folders = $this->fileModel->getAllByFolder($task_id);
            while ($folder = $folders->fetch_assoc()) {
                $location = __DIR__ . "/../assets/projects/" . $project_name . "/src/" . $folder["location"];
                if (!file_exists($location)) {
                    mkdir($location,0777, true);
                }
                $this->deleteFolder($location);
            }
            $this->fileModel->deleteFile($task_id, "folder");
        } 
        $tasks = $this->taskModel->getAllTask($task_id);
        while ($task = $tasks->fetch_assoc()) {
            $this->taskModel->updateTaskStatus($task["id"], "pending");
        }
        $this->redirect('/dev/dashboard?page=task&id=' . $pro_id);  
    }
}
