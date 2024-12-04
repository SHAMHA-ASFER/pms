<?php

require_once __DIR__ ."/../core/Model.php";

class ContentModel extends Model {

    private $create_content_table = "
    CREATE TABLE IF NOT EXISTS `content` ( 
        id INT AUTO_INCREMENT PRIMARY KEY,
        content_text TEXT,
        content_type ENUM(
        'main_heading',  -- Represents a primary heading/title
        'subheading',    -- Represents a secondary heading
        'bullets',       -- Represents bullet points
        'numbered_list', -- Represents numbered lists
        'paragraph',     -- Represents a paragraph of text
        'quote',         -- Represents a blockquote or citation
        'table',         -- Represents tabular content
        'code_block',    -- Represents a code snippet
        'image',         -- Represents an image
        'video',         -- Represents a video
        'link',          -- Represents a hyperlink
        'divider',       -- Represents a horizontal line or divider
        'note',          -- Represents a highlighted note or comment
        'caption'        -- Represents a caption (e.g., for images or videos)
    ),
        doc_id INT REFERENCES document(doc_id)
    );
";

    private $new = "INSERT INTO `content` (content_text, content_type, doc_id) VALUES (?, ?, ?)";
    private $update_content = "UPDATE `content` SET content_text = ? WHERE id = ?";
    private $delete_content = "DELETE FROM `content` WHERE id = ?";
    private $get_content = "SELECT content_text FROM `content` WHERE id = ?";
    private $get_all_content = "SELECT * FROM `content`";

    public function __construct() {
        parent::__construct();
        $this->createContent();
    }

    public function createContent(){
        $this->create( $this->create_content_table);
    }

    public function createNewContent($content_text, $content_type){
        $this->insert($this->new,[$content_text,$content_type],"ss");
    }

    public function updateContent($id){
        $this->update( $this->update_content,[ $id ],"i");
    }

    public function deleteContent($id){
        $this->delete($this->delete_content,[$id],"i");  
    }

    public function getContent($id){
        return $this->fetch($this->get_content,[$id],"s");
    }

    public function getAllContent(){
        return $this->fetch($this->get_all_content);
    }


}
?>