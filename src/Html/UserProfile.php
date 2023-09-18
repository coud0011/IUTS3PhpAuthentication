<?php

declare(strict_types=1);

namespace Html;

use Entity\User;

class UserProfile
{
    use StringEscaper;
    private User $user;

    public function __construct(User $user)
    {
        $this->user = $user;
    }

    public function getUser(): User
    {
        return $this->user;
    }

    public function toHtml(): string
    {
        $name = $this->escapeString($this->user->getLastName());
        $firstName = $this->escapeString($this->user->getFirstName());
        $login = $this->escapeString($this->user->getLogin());
        $id = $this->escapeString((string) $this->user->getId());
        $phone = $this->escapeString($this->user->getPhone());

        return <<<HTML
            <div class="UserInformations">
                <h3>Nom</h3>
                <a>     $name</a>
                <h3>Prénom</h3>
                <a>     $firstName</a>
                <h3>Login</h3>
                <a>     $login 
HTML
            .'['.$id.']'.<<<HTML
</a>
                <h3>Téléphone</h3>
                <a>     $phone</a>
            </div>

HTML
        ;
    }
}
