<?php

declare(strict_types=1);

namespace Service;

use Service\Exception\SessionException;

/**
 * Class Session, used for create a session in a client using cookie.
 */
class Session
{
    /**
     * Static Method start, used for starting a session in a client if it's possible.
     *
     * If it isn't possible :
     * @throws SessionException
     */
    public static function start():void{
        $PHP_SESSION=session_status();
        if($PHP_SESSION!=PHP_SESSION_ACTIVE) {
            if ($PHP_SESSION == PHP_SESSION_NONE) {
                if (headers_sent()) {
                    throw new SessionException(__CLASS__ . " : HTTP headings already set .");
                }
                $PHP_SESSION_STARTING = session_start();
                if (!$PHP_SESSION_STARTING) {
                    throw new SessionException(__CLASS__ . " : Session haven't started.");
                }
            }
            elseif ($PHP_SESSION == PHP_SESSION_DISABLED) {
                throw new SessionException(__CLASS__ . " : Session are disabled.");
            }
            else{
                throw new SessionException(__CLASS__ . " : Unknown problem during testing sessions");
            }
        }
    }
}