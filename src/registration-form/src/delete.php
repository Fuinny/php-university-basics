<?php
session_start();
if (!isset($_SESSION['logged']) || $_SESSION['logged'] !== true) {
    header('Location: ../index.php');
    exit;
}
require 'db.php';

if (!isset($_POST['id'])) {
    header("Location: ../templates/students_list.php");
    exit;
}

$studentId = (int)$_POST['id'];

$conn->query("DELETE FROM student_language WHERE student_id = $studentId");

$conn->query("DELETE FROM student WHERE student_id = $studentId");

header("Location: ../templates/admin_dashboard.php");
exit;