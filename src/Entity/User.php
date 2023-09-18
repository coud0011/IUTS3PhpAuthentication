<?php

declare(strict_types=1);

namespace Entity;

use Database\MyPdo;
use Entity\Exception\EntityNotFoundException;
use pdo;

class User
{
    private int $id;
    private string $firstName;
    private string $lastName;
    private string $login;
    private string $phone;

    /**
     * @return int
     */
    public function getId(): int
    {
        return $this->id;
    }

    /**
     * @return string
     */
    public function getFirstName(): string
    {
        return $this->firstName;
    }

    /**
     * @return string
     */
    public function getLastName(): string
    {
        return $this->lastName;
    }

    /**
     * @return string
     */
    public function getLogin(): string
    {
        return $this->login;
    }

    /**
     * @return string
     */
    public function getPhone(): string
    {
        return $this->phone;
    }

    public static function findByCredentials(string $login, string $password):self
    {
        $stmt=MyPdo::getInstance()->prepare(
            <<<'SQL'
SELECT id, lastName, firstName, login, phone
FROM user
WHERE login=:loginUser and sha512pass=SHA2(:passwordUser,512)
SQL
        );
        $stmt->bindParam(':loginUser', $login, PDO::PARAM_STR_CHAR);
        $stmt->bindParam(':passwordUser', $password, PDO::PARAM_STR_CHAR);
        $stmt->execute();
        $user=$stmt->fetchObject(self::class);
        if (!$user) {
            throw new EntityNotFoundException("findByCredentials() - User not found");
        }
        return $user;
    }
}
