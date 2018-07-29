<?php
class CommentsManager{
    private $_bdd;

    public function __construct($bdd){
        $this->setBdd($bdd);
    }

    public function add(Comment $comment){
        //Préparation de la requête d'insertion
        $req = $this->_bdd->prepare('INSERT INTO comments(post_id,author,comment,date_comment) VALUES(:post_id,:author,:comment,CURDATE())');
        //Assignation des valeurs
        $req->bindValue(':post_id', $comment->postId());
        $req->bindValue(':author', $comment->author());
        $req->bindValue(':comment', $perso->comment());
        //Execution de la requête
        $req->execute();

        // Hydratation du personnage passé en paramètre avec assignation de son identifiant et des dégâts initiaux (= 0).
        $comment->hydrate([
            'id' => $this->_bdd->lastInsertId(),
        ]);
    }

    public function count(){
        // Exécute une requête COUNT() et retourne le nombre de résultats retourné.
        return $this->_bdd->query('SELECT COUNT(*) FROM comments')->fetchColumn();
    }

    public function delete(Comment $comment){
        $this->_bdd->exec('DELETE FROM comments WHERE id = '.$comment->id());
    }

    public function get($info){
        if (is_int($info)){
            $req = $this->_bdd->query('SELECT id,post_id,author,comment,date_comment FROM comments WHERE id = '.$info);
            $donnees = $req->fetch(PDO::FETCH_ASSOC);
            
            return new Comment($donnees);
        }
        else{
            $req = $this->_bdd->prepare('SELECT id,post_id,author,comment,date_comment FROM comments WHERE author = :author');
            $req->execute([':author' => $info]);
            
            return new Comment($req->fetch(PDO::FETCH_ASSOC));
        }
    }

    public function getList(){
        $comments = [];
    
        $req = $this->_bdd->prepare('SELECT id,author,comment FROM comments WHERE author <> :author ORDER BY author');
        $req->execute([':author' => $nom]);
        
        while ($donnees = $req->fetch(PDO::FETCH_ASSOC))        {
        $persos[] = new Comment($donnees);
        }
        
        return $comments;
    }

    public function update(Comment $comment){
        $req = $this->_bdd->prepare('UPDATE comments SET post_id = :post_id, author = :author, comment = :comment, date_comment = CURDATE() WHERE id = :id');
    
        $req->bindValue(':post_id', $comment->postId(), PDO::PARAM_INT);
        $req->bindValue(':author', $comment->author(), PDO::PARAM_INT);
        $req->bindValue(':comment', $comment->comment(), PDO::PARAM_INT);
        
        $req->execute();
    }

    public function setBdd($bdd){
        $this->_bdd = $bdd;
    }
}?>