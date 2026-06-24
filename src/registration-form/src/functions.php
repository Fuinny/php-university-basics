<?php
require "db.php";

function hashPassword($password) {
    if ($password != '') {
        $hashedPassword = password_hash($password, PASSWORD_DEFAULT);
        return $hashedPassword;
    }
}

function checkLogin($conn, $username, $password) {
    if ($username !== '' && $password !== '') {
        $sql = $conn->prepare("SELECT login_password FROM `login` WHERE `login_name` = ?");
        $sql->bind_param("s", $username);
        $sql->execute();
        $sql->store_result();
        $storedHash = '';
        if ($sql->num_rows === 1) {
            $sql->bind_result($storedHash);
            $sql->fetch();

            if (password_verify($password, $storedHash)) {
                $sql->close();
                return TRUE;
            }
        }
        $sql->close();
    }
    return FALSE;
}

function getStudentList($conn) {
    $students = [];
    $sql = "SELECT * FROM `student`";
    $result = mysqli_query($conn, $sql);
    if(mysqli_num_rows($result) > 0) {
        $students = mysqli_fetch_all($result, MYSQLI_ASSOC);
    }

    $langSql = "SELECT student_id, language_id FROM student_language";
    $langResult = mysqli_query($conn, $langSql);
    $studentLanguages = [];
    if(mysqli_num_rows($langResult) > 0) {
        while ($row = mysqli_fetch_assoc($langResult)) {
            $studentLanguages[$row['student_id']][] = $row['language_id'];
        }
    }

    foreach ($students as &$student) {
        $id = $student['student_id'];
        $student['languages'] = $studentLanguages[$id] ?? [];
    }
    return $students;
}

function checkName($nameToCheck) {
    $nameToCheck = trim($nameToCheck);
    if (empty($nameToCheck)) {
        return "Vardo laukas negali būti tuščias!";
    } elseif (!preg_match("/^[\p{L}\s]+$/u", $nameToCheck)) {
        return "Varde yra netinkamų simbolių!";
    }
    return null;
}

function checkSurname($surnameToCheck) {
    $surnameToCheck = trim($surnameToCheck);
    if (empty($surnameToCheck)) {
        return "Pavardės laukas negali būti tuščias!";
    } elseif (!preg_match("/^[\p{L}\s]+$/u", $surnameToCheck)) {
        return "Pavardėje yra netinkamų simbolių!";
    }
    return null;
}

function checkEmail($emailToCheck) {
    $emailToCheck = trim($emailToCheck);
    if (empty($emailToCheck)) {
        return "El. pašto laukas negali būti tuščias!";
    } elseif (!filter_var($emailToCheck, FILTER_VALIDATE_EMAIL)) {
        return "Neteisingas el. paštas!";
    }
    return null;
}

function checkDoB($dobToCheck) {
    if (empty($dobToCheck)) {
        return "Gimimo datos laukas negali būti tuščias!";
    } else {
        $parsed = date_parse($dobToCheck);

        if (!checkdate($parsed['month'], $parsed['day'], $parsed['year'])) {
            return "Neteisinga gimimo data!";
        } else {
            $dobTimestamp = strtotime($dobToCheck);
            $today = time();
            $min = strtotime('-120 years');

            if ($dobTimestamp > $today) {
                return "Gimimo data negali būti ateityje!";
            } elseif ($dobTimestamp < $min) {
                return "Gimimo data per sena, tikėtina klaida!";
            }
        }
    }
    return null;
}

function checkCity($cityToCheck) {
    if (empty($cityToCheck) || $cityToCheck === "none") {
        return "Miesto laukas negali būti tuščias!";
    } elseif (!in_array($cityToCheck, ["1", "2", "3"], false)) {
        return "Neteisingas miestas!";
    }
    return null;
}

function checkGender($genderToCheck) {
    if (empty($genderToCheck)) {
        return "Lyties laukas negali būti tuščia!";
    } elseif (!in_array($genderToCheck, ["1", "2", "3"], false)) {
        return "Neteisinga lytis!";
    }
    return null;
}

function checkLanguages($languagesToCheck) {
    if (empty($languagesToCheck)) {
        return "Būtina pasirinkti bent vieną kalbą!";
    } else {
        $validLanguages = ["1", "2", "3"];
        foreach ($languagesToCheck as $lang) {
            if (!in_array($lang, $validLanguages, false)) {
                return "Pasirinkta netinkama kalba!";
            }
        }
    }
    return null;
}

function checkComment($commentToCheck) {
    if (strlen($commentToCheck) > 1000) {
        return "Komentaras per ilgas!";
    }
    return null;
}