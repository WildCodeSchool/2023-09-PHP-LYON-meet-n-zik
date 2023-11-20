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
    }

    public function matchedIndex($userId): array
    {
        $statement = $this->pdo->prepare("SELECT * FROM meet 
        WHERE (host_user_id = :user_id OR musician_user_id = :user_id) AND matched = 'true'");
        $statement->bindParam(':user_id', $userId);
        $statement->execute();

        $matches = $statement->fetchAll(PDO::FETCH_ASSOC);

        return $matches;
    }
}
