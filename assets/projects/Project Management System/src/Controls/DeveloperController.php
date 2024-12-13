 <?php
require_once __DIR__ . "/../Models/User.php";
require_once __DIR__ . "/../Models/Task.php";
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

    public function __construct()
    {
        parent::__construct();
        $this->initNav();
        $this->projectModel = new ProjectModel();
        $this->taskModel = new TaskModel();
        $this->userModel = new UserModel();
        $this->projectDeveloperModel = new ProjectDeveloperModel();
        $this->taskDeveloperModel = new TaskDeveloperModel();
    }

    public function index()
    {
        include_once __DIR__ . "/../views/dev/developer.php";
    }

    public function traverseDirectory($path)
    {
        $directory = [];
        if (is_dir($path)) {
            $directory = [
                'name' => basename($path), 
                'type' => 'directory', 
                'path' => realpath($path), 
                'children' => [] 
            ];
            $dir = new DirectoryIterator($path);
            $i = 0;
            foreach ($dir as $file) {
                if ($file->isDot()) {
                    continue;
                }

                if ($file->isDir()) {
                    $directory['children'][] = $this->traverseDirectory($file->getRealPath());
                } else {
                    $directory['children'][] = [
                        'name' => $file->getFilename(), 
                        'type' => 'file', 
                        'extension' => $file->getExtension(), 
                        'path' => $file->getRealPath()
                    ];
                }
                $i++;
            }
        }
        return $directory;
    }

    public function renderExplorer(&$files, $project, &$project_id, $nest) {
        $myNest = $nest;
        $i = $project_id * 1000;
        foreach ($files as $file) {
            $icon = "";
            if (isset($file['extension']) && $file['extension'] == 'docx') {
                $icon = '<i class="fa fa-book"></i>&nbsp;';
            } else if (isset($file['extension']) && $file['extension'] == 'php') {
                $icon = '<i class="fa fa-code"></i>&nbsp;';
            } else if ($file['type'] == 'directory') {
                $icon = '<i class="fa fa-folder"></i>&nbsp;';
            } 
            if ($file['type'] == 'directory') {
                echo '<h6 class="p-1 no-select text-nowrap" id="projectToggle-'.$i.'" style="margin-left:'.($myNest * 10).'px;margin-top:-5px;">
                    <i class="fa fa-angle-right" id="toggle-icon-'.$i.'"></i>
                    &nbsp;&nbsp;' . $icon . $file['name'] .'
                </h6>
                <div class="collapse" id="collapsible-'.$i.'">';
                $this->renderExplorer($file['children'], $project, $i, ($nest + 1));
            } else {
                echo '<p class="fw-medium d-inline-block text-truncate w-25" style="max-width:300px;font-size:14px;margin-left:'. $myNest * 15 .'px;">'.$icon . $file['name'].'</p>';
            }
        
            $i++;
        }
        echo '
            </div>';
    }

    public function isAssociativeArray($array) {
        return (is_array($array) && array_keys($array) !== range(0, count($array) - 1));
    }

    public function uploadFiles() {
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
            var_dump($_FILES["source"]);
            $uploadedFiles = $_FILES['source'];
            for ($i = 0; $i < count($uploadedFiles['name']); $i++) {
                $upload_file = $src_path . "/" . $uploadedFiles["full_path"][$i];
                $destination = dirname($upload_file);
                if (!is_dir($destination)) {
                    mkdir($destination, 0777, true);
                }
                move_uploaded_file($uploadedFiles["tmp_name"][$i], $upload_file);
            }
        }
        $this->redirect('/dev/dashboard?page=task&id=' . $pro_id);
    }
}
