<?php
class UsersManager{

    private $_bdd;

    public function __construct($bdd){
        $this->setBdd($bdd);
    }

    public function add(User $user){
        $req = $this->_bdd->prepare('INSERT INTO users(pseudo,password,email,inscription_date,id_group) VALUES(:pseudo,:password,:email,CURDATE(), :id_group)');
    
        $req->bindValue(':pseudo', $user->pseudo());
        $req->bindValue(':password', $user->password());
        $req->bindValue(':email', $user->email());
        $req->bindValue(':id_group', $user->id_group(), PDO::PARAM_INT);

        $req->execute();

        $user->hydrate([
            'id' => $this->_bdd->lastInsertId(),
        ]);
    }

    public function count(){
        return $this->_bdd->query('SELECT COUNT(*) FROM users')->fetchColumn();
    }

    public function delete(User $user){
        $this->_bdd->exec('DELETE FROM users WHERE id = '.$user->id());
    }

    public function exists($info)
    {
        if (is_int($info)){
        return (bool) $this->_bdd->query('SELECT COUNT(*) FROM users WHERE id = '.$info)->fetchColumn();
        }
        
        // Sinon, c'est qu'on veut vérifier que le nom existe ou pas.
        
        $req = $this->_bdd->prepare('SELECT COUNT(*) FROM users WHERE pseudo = :pseudo');
        $req->execute([':pseudo' => $info]);
        
        return (bool) $req->fetchColumn();
    }

    public function exists_email($info){
        if(is_int($info)){
            return (bool) $this->_bdd->query('SELECT COUNT(*) FROM users WHERE id ='.$info)->fetchColumn();
        }
        
        $req = $this->_bdd->prepare('SELECT COUNT(*) FROM users WHERE email = :email');
        $req->execute([':email' => $info]);

        return (bool) $req->fetchColumn();
    }

    public function get($info){
        if (is_int($info)){
            $req = $this->_bdd->query('SELECT id,pseudo,password,email,inscription_date FROM users WHERE id = '.$info);
            $donnees = $req->fetch(PDO::FETCH_ASSOC);
            
            return new User($donnees);
        }
        else{
            $req = $this->_bdd->prepare('SELECT id,pseudo,password,email,inscription_date FROM users WHERE pseudo = :pseudo');
            $req->execute([':pseudo' => $info]);
            
            return new User($req->fetch(PDO::FETCH_ASSOC));
        }
    }

    public function getList($pseudo){
        $users = [];
    
        $req = $this->_bdd->prepare('SELECT id,pseudo,email FROM users WHERE pseudo <> :pseudo ORDER BY pseudo');
        $req->execute([':pseudo' => $pseudo]);
        
        while ($donnees = $req->fetch(PDO::FETCH_ASSOC))        {
        $users[] = new User($donnees);
        }
        
        return $users;
    }

    public function update(User $user){
        $req = $this->_bdd->prepare('UPDATE users SET pseudo = : pseudo, password = :password, email = :email WHERE id = :id');
    
        $req->bindValue(':pseudo', $user->pseudo(), PDO::PARAM_INT);
        $req->bindValue(':password', $user->password(), PDO::PARAM_INT);
        $req->bindValue(':email', $user->email(), PDO::PARAM_INT);
        
        $req->execute();
    }

    public function setBdd($bdd){
        $this->_bdd = $bdd;
    }

}?>