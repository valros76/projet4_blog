<?php
class GroupsManager{

    private $_bdd;

    public function __construct($bdd){
        $this->setBdd($bdd);
    }

    public function add(Group $group){
        $req = $this->_bdd->prepare('INSERT INTO groups(name) VALUES(:name)');
    
        $req->bindValue(':name', $group->name());

        $req->execute();

        $group->hydrate([
            'id' => $this->_bdd->lastInsertId(),
        ]);
    }

    public function count(){
        return $this->_bdd->query('SELECT COUNT(*) FROM groups')->fetchColumn();
    }

    public function delete(Group $group){
        $this->_bdd->exec('DELETE FROM groups WHERE id = '.$group->id());
    }

    public function exists($info)
    {
        if (is_int($info)){
        return (bool) $this->_bdd->query('SELECT COUNT(*) FROM groups WHERE id = '.$info)->fetchColumn();
        }
        
        // Sinon, c'est qu'on veut vérifier que le nom existe ou pas.
        
        $req = $this->_bdd->prepare('SELECT COUNT(*) FROM groups WHERE name = :name');
        $req->execute([':name' => $info]);
        
        return (bool) $req->fetchColumn();
    }


    public function get($info){
        if (is_int($info)){
            $req = $this->_bdd->query('SELECT id,name FROM groups WHERE id = '.$info);
            $donnees = $req->fetch(PDO::FETCH_ASSOC);
            
            return new Group($donnees);
        }
        else{
            $req = $this->_bdd->prepare('SELECT id,name FROM groups WHERE name = :name');
            $req->execute([':name' => $info]);
            
            return new Group($req->fetch(PDO::FETCH_ASSOC));
        }
    }

    public function getList($name){
        $groups = [];
    
        $req = $this->_bdd->prepare('SELECT id,name FROM groups WHERE name <> :name ORDER BY name');
        $req->execute([':name' => $name]);
        
        while ($donnees = $req->fetch(PDO::FETCH_ASSOC))        {
        $users[] = new Group($donnees);
        }
        
        return $groups;
    }

    public function update(Group $group){
        $req = $this->_bdd->prepare('UPDATE groups SET name = : name WHERE id = :id');
    
        $req->bindValue(':name', $group->name());
        $req->bindValue(':id', $group->id(), PDO::PARAM_INT);
        
        $req->execute();
    }

    public function setBdd($bdd){
        $this->_bdd = $bdd;
    }

}?>