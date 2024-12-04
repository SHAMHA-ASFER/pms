<?php
require_once __DIR__ ."/../core/Model.php";

class FeedbackModel extends Model {
    private $create_feedback_table = "
        id INT AUTO_INCREMENT PRIMARY KEY,
        subject VARCHAR(100) NOT NULL,
        body TEXT,
        given_by INT REFERENCES user(id)
    ";

    private $new = "INSERT INTO `feedback` (subject,body) VALUES (?,?)";
    private $get_feedback ="SELECT subject , body FROM `feedback` WHERE id = ?";
    private $get_all_feedback = "SELECT * FROM `feedback`";

    public function __construct() {
        parent::__construct();
        $this->createFeedback();
    }

    public function createFeedback(){
        $this->create($this->create_feedback_table);
    }

    public function createNewFeedback($subject,$body){
        $this->create($this->new,[$subject , $body],"ss");
    }

    public function getAllFeedback() {
        return $this->fetch($this->get_all_feedback);
    }

    public function getFeedback($id){
        $this->fetch($this->get_feedback,[$id],"i");
    }



}
?>