<?php

namespace App\Model;

class ReviewManager extends AbstractManager
{

    /**
     *
     */
    const TABLE = 'review';

    /**
     *  Initializes this class.
     */
    public function __construct()
    {
        parent::__construct(self::TABLE);
    }
    /**
     * Get all row from database, ordered by asc.
     *
     * @return array
     */
    public function selectAllReviews(): array
    {
        return $this->pdo->query('SELECT * FROM ' . $this->table .' WHERE online = 1 ORDER BY id DESC')->fetchAll();
    }


    /**
     * @param array $cleanReview
     * @return int
     */
    public function insert(array $cleanReview): int
    {
        // prepared request
        $date = date("d/m/Y");
        $statement = $this->pdo->prepare("INSERT INTO " . self::TABLE . " (name, date, comment, rating, online) 
        VALUES (:name, :date, :comment, :rating, :online)");
        $statement->bindValue(':name', $cleanReview['name'], \PDO::PARAM_STR);
        $statement->bindValue(':comment', $cleanReview['comment'], \PDO::PARAM_STR);
        $statement->bindValue(':rating', $cleanReview['rating'], \PDO::PARAM_STR);
        $statement->bindValue(':date', $date, \PDO::PARAM_STR);
        $statement->bindValue(':online', 0, \PDO::PARAM_STR);
        if ($statement->execute()) {
            return (int)$this->pdo->lastInsertId();
        }
    }
}
