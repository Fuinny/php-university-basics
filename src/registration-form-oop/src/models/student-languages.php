<?php
namespace Models;

use Core\Database;

class StudentLanguage {

    public static function setLanguages(int $studentId, array $languages): void {
        $db = Database::connect();

        $db->query("DELETE FROM student_language WHERE student_id = $studentId");

        $sql = $db->prepare("INSERT INTO student_language (student_id, language_id) VALUES (?, ?)");

        foreach ($languages as $lang) {
            $sql->bind_param("ii", $studentId, $lang);
            $sql->execute();
        }
    }
}
