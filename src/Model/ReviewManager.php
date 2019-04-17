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
     * @param array $review
     * @return int
     */
    public function insert(array $review): int
    {
        // prepared request
        $statement = $this->pdo->prepare("INSERT INTO " . self::TABLE . " (name, comment, rating) 
        VALUES (:name, :comment, :rating)");
        $statement->bindValue(':name', $review['name'], \PDO::PARAM_STR);
        $statement->bindValue(':comment', $review['comment'], \PDO::PARAM_STR);
        $statement->bindValue(':rating', $review['rating'], \PDO::PARAM_STR);
        if ($statement->execute()) {
            return (int)$this->pdo->lastInsertId();
        }
    }
}