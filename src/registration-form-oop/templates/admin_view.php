<?php
require __DIR__ . '/../src/bootstrap.php';

use Core\Session;
use Auth\Auth;
use Models\Student;

Session::start();
Auth::requireLoginAsAdmin('../index.php');

$adminErrors = Session::flash('adminErrors');

$students = Student::all();
?>

<!DOCTYPE html>
<html lang="lt">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Student List</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="bg-light">
    <div class="container py-5">
        <?php if (!empty($adminErrors)): ?>
                <div class="alert alert-danger">
                    <div class="fw-bold mb-1">Nepavyko išsaugoti. Patikrinkite laukus:</div>
                    <ul class="mb-0">
                        <?php foreach ($adminErrors as $msg): ?>
                            <li><?= htmlspecialchars((string)$msg) ?></li>
                        <?php endforeach; ?>
                    </ul>
                </div>
        <?php endif; ?>
        <div class="d-flex justify-content-between align-items-center mb-4">
            <h2 class="mb-0">Studentų sąrašas</h2>
            <div class="d-flex gap-2">
                <a href="../src/export-pdf.php" class="btn btn-primary">PDF</a>
                <a href="../src/export-excel.php" class="btn btn-primary">Excel</a>
                <a href="admin_dashboard.php" class="btn btn-danger">Atgal</a>
            </div>
        </div>
        <?php if (!empty($students)): ?>
            <div class="table-responsive shadow-sm">
                <table class="table table-hover table-bordered align-middle bg-white">
                    <thead class="table-dark text-center">
                        <tr>
                            <th>ID</th>
                            <th>Vardas</th>
                            <th>Pavardė</th>
                            <th>El. Paštas</th>
                            <th>Gimimo Data</th>
                            <th>Miestas</th>
                            <th>Lytis</th>
                            <th>Kalbos</th>
                            <th>Komentaras</th>
                            <th colspan="2">Veiksmai</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach($students as $student): ?>
                            <tr>
                                <form action="../src/update.php" method="post">
                                    <input type="hidden" name="id" value="<?= $student['student_id'] ?>">
                                    <td class="text-center fw-bold"><?= $student['student_id'] ?></td>
                                    <td><input type="text" name="name" class="form-control" value="<?= htmlspecialchars($student['student_name']) ?>"></td>
                                    <td><input type="text" name="surname" class="form-control" value="<?= htmlspecialchars($student['student_surname']) ?>"></td>
                                    <td><input type="email" name="email" class="form-control" value="<?= htmlspecialchars($student['student_email']) ?>"></td>
                                    <td><input type="date" name="dob" class="form-control" value="<?= $student['student_dob'] ?>"></td>
                                    <td><input type="number" name="city" class="form-control" value="<?= $student['student_city'] ?>"></td>
                                    <td><input type="number" name="gender" class="form-control" value="<?= $student['student_gender'] ?>"></td>
                                    <td><input type="text" class="form-control" name="languages" value="<?= implode(',', $student['languages']) ?>"></td>
                                    <td><input type="text" name="comment" class="form-control" value="<?= htmlspecialchars($student['student_comment']) ?>"></td>
                                    <td><button class="btn btn-primary btn-sm px-3" type="submit">Išsaugoti</button></td>
                                </form>
                                <form action="../src/delete.php" method="post" onsubmit="return confirm('Ar tikrai norite ištrinti šį studentą?');">
                                    <input type="hidden" name="id" value="<?= $student['student_id'] ?>">
                                    <td><button class="btn btn-danger btn-sm px-3" type="submit">Ištrinti</button></td>
                                </form>
                            </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            </div>
        <?php else: ?>
            <div class="alert alert-info">Nerasta jokių studentų.</div>
        <?php endif; ?>
    </div>
</body>
</html>
