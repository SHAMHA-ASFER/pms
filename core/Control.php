<?php
require_once __DIR__ ."/../Models/User.php";
ob_start();
class Controller{
    public function __construct() {
        if (session_status() == PHP_SESSION_NONE){
            session_start();
        }
    }

    public function initNav() {
        if ($this->isLogged()) {
            if ($_SESSION["role"] == "PM") {
                include_once __DIR__ . "/../views/nav/pmnav.php";
            } else
            if ($_SESSION["role"] == "PMO") {
                include_once __DIR__ . "/../views/nav/pmonav.php";
            } else
            if ($_SESSION["role"] == "QA") {
                include_once __DIR__ . "/../views/nav/qanav.php";
            } else
            if ($_SESSION["role"] == "DEV") {
                include_once __DIR__ . "/../views/nav/devnav.php";
            } else
            if ($_SESSION["role"] == "ANA") {
                include_once __DIR__ . "/../views/nav/annav.php";
            } 
        } else {
            include_once __DIR__ . "/../views/nav/default.php";
        }
    }

    public function authMiddleware(){
        if(!(isset($_SESSION["logged"]) && $_SESSION["logged"] === true)){
            $this->redirect("");
        }
    }

    public function isLogged() {
        return isset($_SESSION["logged"]) && $_SESSION["logged"] == true;
    }

    public function redirect($path) {
        header("Location: ". $path);
        exit;
    }

    public function loginUser($id, $fname, $lname, $email, $profile, $role) {
        
        $_SESSION['logged'] = true;
        $_SESSION['id'] = $id;
        $_SESSION['role'] = $role;
        $_SESSION['email'] = $email;
        $_SESSION["fname"] = $fname;
        $_SESSION["lname"] = $lname;
        $_SESSION["profile"] = $profile;
    }
    
    public function logoutUser() {
        unset($_SESSION['logged']);
        unset($_SESSION['id']);
        unset($_SESSION['role']);
        unset($_SESSION['email']);
        unset($_SESSION["fname"]);
        unset($_SESSION["lname"]);
        unset($_SESSION["profile"]);

        $this->redirect("/login");
    }

    public function createFolder($name) {
        $location = __DIR__ ."/../assets/projects/";
        $path = $location . $name;
        if (!file_exists($path)) {
            mkdir($path, 0755);
        }
    }
}