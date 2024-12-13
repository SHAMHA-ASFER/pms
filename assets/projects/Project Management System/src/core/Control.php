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
        echo '<div class="w-100">';
        foreach ($files as $file) {
            $icon = "";
            if (isset($file['extension']) && $file['extension'] == 'docx') {
                $icon = '<i class="fa fa-book text-success"></i>&nbsp;';
            } else if (isset($file['extension']) && $file['extension'] == 'php') {
                $icon = '<i class="fa fa-code text-danger"></i>&nbsp;';
            } else if (isset($file['extension']) && ($file['extension'] == 'png' || $file['extension'] == 'jpg')) {
                $icon = '<i class="fa fa-image text-primary"></i>&nbsp;';
            } else if ($file['type'] == 'directory') {
                $icon = '<i class="fa fa-folder text-warning"></i>&nbsp;';
            } 
            if ($file['type'] == 'directory') {
                echo '<h6 class="p-1 no-select text-nowrap" id="projectToggle-'.$i.'" style="margin-left:'.($myNest * 10).'px;margin-top:-5px;">
                    <i class="fa fa-angle-right" id="toggle-icon-'.$i.'"></i>
                    &nbsp;&nbsp;' . $icon . $file['name'] .'
                </h6>
                <div class="collapse" id="collapsible-'.$i.'">';
                $this->renderExplorer($file['children'], $project, $i, ($nest + 1));
            } else {
                echo '<p class="fw-medium d-inline-block text-truncate" style="max-width:300px;font-size:14px;margin-top:-10px;margin-left:'. $myNest * 15 .'px;">'.$icon . $file['name'].'</p><br>';
            }
        
            $i++;
        }
        echo '</div>
            </div>';
    }

    public function isAssociativeArray($array) {
        return (is_array($array) && array_keys($array) !== range(0, count($array) - 1));
    }
}