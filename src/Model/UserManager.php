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

    public function likeAUser($userId, $targetId): void
    {
        $stmt = $this->pdo->prepare("INSERT INTO meet (user_id, user_target_id) VALUES (:userId, :targetId)");
        $stmt->bindParam(':userId', $userId);
        $stmt->bindParam(':targetId', $targetId);
        $stmt->execute();
    }


    public function matching($userId, $targetId): bool
    {
        $stmt = $this->pdo->prepare("UPDATE meet SET matched = 'true'
            WHERE (user_id = :user_id AND user_target_id = :target_id)
               OR (user_id = :target_id AND user_target_id = :user_id)");
        $stmt->bindParam(':user_id', $userId);
        $stmt->bindParam(':target_id', $targetId);
        $stmt->execute();

        return true ;
    }
    public function matchedIndex($userId): array
    {
        $stmt = $this->pdo->prepare("SELECT * FROM meet
         WHERE (user_id = :user_id OR user_target_id = :user_id) AND has_liked = 'true'");
        $stmt->bindParam(':user_id', $userId);
        $stmt->execute();
        return $stmt->fetch();
    }


    public function selectAllHostNoLike($userId)
    {
        $statement = $this->pdo->prepare("SELECT user.id, user_name, description, video, picture
FROM user JOIN meet on meet.user_id = user.id WHERE user_id != :id AND user_type_id = 1");
        $statement->bindValue('id', $userId, \PDO::PARAM_INT);
        $statement->execute();

        return $statement->fetchAll();
    }

    public function selectAllBandNoLike($userId): array
    {
        $statement = $this->pdo->prepare("SELECT user.id, user_name, description, video, picture
FROM user JOIN meet on meet.user_id = user.id WHERE user_id != :id AND user_type_id = 2");
        $statement->bindValue('id', $userId, \PDO::PARAM_INT);
        $statement->execute();

        return $statement->fetchAll();
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
