<?php

use function PHPSTORM_META\type;

require_once __DIR__ . "/../Models/Task.php";
require_once __DIR__ . "/../Models/Project.php";

class DeveloperController extends Controller
{
    private $projectModel;
    private $taskModel;
    private $fileModel;

    public function __construct()
    {
        parent::__construct();
        $this->initNav();
        $this->projectModel = new ProjectModel();
        $this->taskModel = new TaskModel();
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
                'name' => basename($path), // Directory name
                'type' => 'directory', // Type is directory
                'path' => realpath($path), // Full path to the directory
                'children' => [] // Initialize the children array
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
                        'name' => $file->getFilename(), // File name
                        'type' => 'file', // Type is file
                        'extension' => $file->getExtension(), // File extension
                        'path' => $file->getRealPath(), // Full path to the file
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
        echo '<div class="w-25">';
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
                echo '<h7 class="p-1 no-select text-nowrap" id="projectToggle-'.$i.'" style="margin-left:'.($myNest * 10).'px;margin-top:-5px;">
                    <i class="fa fa-angle-right" id="toggle-icon-'.$i.'"></i>
                    &nbsp;&nbsp;' . $icon . $file['name'] .'
                </h7>
                <div class="collapse" id="collapsible-'.$i.'">';
                $this->renderExplorer($file['children'], $project, $i, ($nest + 1));
            } else {
                echo '<p class="fw-light d-inline-block text-truncate" style="max-width:300px;font-size:14px;margin-left:'. $myNest * 15 .'px;">'.$icon . $file['name'].'</p>';
            }
            $i++;
        }
        echo '  </div>
            </div>';
    }

    public function isAssociativeArray($array) {
        return (is_array($array) && array_keys($array) !== range(0, count($array) - 1));
    }
}
