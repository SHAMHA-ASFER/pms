<?php
require_once __DIR__ ."/../core/Control.php";
require_once __DIR__ ."/../Models/User.php";

class PMOController extends Controller{
    private $userModel;

    public function __construct(){
        parent::__construct();  
        $this->userModel = new UserModel();
        $this->initNav();
    }

    public function index(){
        echo "<h1 class='mt-5'>PMO Index Page</h1>";
    }
    // TODO: Fill out manageUsers

    public function manageUsers(){

    }

    public function viewFeedback(){
        
    }

}