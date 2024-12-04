<?php
require_once __DIR__ ."/../core/control.php";

class UserController extends Controller {
    private  $userModel; 

    public function __construct() {
        parent::__construct();
        $this->userModel = new UserModel(); 
    }

    public function login(){ 
        if($_SERVER["REQUEST_METHOD"] == "POST"){
            $username = $_POST["username"];
            $password = $_POST["password"];
            $result = $this->userModel->authenticateUser($username, $password);
            while($row = $result->fetch_assoc()){
                $this->loginUser($row["id"], $row["fname"], $row["lname"], $row["email"], $row["profile"], $row["role"]);
                if ($row["role"] == 'ANA'){
                    $this->redirect('/analyzer');
                }else if($row["role"] == 'PM'){
                    $this->redirect('/manager');
                }else if($row["role"] == 'PMO'){
                    $this->redirect('/pmo');
                }else if($row["role"] == 'DEV'){
                    $this->redirect('/dev');
                }else if($row["role"] == 'QA'){
                    $this->redirect('/qa');
                }
            }
        }
        include_once __DIR__ . "/../views/login.php";
    }

    public function signup(): void {
        if($_SERVER["REQUEST_METHOD"] == "POST"){
            $fname = $_POST["fname"];
            $lname = $_POST["lname"];
            $username = $_POST["username"];
            $password = $_POST["password"];
            $email = $_POST["email"];
            $contact = $_POST["contact"];
            $dob = $_POST["dob"];
            $nic = $_POST["nic"];
            $address = $_POST["address"];
            $role = $_POST["role"]; 

            $current_count = $this->userModel->count() + 1;
            $file_name = "profile-" . $current_count . ".jpg";
            $upload_path = __DIR__ . "/../assets/images/user/" . $file_name;
            move_uploaded_file($_FILES["image"]["tmp_name"], $upload_path);
            try {
                $this->userModel->createNewUser($fname,$lname,$username,$password,$email,$contact, $dob, $nic, $address, $role, $file_name);
                $this->redirect("/login?created=true");
            }catch(mysqli_sql_exception $e) {
                $this->redirect("/signup?exists=true");
            }
        }
        include_once __DIR__ . "/../views/sign.php";
    }
    
    public function logout(){
        $this->logoutUser();
    }
}