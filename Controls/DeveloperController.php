<?php
require_once __DIR__ ."/../Models/Task.php";


class DeveloperController extends Controller {
    private $taskModel;
    private $fileModel;

    public function __construct() {
        parent::__construct();
        $this->initNav();
    }

    public function index() {
        include_once __DIR__ ."/../views/developer.php";
    }
}