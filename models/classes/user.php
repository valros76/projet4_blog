<?php
class User extends UsersManager{

    protected $_id;
    protected $_pseudo;
    protected $_password;
    protected $_email;
    protected $_inscription_date;
    protected $_id_group;

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

    public function pseudo(){
        return $this->_pseudo;
    }

    public function password(){
        return $this->_password;
    }

    public function email(){
        return $this->_email;
    }

    public function inscription_date(){
        return $this->_inscription_date;
    }

    public function id_group(){
        return $this->_id_group;
    }

    public function setId($id){
        $id = (int) $id;
        if(is_int($id)){
            $this->_id = $id;
        }
    }

    public function setPseudo($pseudo){
        if(is_string($pseudo)){
            $this->_pseudo = $pseudo;
        }
    }

    public function setPassword($password){
        $this->_password = $password;
    }

    public function setEmail($email){
        $this->_email = $email;
    }

    public function setInscription_date($inscription_date){
        $this->_inscription_date = $inscription_date;
    }

    public function setId_group($id_group){
        $id_group = (int) $id_group;
        if(is_int($id_group)){
            $this->_id_group = $id_group;
        }
    }

    public function nomValide(){
        return !empty($this->_pseudo);
    }

    public function emailValide(){
        return !empty($this->_email);
    }

}?>