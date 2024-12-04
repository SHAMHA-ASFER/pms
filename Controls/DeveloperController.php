<?php
require_once __DIR__ ."/../Models/Task.php";
require_once __DIR__ ."/../Models/File.php";


class DeveloperController extends Controller {
    private $taskModel;
    private $fileModel;

    public function __construct() {
        parent::__construct();
        $this->initNav();
    }

    public function index() {
        echo "<h1 class='mt-5'>DEV Index Page</h1>";
    }

    public function home(){
        echo "<h1 class='mt-5'>DEV home Page</h1>";
    }

    public function viewTask() {
        echo "<h1 class='mt-5'>DEV view Page</h1>";
    }

    public function createFile() {
        echo "<h1 class='mt-5'>DEV create Page</h1>";       

    }

    public function updateFile() {
        echo "<h1 class='mt-5'>DEV update Page</h1>";
    }
}