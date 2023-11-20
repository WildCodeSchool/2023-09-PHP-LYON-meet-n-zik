<?php

namespace App\Model;

use App\Model\AbstractManager;

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
        $statement->bindValue(':user_type_id', $credentials['user_type_id'], \PDO::PARAM_STR);
        $statement->execute();
    }

    public function LikedAsHost($userId, $targetId): array
    {
        $stmt = $this->pdo->prepare("INSERT INTO meet (musician_user_id, host_user_id) VALUES (:targetId, :userId)");
        $stmt->bindParam(':target_id', $targetId);
        $stmt->bindParam(':user_id', $userId);
        $stmt->execute();

        return $stmt->fetch();
    }

    public function likedAsBand($userId, $targetId): array
    {
        $stmt = $this->pdo->prepare("INSERT INTO meet (musician_user_id, host_user_id) VALUES (:userId, :targetId)");
        $stmt->bindParam(':user_id', $userId);
        $stmt->bindParam(':target_id', $targetId);
        $stmt->execute();

        return $stmt->fetch();
    }

    public function matching($userId, $targetId): bool
    {
        $stmt = $this->pdo->prepare("UPDATE meet SET matched = 'true' WHERE (host_user_id = :target_id AND musician_user_id = :user_id) OR (host_user_id = :user_id AND musician_user_id = :target_id)");
        $stmt->bindParam(':user_id', $userId);
        $stmt->bindParam(':target_id', $targetId);
        $stmt->execute();

        return true ;
    }

    public function matchedIndex($userId): array
    {
        $stmt = $this->pdo->prepare("SELECT * FROM meet WHERE (host_user_id = :user_id OR musician_user_id = :user_id) AND matched = 'true'");
        $stmt->bindParam(':user_id', $userId);
        $stmt->execute();
        return $stmt->fetch();
    }
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
}
