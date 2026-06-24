<?php
session_start();

if (!isset($_SESSION['logged']) || $_SESSION['logged'] !== true) {
    header('Location: ../index.php');
    exit;
}

if (empty($_SESSION['data'])) {
    header("Location: form.php");
    exit;
}

$data = $_SESSION['data'];
unset($_SESSION['data']);
?>
<!DOCTYPE html>
<html lang="lt">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/css/bootstrap.min.css" rel="stylesheet">
        <title>Pateikta informacija</title>
    </head>
    <body class="bg-white">
        <div class="container mt-5">
            <h2 class="mb-4 text-center">Pateikta informacija</h2>
            <div class="bg-light card">
                <div class="card-body">
                    <div class="list-group">
                        <div class="list-group-item">
                            <strong>Vardas:</strong> <?= htmlspecialchars($data['name']) ?>
                        </div>
                        <div class="list-group-item">
                            <strong>Pavardė:</strong> <?= htmlspecialchars($data['surname']) ?>
                        </div>
                        <div class="list-group-item">
                            <strong>El. Paštas:</strong> <?= htmlspecialchars($data['email']) ?>
                        </div>
                        <div class="list-group-item">
                            <strong>Gimimo Data:</strong> <?= htmlspecialchars($data['dob']) ?>
                        </div>
                        <div class="list-group-item">
                            <strong>Miestas:</strong> <?= htmlspecialchars($data['city']) ?>
                        </div>
                        <div class="list-group-item">
                            <strong>Lytis:</strong> <?= htmlspecialchars($data['gender']) ?>
                        </div>
                        <div class="list-group-item">
                            <strong>Kalbos:</strong> <?= htmlspecialchars(implode(", ", $data['languages'])) ?>
                        </div>
                        <div class="list-group-item">
                            <strong>Komentaras:</strong> <?= htmlspecialchars($data['comment']) ?>
                        </div>
                    </div>
                </div>
            </div>
            <div class="mt-4 text-center">
                <a class="btn btn-primary" href="../templates/form.php" role="button">Grįžti į pradžią</a>
            </div>
        </div>
    </body>
</html>