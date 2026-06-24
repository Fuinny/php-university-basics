<?php
namespace Models;

use Core\Database;

class Student {

    public static function all(): array {
        $db = Database::connect();

        $students = $db->query("SELECT * FROM student")->fetch_all(MYSQLI_ASSOC);

        $langRows = $db->query("SELECT student_id, language_id FROM student_language");

        $languages = [];
        while ($r = $langRows->fetch_assoc()) {
            $languages[$r['student_id']][] = $r['language_id'];
        }

        foreach ($students as &$s) {
            $s['languages'] = $languages[$s['student_id']] ?? [];
        }

        return $students;
    }

    public static function create(array $data): int {
        $db = Database::connect();
        $sql = $db->prepare("
            INSERT INTO student (student_name, student_surname, student_email, student_dob, student_city, student_gender, student_comment)
            VALUES (?, ?, ?, ?, ?, ?, ?)
        ");
        $sql->bind_param(
            "ssssiis",
            $data['name'],
            $data['surname'],
            $data['email'],
            $data['dob'],
            $data['city'],
            $data['gender'],
            $data['comment']
        );
        $sql->execute();
        return $sql->insert_id;
    }

    public static function update(int $id, array $data): void {
        $db = Database::connect();
        $sql = $db->prepare("
            UPDATE student SET student_name=?, student_surname=?, student_email=?, student_dob=?, student_city=?, student_gender=?, student_comment=?
            WHERE student_id=?
        ");

        $sql->bind_param(
            "ssssiisi",
            $data['name'],
            $data['surname'],
            $data['email'],
            $data['dob'],
            $data['city'],
            $data['gender'],
            $data['comment'],
            $id
        );
        $sql->execute();
    }

    public static function delete(int $id): void {
        $db = Database::connect();
        $db->query("DELETE FROM student_language WHERE student_id = $id");
        $db->query("DELETE FROM student WHERE student_id = $id");
    }
}
