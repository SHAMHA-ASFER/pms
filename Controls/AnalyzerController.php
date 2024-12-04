<?php

require_once __DIR__ ."/../Models/Document.php";
require_once __DIR__ ."/../Models/Content.php";

class AnalyzerController extends Controller{
    private $documentModel;
    private $contentModel;

    public function __construct(){
        parent::__construct();
        $this->initNav();
    }

    public function index(){
        echo "<h1 class='mt-5'>ANA Index Page</h1>";
    }

    public function home(){
        echo "<h1 class='mt-5'>ANA home Page</h1>"; 
    }

    public function createDocument(){
        echo "<h1 class='mt-5'>ANA create doc Page</h1>";
    }

    public function updateContent(){
        echo "<h1 class='mt-5'>ANA  Pageupdate cont</h1>";        
    }
}