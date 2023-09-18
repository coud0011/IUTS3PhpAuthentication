<?php

declare(strict_types=1);

namespace Entity;

use Database\MyPdo;
use Entity\Exception\EntityNotFoundException;

class User
{
    private int $id;
    private string $firstName;
    private string $lastName;
    private string $login;
    private string $phone;

    public function getId(): int
    {
        return $this->id;
    }

    public function getFirstName(): string
    {
        return $this->firstName;
    }

    public function getLastName(): string
    {
        return $this->lastName;
    }

    public function getLogin(): string
    {
        return $this->login;
    }

    public function getPhone(): string
    {
        return $this->phone;
    }

    public static function findByCredentials(string $login, string $password): self
    {
        $stmt = MyPdo::getInstance()->prepare(
            <<<'SQL'
SELECT id, lastName, firstName, login, phone
FROM user
WHERE login=:loginUser and sha512pass=SHA2(:passwordUser,512)
SQL
        );
        $stmt->bindParam(':loginUser', $login, \PDO::PARAM_STR_CHAR);
        $stmt->bindParam(':passwordUser', $password, \PDO::PARAM_STR_CHAR);
        $stmt->execute();
        $user = $stmt->fetchObject(self::class);
        if (!$user) {
            throw new EntityNotFoundException('findByCredentials() - User not found');
        }

        return $user;
    }
}
