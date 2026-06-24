<?php
require __DIR__ . '/src/bootstrap.php';

use Auth\Auth;
use Core\Redirect;

if (!Auth::isLoggedIn()) {
    Redirect::to('templates/login.php');
}

if (Auth::isLoggedInAsAdmin()) {
    Redirect::to('templates/admin_dashboard.php');
}

Redirect::to('templates/form.php');
