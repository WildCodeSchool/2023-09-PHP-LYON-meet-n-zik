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

    public function likeUser($musicianId, $hostId)
    {
        $stmt = $this->pdo->prepare("INSERT INTO meet (musician_user_id, host_user_id) VALUES (:musician_id, :host_id)");
        $stmt->bindParam(':musician_id', $musicianId);
        $stmt->bindParam(':host_id', $hostId);
        $stmt->execute();
    }

    public function getLikedUsers($likerId)
    {
        $stmt = $this->pdo->prepare("SELECT * FROM meet INNER JOIN user u ON meet.musician_user_id = u.id WHERE meet.host_user_id = :liker_id");
        $stmt->bindParam(':liker_id', $likerId);
        $stmt->execute();
        //$users = [];
        //while ($row = $stmt->fetch()) {
          //  $users[] = new User($row['ID'], $row['Username']);
    }
    public function amILikedAsHost($userId, $targetId) : bool
    {
        $stmt = $this->pdo->prepare( "SELECT * FROM meet WHERE  host_user_id = :user_id AND musician_user_id = :target_id)");
        $stmt->bindParam(':user_id', $userId);
        $stmt->bindParam(':target_id',$targetId);
        $stmt->execute();

        return $stmt->fetch();

    }

    public function amILikedAsBand ($userId,$targetId) : bool
    {
        $stmt = $this->pdo->prepare( "SELECT * FROM user WHERE EXISTS (SELECT * FROM meet WHERE  host_user_id = :targe_id AND musician_user_id = :user_id)");
        $stmt->bindParam(':user_id', $userId);
        $stmt->bindParam(':target_id',$targetId);
        $liked = $stmt->execute();

        return $liked;
    }

    public function getMatched($userId,$targetId)
    {
        $stmt = $this->pdo->prepare("ALTER TABLE meet WHERE host_user_id = :targe_id AND musician_user_id = :user_id OR host_user_id = :user_id AND musician_user_id = :target_id ")
    }

}
