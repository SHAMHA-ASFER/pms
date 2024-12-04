<?php
require_once __DIR__ ."/../Models/Project.php";
require_once __DIR__ ."/../Models/Task.php";
require_once __DIR__ ."/../Models/User.php";
class PMController extends Controller{
    private $projectModel;
    private $userModel;
    private $taskModel;

    public function __construct(){
        parent::__construct();
        $this->userModel = new UserModel();
        $this->initNav();
    }

    public function index(){
        echo "<h1 class='mt-5'>PM Index Page</h1>";
    }

    public function home(){

    }


    // TODO: Fill out manageProject
    public function manageProject(){
        echo "<h1 class='mt-5'>PM manage pro Page</h1>";
    }

    // TODO: Fill out manageTask
    public function manageTask(){
        echo "<h1 class='mt-5'>PM manage task Page</h1>";
    }
    // TODO: Fill out manageMembers
    public function manageMembers(){
        echo "<h1 class='mt-5'>PM MANAGE MEM Page</h1>";
    }
}