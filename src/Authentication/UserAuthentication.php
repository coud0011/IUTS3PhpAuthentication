<?php

declare(strict_types=1);

namespace Authentication;

use Authentication\Exception\AuthenticationException;
use Entity\User;

class UserAuthentication
{
    private const LOGIN_INPUT_NAME = 'login';
    private const PASSWORD_INPUT_NAME = 'password';

    public function loginForm(string $action, string $submitText = 'OK'): string
    {
        $login = self::LOGIN_INPUT_NAME;
        $pass = self::PASSWORD_INPUT_NAME;

        return <<<HTML
            <form action="$action" method="post">
                <ul>
                    <li>
                        <label for="login">$login&nbsp;:</label>
                        <input type="text" id="login" name="user_login" />
                    </li>
                    <li>
                        <label for="password">$pass&nbsp;:</label>
                        <input type="password" id="pass" name="user_password" />
                    </li>
                </ul>
                <div class="button">
                    <button type="submit">$submitText</button>
                </div>
            </form>
HTML
        ;
    }

    /**
     * @throws AuthenticationException
     */
    public function getUserFromAuth(): User
    {
        if(isset($_POST['user_login'])&&isset($_POST['user_password'])) {
            return User::findByCredentials($_POST['user_login'], $_POST['user_password']);
        } else {
            throw new AuthenticationException("loginForm: User not found");
        }
    }
}
