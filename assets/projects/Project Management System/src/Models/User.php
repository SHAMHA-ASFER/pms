<?php 
require_once __DIR__ . "/../core/Model.php";

class UserModel extends Model {
    private $create_user_table = "
        CREATE TABLE IF NOT EXISTS `user` (
            id INT PRIMARY KEY AUTO_INCREMENT,
            fname VARCHAR(100) NOT NULL,
            lname VARCHAR(100),
            username VARCHAR(100) UNIQUE,
            password VARCHAR(100) NOT NULL,
            email VARCHAR(100) UNIQUE,
            contact VARCHAR(20) UNIQUE,
            dob DATE NOT NULL,
            nic VARCHAR(20) UNIQUE,
            address VARCHAR(256),
            role ENUM('PM', 'PMO', 'QA', 'DEV', 'ANA'),
            profile VARCHAR(256) NOT NULL,
            joined DATE DEFAULT (CURRENT_TIMESTAMP),
            manager INT REFERENCES `user` (id) ON DELETE CASCADE
        );
    ";
    private $new = "INSERT INTO `user` (fname, lname, username, password, email, contact, dob, nic, address, role, profile) VALUES 
                    (?,?,?,?,?,?,?,?,?,?,?);";
    private $update_password = "UPDATE `user` SET password = ? WHERE id = ?";
    private $update_address = "UPDATE `user` SET address = ? WHERE id = ?";
    private $delete = "DELETE FROM `user` WHERE id = ?";
    private $get_all = "SELECT * FROM `user`";
    private $authenticate = "SELECT id, fname, lname, email, profile, role FROM `user` WHERE username = ? AND password = ?";
    private $user_count = "SELECT COUNT(*) as count FROM `user`";
    private $get_users_by_manager = "SELECT * FROM `user` WHERE manager = ? AND role = ?";
    private $get_name = "SELECT fname, lname FROM `user` WHERE id = ?";

    public function __construct() {
        parent::__construct();
        $this->createUser();
    }

    public function createUser() {
        $this->create($this->create_user_table);
    }

    public function createNewUser($fname, $lname, $username, $password, $email, $contact, $dob, $nic, $address, $role, $profile) {
        $this->insert($this->new, [$fname, $lname, $username, $password, $email, $contact, $dob, $nic, $address, $role, $profile], "sssssssssss");
    }

    public function updatePassword($id, $password) {
        $this->update($this->update_password, [$password, $id], "si");
    }

    public function updateAddress($id, $address) {
        $this->update($this->update_address, [$address,$id], "si");
    }

    public function deleteUser($id) {
        $this->delete($this->delete,[$id],"i");
    }

    public function getAllUsers() {
        return $this->fetch($this->get_all);
    }

    public function authenticateUser($username, $password) {
        return $this->fetch($this->authenticate, [$username, $password],"ss");
    }

    public function count() {
        $result = $this->fetch($this->user_count);
        while ($row = $result->fetch_assoc()) {
            return $row["count"];
        }
    }

    public function getUserByManager($mgr_id, $role) {
        return $this->fetch($this->get_users_by_manager, [$mgr_id, $role],"is");
    }

    public function getName($id) {
        return $this->fetch($this->get_name, [$id],"i");
    }
}