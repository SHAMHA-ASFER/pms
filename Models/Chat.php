<?php 
require_once __DIR__ . "/../core/Model.php";

class ChatModel extends Model {
    private $create_chat_table = "
        CREATE TABLE IF NOT EXISTS `chat` (
            id INT PRIMARY KEY AUTO_INCREMENT,
            sender INT REFERENCES user (id) ON DELETE CASCADE,
            reciever INT REFERENCES user (id) ON DELETE CASCADE,
            category ENUM ('public','private') DEFAULT 'private',
            message VARCHAR(256) NOT NULL
        );
    ";

    public function __construct() {
        parent::__construct();
        $this->createChat();
    }

    public function createChat() {
        $this->create($this->create_chat_table);
    }
}