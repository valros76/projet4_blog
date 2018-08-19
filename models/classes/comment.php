<?php
class Comment extends CommentsManager{

    protected $_id;
    protected $_post_id;
    protected $_author;
    protected $_comment;
    protected $_date_comment;
    protected $_is_signaled = 0;
    protected $_signaled;
    
    public function __construct(array $donnees){
        $this->hydrate($donnees);
    }

    public function hydrate(array $donnees){
        foreach($donnees as $key => $value){
            $method = 'set'.ucfirst($key);
            if(method_exists($this,$method)){
                $this->$method($value);
            }
        }
    }

    public function id(){
        return $this->_id;
    }

    public function postId(){
        $post_id = $_GET['post_id'];
        return $this->_post_id += $post_id;
    }

    public function author(){
        return $this->_author;
    }

    public function comment(){
        return $this->_comment;
    }

    public function dateComment(){
        return $this->date_comment;
    }

    public function is_signaled(){
        return $this->_is_signaled;
    }

    public function signaled(){
        return $this->signaled += 1;
    }

    public function setId($id){
        $id = (int) $id;
        if(is_int($id)){
            $this->_id = $id;
        }
    }

    public function setPostId($postId){
        $postId = (int) $postId;
        if(is_int($postId)){
            $this->_post_id = $postId;
        }
    }

    public function setAuthor($author){
        $author = (string) $author;
        if(is_string($author)){
            $this->_author = $author;
        }
    }

    public function setComment($comment){
        $this->_comment = $comment;
    }

    public function setDateComment($dateComment){
        $this->_date_comment = $dateComment;
    }

    public function setIs_signaled($is_signaled){
        $is_signaled = (int) $is_signaled;
        if(is_int($is_signaled)){
            $this->_is_signaled = $is_signaled;
        }
    }

    
}?>