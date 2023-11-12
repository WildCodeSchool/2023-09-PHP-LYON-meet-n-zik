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
        $statement->bindValue(':user_type_id', $credentials['user_type_id'], \PDO::PARAM_STR);
        $statement->execute();
    }

// login with email OR user_name
    public function selectUserNameOrEmail(string $userName): array|false
    {
        $statement = $this->pdo->prepare(
            "SELECT * FROM " . static::TABLE .
            " WHERE user_name = :username OR email = :username"
        );
        $statement->bindValue(':username', $userName, \PDO::PARAM_STR);
        $statement->execute();

        return $statement->fetch();
    }
}
