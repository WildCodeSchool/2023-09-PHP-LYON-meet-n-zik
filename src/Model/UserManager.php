<?php

namespace App\Model;

use App\Model\AbstractManager;
use PDO;

class UserManager extends AbstractManager
{
    public const TABLE = 'user';

    public function selectOneByEmail(string $email): array|false
    {
        // prepared request
        $statement = $this->pdo->prepare("SELECT * FROM " . static::TABLE . " WHERE email=:email");
        $statement->bindValue('email', $email, \PDO::PARAM_STR);
        $statement->execute();

        return $statement->fetch();
    }
    public function selectOneById(int $id): array|false
    {
        // prepared request
        $statement = $this->pdo->prepare("SELECT * FROM " . static::TABLE . " WHERE id=:id ");
        $statement->bindValue('id', $id, \PDO::PARAM_INT);
        $statement->execute();

        return $statement->fetch();
    }

//register user
    public function insert(array $credentials)
    {
        $statement = $this->pdo->prepare(
            "INSERT INTO " . static::TABLE .
            "(`user_name`, `email`, `password`, `user_type_id`)
            VALUES(:user_name,:email, :password, :user_type_id) "
        );
        $statement->bindValue(':user_name', $credentials['name'], \PDO::PARAM_STR);
        $statement->bindValue(':email', $credentials['email'], \PDO::PARAM_STR);
        $statement->bindValue(':password', password_hash($credentials['password'], PASSWORD_DEFAULT));
        $statement->bindValue(':user_type_id', $credentials['user_type_id'], \PDO::PARAM_INT);
        $statement->execute();
    }
<<<<<<< HEAD

=======
>>>>>>> 4ee2d11213ad831319522bd2c482b070096b74a3
    public function selectAllHost(string $orderBy = '', string $direction = 'ASC'): array
    {
        $query = 'SELECT * FROM ' . static::TABLE . ' WHERE user_type_id = 1';
        if ($orderBy) {
            $query .= ' ORDER BY ' . $orderBy . ' ' . $direction;
        }

        return $this->pdo->query($query)->fetchAll();
    }
    public function selectAllBand(string $orderBy = '', string $direction = 'ASC'): array
    {
        $query = 'SELECT * FROM ' . static::TABLE . ' WHERE user_type_id = 2';
        if ($orderBy) {
            $query .= ' ORDER BY ' . $orderBy . ' ' . $direction;
        }

        return $this->pdo->query($query)->fetchAll();
    }

<<<<<<< HEAD
    public function likedAsHost(int $userId, int $targetId): int
{
    $statement = $this->pdo->prepare("INSERT INTO meet (musician_user_id, host_user_id) VALUES (:targetId, :userId)");
    $statement->bindValue('targetId', $targetId, PDO::PARAM_INT); 
    $statement->bindValue('userId', $userId, PDO::PARAM_INT);
    $statement->execute();

    return (int)$this->pdo->lastInsertId();
}

    public function likedAsBand ($userId,$targetId) : array
    {
        $stmt = $this->pdo->prepare( "SELECT * FROM meet WHERE host_user_id = :target_id AND musician_user_id = :user_id");
        $stmt->bindParam(':user_id', $userId);
        $stmt->bindParam(':target_id',$targetId);
        $stmt->execute();

        return $stmt->fetch();
    }

    public function matchingAsHost($userId, $targetId) : bool
    {
        $stmt = $this->pdo->prepare("UPDATE meet SET matched = 'true' WHERE host_user_id = :user_id AND musician_user_id = :target_id");
        $stmt->bindParam(':user_id', $userId);
        $stmt->bindParam(':target_id',$targetId);
        return $stmt->execute();
    }

    public function matchedIndex($userId) : array
    {
        $stmt = $this->pdo->prepare("SELECT * FROM meet WHERE (host_user_id = :user_id OR musician_user_id = :user_id) AND matched = 'true'");
        $stmt->bindParam(':user_id', $userId);
        $stmt->execute();
        return $stmt->fetch();
    }

    public function findMatchAsHost($userId, $targetId) : array
    {
        $stmt = $this->pdo->prepare("SELECT * FROM meet WHERE host_user_id = :user_id AND musician_user_id = :target_id");
        $stmt->bindParam(':user_id', $userId);
        $stmt->bindParam(':target_id', $targetId);
        $stmt->execute();
        return $stmt->fetch();
=======
        /**
     * Update profil in database
     */
    public function update(array $user): bool
    {
        $statement = $this->pdo->prepare("UPDATE " . self::TABLE .
        " SET `user_name` = :user_name, `email` = :email, `description` = :description, `video` = :video WHERE id=:id");
        $statement->bindValue(':id', $user['id'], PDO::PARAM_INT);
        $statement->bindValue(':user_name', $user['user_name'], PDO::PARAM_STR);
        $statement->bindValue(':email', $user['email'], PDO::PARAM_STR);
        $statement->bindValue(':description', $user['description'], PDO::PARAM_STR);
        $statement->bindValue(':video', $user['video'], PDO::PARAM_STR);

        return $statement->execute();
>>>>>>> 4ee2d11213ad831319522bd2c482b070096b74a3
    }
}
