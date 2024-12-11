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
                    echo '<script>console.log("'.$file->getFilename().'");</script>';
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

    public function renderExplorer($files, $project, $project_id, $nest) {
        // $nest++;
        foreach ($files as $file) {
            echo $file['name'] . "<br>";
        }
    }

    public function isAssociativeArray($array) {
        return (is_array($array) && array_keys($array) !== range(0, count($array) - 1));
    }
}
