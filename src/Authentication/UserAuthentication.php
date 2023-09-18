<?php

declare(strict_types=1);

namespace Authentication;

use Authentication\Exception\AuthenticationException;
use Entity\User;
use Service\Exception\SessionException;
use Service\Session;

class UserAuthentication
{
    private const LOGIN_INPUT_NAME = 'login';
    private const PASSWORD_INPUT_NAME = 'password';
    private const SESSION_KEY = '__UserAuthentication__';
    private const SESSION_USER_KEY = 'user';
    private ?User $user = null;

    /**
     * @throws SessionException
     */
    public function __construct()
    {
        Session::start();
    }

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
            $this->setUser(User::findByCredentials($_POST['user_login'], $_POST['user_password']));
            return $this->user;
        } else {
            throw new AuthenticationException("loginForm: User not found");
        }
    }


    public function setUser(User $user):void
    {
        $this->user=$user;
        $_SESSION[self::SESSION_KEY][self::SESSION_USER_KEY]=$user;
    }
}
