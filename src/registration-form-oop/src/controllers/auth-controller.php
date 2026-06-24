<?php
namespace Controllers;

use Auth\Auth;
use Core\Session;
use Core\Redirect;

class AuthController {
    private const KEY_LOGIN_ERROR = 'login_error';

    public static function login() {
        Session::start();

        $username = $_POST['username'] ?? "";
        $password = $_POST['password'] ?? "";

        if (Auth::checkLogin($username, $password)) {
            if (Session::get("loggedAsAdmin", false)) {
                Redirect::to('../templates/admin_dashboard.php');
            } else {
                Redirect::to('../templates/form.php');
            }
        } else {
            Session::set(self::KEY_LOGIN_ERROR, "Neteisingi duomenys!");
            Redirect::to('../templates/login.php');
        }
    }

    public static function logout() {
        Auth::logout();
        Redirect::to('../index.php');
    }
}
