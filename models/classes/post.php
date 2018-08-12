<?php
class Post{

    protected $_id;
    protected $_title;
    protected $_content;
    protected $_date;

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

    public function title(){
        return $this->_title;
    }

    public function content(){
        return $this->_content;
    }

    public function date(){
        return $this->_date;
    }

    public function setId($id){
        $id = (int) $id;
        if(is_int($id)){
            $this->_id = $id;
        }
    }

    public function setTitle($title){
        $this->_title = $title;
    }

    public function setContent($content){
        $this->_content = $content;
    }

    public function setDate($date){
        $this->_date = $date;
    }



}?>