<?php
require "db.php";
require "functions.php";
session_start();

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $name = $_POST['name'] ?? '';
    $surname = $_POST['surname'] ?? '';
    $email = $_POST['email'] ?? '';
    $dob = $_POST['dob'] ?? '';
    $city = $_POST['city'] ?? '';
    $gender = $_POST['gender'] ?? '';
    $languages = $_POST['language'] ?? [];
    $comment = $_POST['comment'] ?? '';

    $errors = [];

    if ($errorMsg = checkName($name)) {
        $errors['name'] = $errorMsg;
    }
    if ($errorMsg = checkSurname($surname)) {
        $errors['surname'] = $errorMsg;
    }
    if ($errorMsg = checkEmail($email)) {
        $errors['email'] = $errorMsg;
    }
    if ($errorMsg = checkDoB($dob)) {
        $errors['dob'] = $errorMsg;
    }
    if ($errorMsg = checkCity($city)) {
        $errors['city'] = $errorMsg;
    }
    if ($errorMsg = checkGender($gender)) {
        $errors['gender'] = $errorMsg;
    }
    if ($errorMsg = checkLanguages($languages)) {
        $errors['languages'] = $errorMsg;
    }
    if ($errorMsg = checkComment($comment)) {
        $errors['comment'] = $errorMsg;
    }

    if (!empty($errors)) {
        $_SESSION['errors'] = $errors;
        $_SESSION['old_input'] = $_POST;
        header("Location: ../templates/form.php");
        exit;
    } else {
        $_SESSION['data'] = [
            'name' => $name,
            'surname' => $surname,
            'email' => $email,
            'dob' => $dob,
            'city' => $city,
            'gender' => $gender,
            'languages' => $languages,
            'comment' => $comment
        ];

        $sql = $conn->prepare("INSERT INTO student (student_name, student_surname, student_email, student_dob, student_city, student_gender, student_comment) VALUES (?, ?, ?, ?, ?, ?, ?)");
        $sql->bind_param(
            "ssssiis",
            $name,
            $surname,
            $email,
            $dob,
            $city,
            $gender,
            $comment
        );
        $sql->execute();
        $studentId = $sql->insert_id;
        $sql->close();

        $langSql = $conn->prepare("INSERT INTO student_language (student_id, language_id) VALUES (?, ?)");

        foreach ($languages as $languageId) {
            $languageId = (int)$languageId;
            $langSql->bind_param("ii", $studentId, $languageId);
            $langSql->execute();
        }

        $langSql->close();
        $conn->close();
        header("Location: ../templates/view.php");
        exit;
    }
}