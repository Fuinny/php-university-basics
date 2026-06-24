<?php
session_start();
if (!isset($_SESSION['logged']) || $_SESSION['logged'] !== true) {
    header('Location: ../index.php');
    exit;
}
require '../src/db.php';

$id = $_POST['id'];
$name = $_POST['name'];
$surname = $_POST['surname'];
$email = $_POST['email'];
$dob = $_POST['dob'];
$city = $_POST['city'];
$gender = $_POST['gender'];
$languages = $_POST['languages']; // comma-separated: "1,2,3"
$comment = $_POST['comment'];

$sql = $conn->prepare("UPDATE student SET student_name=?, student_surname=?, student_email=?, student_dob=?, student_city=?, student_gender=?, student_comment=? WHERE student_id=?");

$sql->bind_param("ssssissi", $name, $surname, $email, $dob, $city, $gender, $comment, $id);

$sql->execute();
$sql->close();

$conn->query("DELETE FROM student_language WHERE student_id=$id");

$langArray = array_map('intval', explode(',', $languages));

$langSql = $conn->prepare("INSERT INTO student_language (student_id, language_id) VALUES (?, ?)");

foreach ($langArray as $langId) {
    $langSql->bind_param("ii", $id, $langId);
    $langSql->execute();
}

$langSql->close();

header("Location: ../templates/admin_dashboard.php");
exit;