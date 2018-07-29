<?php
class GetComments{

    protected $_id;
    protected $_post_id;
    protected $_author;
    protected $_comment;
    protected $_date_comment;
    
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
        return $this->_post_id;
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


}?>