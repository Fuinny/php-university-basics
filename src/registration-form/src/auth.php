<?php
require "db.php";
require "functions.php";

session_start();

$username = $_POST['username'] ?? null;
$password = $_POST['password'] ?? null;

if (empty($username) || empty($password)) {
    $_SESSION['login_error'] = "Įveskite prisijungimo duomenis!";
    header('Location: ../templates/login.php');
    exit;
} else {
    if (checkLogin($conn, $username, $password)) {
        $_SESSION['logged'] = TRUE;
        if ($username == "admin") {
            $_SESSION['loggedAsAdmin'] = TRUE;
            header('Location: ../templates/admin_dashboard.php');
            exit;
        }
        header('Location: ../templates/form.php');
        exit;
    } else {
        $_SESSION['logged'] = FALSE;
        $_SESSION['login_error'] = "Neteisingas vartotojo vardas arba slaptažodis!";
        header('Location: ../templates/login.php');
        exit;
    }
}