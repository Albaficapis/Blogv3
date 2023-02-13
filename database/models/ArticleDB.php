<?php
$pdo = require_once  __DIR__ . '/../database.php';
class ArticleDB
{
    private PDOStatement $statementCreateone;
    private PDOStatement $statementReadOne;
    private PDOStatement $statementUpdateOne;
    private PDOStatement $statementDeleteOne;
    private PDOStatement $statementReadAll;
    function __construct(private PDO $pdo) 
    {
        $this->statementCreateone = $pdo->prepare('INSERT INTO article(title,category,content,image) VALUES (:title, :category,:content,:image)');
        $this->statementUpdateOne = $pdo->prepare('UPDATE article SET title=:title, category=:category, content=:content, image=:image WHERE id=:id');
        $this->statementReadOne = $pdo->prepare('SELECT * FROM article WHERE id=:id');
        $this->statementReadAll = $pdo->prepare('SELECT * FROM article');
        $this->statementDeleteOne = $pdo->prepare('DELETE FROM article WHERE id=:id');
    }
    public function fetchAll() {

        $this->statementReadAll->execute();
        return $this->statementReadAll->fetchAll();
    }
    public function fetchOne(string $id) {
        $this->statementReadOne->bindValue(':id',$id);
        $this->statementReadOne->execute();
        return $this->statementReadOne->fetch();
    }
    public function deleteOne(string $id) {

        $this->statementDeleteOne->bindValue(':id',$id);
        $this->statementDeleteOne->execute();
        return $id;
    }
    public function createOne($article) {
                $this->statementCreateone->bindValue(':title', $article['title'] );
                $this->statementCreateone->bindValue(':image', $article['image'] );
                $this->statementCreateone->bindValue(':content', $article['content'] );
                $this->statementCreateone->bindValue(':category', $article['category'] );
                $this->statementCreateone->execute();
                return $this->fetchOne($this->pdo->lastInsertId());

    }
    public function updateOne($article) {
        $this->statementUpdateOne->bindValue(':title', $article['title'] );
        $this->statementUpdateOne->bindValue(':image', $article['image'] );
        $this->statementUpdateOne->bindValue(':content', $article['content'] );
        $this->statementUpdateOne->bindValue(':category', $article['category'] );
        $this->statementUpdateOne->bindValue(':id', $article['id']);
        $this->statementUpdateOne->execute();
        return $article;

    }

}

return new ArticleDB($pdo);