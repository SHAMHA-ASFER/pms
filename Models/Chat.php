<?php 
require_once __DIR__ . "/../core/Model.php";

class ChatModel extends Model {
    private $create_chat_table = "
        CREATE TABLE IF NOT EXISTS `chat` (
            id INT PRIMARY KEY AUTO_INCREMENT,
            pro_id INT REFERENCES project (id) ON DELETE CASCADE,
            send INT REFERENCES user (id) ON DELETE CASCADE,
            recv INT REFERENCES user (id) ON DELETE CASCADE,
            message VARCHAR(256) NOT NULL,
            send_time TIMESTAMP DEFAULT (CURRENT_TIMESTAMP)
        );
    ";
    private $insert_chat = "INSERT INTO `chat` (pro_id, send, recv, message) VALUES (?,?,?,?);";
    private $get_all_message = "SELECT * FROM `chat` WHERE ((send = ? AND recv = ?) OR (send = ? AND recv = ?)) AND pro_id = ? ORDER BY send_time ASC";

    public function __construct() {
        parent::__construct();
        $this->createChat();
    }

    public function createChat() {
        $this->create($this->create_chat_table);
    }

    public function createNewChat($pro_id, $send, $recv, $message) {
        $this->insert($this->insert_chat, [$pro_id, $send, $recv, $message], "iiis");
    }

    public function getAllMessages($pro_id, $send, $recv) {
        return $this->fetch($this->get_all_message, [$send, $recv, $recv, $send, $pro_id], "iiiii");
    }
}