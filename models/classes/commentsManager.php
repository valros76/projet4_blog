<?php
class CommentsManager{
    private $_bdd;

    public function __construct($bdd){
        $this->setBdd($bdd);
    }

    public function add(Comment $comment){
        //Préparation de la requête d'insertion
        $req = $this->_bdd->prepare('INSERT INTO comments(post_id,author,comment,date_comment, is_signaled) VALUES(:post_id,:author,:comment,CURDATE(), :is_signaled)');
        //Assignation des valeurs
        $req->bindValue(':post_id', $comment->postId());
        $req->bindValue(':author', $comment->author());
        $req->bindValue(':comment', $comment->comment());
        $req->bindValue(':is_signaled', $comment->is_signaled());
        //Execution de la requête
        $req->execute();

        // Hydratation du personnage passé en paramètre avec assignation de son identifiant et des dégâts initiaux (= 0).
        $comment->hydrate([
            'id' => $this->_bdd->lastInsertId()
        ]);
    }

    public function count(){
        // Exécute une requête COUNT() et retourne le nombre de résultats retourné.
        return $this->_bdd->query('SELECT COUNT(*) FROM comments')->fetchColumn();
    }

    public function delete(Comment $comment){
        $this->_bdd->exec('DELETE FROM comments WHERE id = '.$comment->id());
    }

    public function exists($info)
    {
        if (is_int($info)){
        return (bool) $this->_bdd->query('SELECT COUNT(*) FROM comments WHERE id = '.$info)->fetchColumn();
        }
        
        // Sinon, c'est qu'on veut vérifier que le nom existe ou pas.
        
        $req = $this->_bdd->prepare('SELECT COUNT(*) FROM comments WHERE author = :author');
        $req->execute([':author' => $info]);
        
        return (bool) $req->fetchColumn();
    }

    public function exists_comment($info){
        if(is_int($info)){
            return (bool) $this->_bdd->query('SELECT COUNT(*) FROM comments WHERE id ='.$info)->fetchColumn();
        }

        //Sinon, c'est qu'on veut vérifier si le commentaire existe

        $req = $this->_bdd->prepare('SELECT COUNT(*) FROM comments WHERE comment = :comment');
        $req->execute([':comment' => $info]);

        return (bool) $req->fetchColumn();
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

    public function getList($author){
        $comments = [];
    
        $req = $this->_bdd->prepare('SELECT id,author,comment FROM comments WHERE author <> :author ORDER BY author');
        $req->execute([':author' => $author]);
        
        while ($donnees = $req->fetch(PDO::FETCH_ASSOC))        {
        $comments[] = new Comment($donnees);
        }
        
        return $comments;
    }

    public function update(Comment $comment){
        $req = $this->_bdd->prepare('UPDATE comments SET post_id = :post_id, author = :author, comment = :comment, date_comment = CURDATE(), is_signaled = :is_signaled WHERE id = :id');
    
        $req->bindValue(':post_id', $comment->postId(), PDO::PARAM_INT);
        $req->bindValue(':author', $comment->author(), PDO::PARAM_INT);
        $req->bindValue(':comment', $comment->comment(), PDO::PARAM_INT);
        $req->bindValue(':is_signaled', $comment->is_signaled(), PDO::PARAM_INT);
        
        $req->execute();
    }

    public function can_signaled(Comment $comment){
        $req = $this->_bdd->prepare('UPDATE comments SET is_signaled = :is_signaled WHERE id = :id');

        $req->bindValue(':is_signaled', $comment->signaled(), PDO::PARAM_INT);
        $req->bindValue(':id', $comment->id(), PDO::PARAM_INT);

        $req->execute();
    }

    public function unsignaled(Comment $comment){
        $req = $this->_bdd->prepare('UPDATE comments SET is_signaled = :is_signaled WHERE id = :id');

        $req->bindValue(':is_signaled', $comment->is_signaled(), PDO::PARAM_INT);
        $req->bindValue(':id', $comment->id(), PDO::PARAM_INT);

        $req->execute();
    }

    public function setBdd($bdd){
        $this->_bdd = $bdd;
    }
}?>