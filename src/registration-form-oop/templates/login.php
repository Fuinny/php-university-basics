<?php
require __DIR__ . '/../src/bootstrap.php';

use Auth\Auth;
use Core\Redirect;

if (Auth::isLoggedIn()) {
    Redirect::to('form.php');
}

$login_error = Auth::getLoginError();
?>

<!DOCTYPE html>
<html lang="lt">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/css/bootstrap.min.css" rel="stylesheet">
    <title>Prisijungti</title>
</head>
<body class="bg-white">
    <div class="container mt-5" >
        <h2 class="mb-4 text-center">Sveiki!</h2>
        <form action="../src/auth.php" method="post" class="p-4 bg-light rounded shadow-sm">
            <?php if ($login_error): ?>
                <div class="alert alert-danger"><?=$login_error?></div>
            <?php endif; ?>
            <div class="mb-3">
                <label for="username" class="form-label">Vartotojo vardas</label>
                <input type="text" id="username" name="username" class="form-control" required>
            </div>
            <div class="mb-3">
                <label for="password" class="form-label">Slaptažodis</label>
                <input type="password" id="password" name="password" class="form-control" required>
            </div>
            <button type="submit" class="btn btn-primary w-100">Prisijungti</button>
        </form>
    </div>
</body>
</html>