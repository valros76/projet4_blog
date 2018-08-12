<?php
class PostsManager{

    private $_bdd;

    public function __construct($bdd){
        $this->setBdd($bdd);
    }

    public function add(Post $post){
        //Préparation de la requête d'insertion
        $req = $this->_bdd->prepare('INSERT INTO posts(title,content,date) VALUES(:title,:content,CURDATE())');
        //Assignation des valeurs
        $req->bindValue(':title', $post->title());
        $req->bindValue(':content', $post->content());
        //Execution de la requête
        $req->execute();

        // Hydratation du personnage passé en paramètre avec assignation de son identifiant et des dégâts initiaux (= 0).
        $post->hydrate([
            'id' => $this->_bdd->lastInsertId(),
        ]);
    }

    public function count(){
        // Exécute une requête COUNT() et retourne le nombre de résultats retourné.
        return $this->_bdd->query('SELECT COUNT(*) FROM posts')->fetchColumn();
    }

    public function delete(Post $post){
        $this->_bdd->exec('DELETE FROM posts WHERE id = '.$post->id());
    }

    public function exists($info)
    {
        if (is_int($info)){
        return (bool) $this->_bdd->query('SELECT COUNT(*) FROM posts WHERE id = '.$info)->fetchColumn();
        }
        
        // Sinon, c'est qu'on veut vérifier que le nom existe ou pas.
        
        $req = $this->_bdd->prepare('SELECT COUNT(*) FROM posts WHERE title = :title');
        $req->execute([':title' => $info]);
        
        return (bool) $req->fetchColumn();
    }

    public function exists_content($info){
        if(is_int($info)){
            return (bool) $this->_bdd->query('SELECT COUNT(*) FROM posts WHERE id ='.$info)->fetchColumn();
        }

        //Sinon, c'est qu'on veut vérifier si le commentaire existe

        $req = $this->_bdd->prepare('SELECT COUNT(*) FROM posts WHERE content = :content');
        $req->execute([':content' => $info]);

        return (bool) $req->fetchColumn();
    }

    public function get($info){
        if (is_int($info)){
            $req = $this->_bdd->query('SELECT id,title,content,date FROM posts WHERE id = '.$info);
            $donnees = $req->fetch(PDO::FETCH_ASSOC);
            
            return new Post($donnees);
        }
        else{
            $req = $this->_bdd->prepare('SELECT id,title,content,date FROM posts WHERE title = :title');
            $req->execute([':title' => $info]);
            
            return new Post($req->fetch(PDO::FETCH_ASSOC));
        }
    }

    public function getList($title){
        $titles = [];
    
        $req = $this->_bdd->prepare('SELECT id,title,content FROM posts WHERE title <> :title ORDER BY title');
        $req->execute([':title' => $title]);
        
        while ($donnees = $req->fetch(PDO::FETCH_ASSOC))        {
        $titles[] = new Post($donnees);
        }
        
        return $title;
    }

    public function update(Post $post){
        $req = $this->_bdd->prepare('UPDATE posts SET title = :title, content = :content, date = CURDATE() WHERE id = :id');
    
        $req->bindValue(':title', $post->title());
        $req->bindValue(':content', $post->content());
        
        $req->execute();
    }

    public function setBdd($bdd){
        $this->_bdd = $bdd;
    }

}?>