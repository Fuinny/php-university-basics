<?php
session_start();
if (!isset($_SESSION['loggedAsAdmin']) || $_SESSION['loggedAsAdmin'] !== true) {
    header('Location: ../index.php');
    exit;
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Administratorius</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.css" rel="stylesheet">
</head>
<body class="bg-light">
<div class="container text-center py-5">
    <h2 class="mb-5">Sveiki, administratoriau!</h2>
    <div class="row g-4 justify-content-center">
        <div class="col-md-4">
            <div class="card shadow-sm card-hover">
                <div class="card-body">
                    <i class="bi bi-table display-5 text-primary"></i>
                    <h4 class="mt-3">Peržiūrėti duomenis</h4>
                    <p class="text-muted">Peržiūrėkite ir redaguokite vartotojų sąrašą</p>
                    <a href="admin_view.php" class="btn btn-primary w-100">Atidaryti</a>
                </div>
            </div>
        </div>
        <div class="col-md-4">
            <div class="card shadow-sm card-hover">
                <div class="card-body">
                    <i class="bi bi-person-plus display-5 text-success"></i>
                    <h4 class="mt-3">Naujas vartotojas</h4>
                    <p class="text-muted">Įkelkite naują vartotoją į sistemą</p>
                    <a href="form.php" class="btn btn-success w-100">Pridėti</a>
                </div>
            </div>
        </div>
    </div>
    <div class="mt-5">
        <a href="../src/logout.php" class="btn btn-danger btn-lg px-5"><i class="bi bi-box-arrow-right"></i> Atsijungti</a>
    </div>
</div>
</body>
</html>