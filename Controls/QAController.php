<?php
require_once __DIR__ ."/../Models/Task.php";
require_once __DIR__ ."/../Models/File.php";
class QAController extends Controller{
    private $taskModel;
    private $fileModel;



    public function __construct(){
        parent::__construct();
        $this->initNav();

    }

    public function index(){
        echo "<h1 class='mt-5'>QA Index Page</h1>";
    }

    public function home(){
        echo "<h1 class='mt-5'>QA home Page</h1>";
    }


    public function validateFile(){
        echo "<h1 class='mt-5'>QA validation Page</h1>";

    }

    public function updateTaskState(){
        echo "<h1 class='mt-5'>QA update Page</h1>";
        
    }


}