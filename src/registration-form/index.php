<?php
session_start();

if (!isset($_SESSION['logged']) || $_SESSION['logged'] !== TRUE) {
    header('Location: templates/login.php');
    exit;
} else {
    header('Location: templates/form.php');
    exit;
}