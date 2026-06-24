<?php
namespace Auth;

use Core\Database;
use Core\Session;
use Core\Redirect;

final class Auth
{
    private const KEY_LOGGED = 'logged';
    private const KEY_LOGGED_AS_ADMIN = 'loggedAsAdmin';
    private const KEY_LOGIN_ERROR = 'login_error';

    private const ADMIN_LOGIN = 'admin';

    public static function checkLogin(string $username, string $password): bool
    {
        Session::start();

        $username = trim($username);
        if ($username === '' || $password === '') {
            Session::set(self::KEY_LOGIN_ERROR, 'Įveskite vartotojo vardą ir slaptažodį.');
            return false;
        }

        $db = Database::connect();

        $sql = $db->prepare("SELECT login_password FROM login WHERE login_name = ? LIMIT 1");
        $sql->bind_param("s", $username);
        $sql->execute();
        $sql->store_result();

        if ($sql->num_rows !== 1) {
            Session::set(self::KEY_LOGIN_ERROR, 'Neteisingas vartotojo vardas arba slaptažodis.');
            return false;
        }

        $sql->bind_result($hash);
        $sql->fetch();

        if (!password_verify($password, $hash)) {
            Session::set(self::KEY_LOGIN_ERROR, 'Neteisingas vartotojo vardas arba slaptažodis.');
            return false;
        }

        $isAdmin = ($username === self::ADMIN_LOGIN);
        self::login($isAdmin);

        return true;
    }

    public static function login(bool $asAdmin): void
    {
        Session::start();
        session_regenerate_id(true);

        Session::set(self::KEY_LOGGED, true);
        Session::set(self::KEY_LOGGED_AS_ADMIN, $asAdmin);

        Session::forget(self::KEY_LOGIN_ERROR);
    }

    public static function logout(): void
    {
        Session::start();
        Session::destroy();
    }

    public static function isLoggedIn(): bool
    {
        Session::start();
        return Session::get(self::KEY_LOGGED, false) === true;
    }

    public static function isLoggedInAsAdmin(): bool
    {
        Session::start();
        return self::isLoggedIn() && Session::get(self::KEY_LOGGED_AS_ADMIN, false) === true;
    }

    public static function requireLogin(string $redirectTo): void
    {
        if (!self::isLoggedIn()) {
            Redirect::to($redirectTo);
        }
    }

    public static function requireLoginAsAdmin(string $redirectTo): void
    {
        if (!self::isLoggedInAsAdmin()) {
            Redirect::to($redirectTo);
        }
    }

    public static function getLoginError(): ?string
    {
        Session::start();
        $err = Session::flash(self::KEY_LOGIN_ERROR);
        return is_string($err) ? $err : null;
    }
}
