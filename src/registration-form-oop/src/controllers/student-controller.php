<?php
namespace Controllers;

use Core\Session;
use Core\Redirect;
use Models\Student;
use Models\StudentLanguage;
use Validation\Validator;
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;
use PhpOffice\PhpSpreadsheet\Writer\Pdf\Mpdf;

class StudentController {

    public static function submitForm() {
        Session::start();

        $data = [
            "name"     => $_POST["name"] ?? "",
            "surname"  => $_POST["surname"] ?? "",
            "email"    => $_POST["email"] ?? "",
            "dob"      => $_POST["dob"] ?? "",
            "city"     => $_POST["city"] ?? "",
            "gender"   => $_POST["gender"] ?? "",
            "languages"=> $_POST["language"] ?? [],
            "comment"  => $_POST["comment"] ?? ""
        ];

        $errors = [];
        
        foreach ($data as $field => $value) {
            if (method_exists(Validator::class, $field)) {
                $err = Validator::$field($value);
                if ($err) $errors[$field] = $err;
            }
        }

        if ($errors) {
            Session::set("errors", $errors);
            Session::set("old_input", $_POST);
            header("Location: ../templates/form.php");
            exit;
        }

        $studentId = Student::create($data);
        StudentLanguage::setLanguages($studentId, $data['languages']);

        Session::set("data", $data);

        Redirect::to('../templates/view.php');
    }

    public static function update() {
        $id = intval($_POST['id']);

        $data = [
            "name" => $_POST['name'],
            "surname" => $_POST['surname'],
            "email" => $_POST['email'],
            "dob" => $_POST['dob'],
            "city" => $_POST['city'],
            "gender" => $_POST['gender'],
            "comment" => $_POST['comment']
        ];

        $adminErrors = [];
        
        foreach ($data as $field => $value) {
            if (method_exists(Validator::class, $field)) {
                $err = Validator::$field($value);
                if ($err) $adminErrors[$field] = $err;
            }
        }

        if ($adminErrors) {
            Session::set("adminErrors", $adminErrors);
            Redirect::to('../templates/admin_view.php');
        }

        Student::update($id, $data);
        StudentLanguage::setLanguages($id, array_map('intval', explode(",", $_POST['languages'])));

        Redirect::to('../templates/admin_dashboard.php');
    }

    public static function delete() {
        $id = intval($_POST["id"]);
        Student::delete($id);
        Redirect::to('../templates/admin_dashboard.php');
    }

    public static function exportToPDF(): void {
        $spreadsheet = self::buildSpreadsheet();
        $filename = 'students_' . date('Y-m-d_H-i') . '.pdf';

        header('Content-Type: application/pdf');
        header('Content-Disposition: attachment; filename="' . $filename . '"');
        header('Cache-Control: max-age=0');

        $writer = new Mpdf($spreadsheet);
        $writer->save('php://output');
        exit;
    }

    public static function exportToExcel(): void {
        $spreadsheet = self::buildSpreadsheet();
        $filename = 'students_' . date('Y-m-d_H-i') . '.xlsx';

        header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
        header('Content-Disposition: attachment; filename="' . $filename . '"');
        header('Cache-Control: max-age=0');

        $writer = new Xlsx($spreadsheet);
        $writer->save('php://output');
        exit;
    }

    private static function buildSpreadsheet(): Spreadsheet {
        $spreadsheet = new Spreadsheet();
        $sheet = $spreadsheet->getActiveSheet();
        $headers = ['ID', 'Vardas', 'Pavardė', 'El. paštas', 'Gimimo data', 'Miestas', 'Lytis', 'Kalbos', 'Komentaras'];
        $sheet->fromArray($headers, null, 'A1');
        $students = Student::all();
        $row = 2;

        foreach ($students as $student) {
            $sheet->fromArray([
                $student['student_id'] ?? '',
                $student['student_name'] ?? '',
                $student['student_surname'] ?? '',
                $student['student_email'] ?? '',
                $student['student_dob'] ?? '',
                $student['student_city'] ?? '',
                $student['student_gender'] ?? '',
                implode(',', $student['languages'] ?? []),
                $student['student_comment'] ?? '',
            ], null, "A{$row}");

            $row++;
        }

        return $spreadsheet;
    }
}
