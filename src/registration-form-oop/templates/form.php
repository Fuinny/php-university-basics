<?php
require __DIR__ . '/../src/bootstrap.php';

use Auth\Auth;
use Core\Redirect;
use Core\Session;

if (!Auth::isLoggedIn()) {
    Redirect::to('../index.php');
}

$errors = Session::flash('errors');
$oldInput = Session::flash('old_input');
?>
<!doctype html>
<html lang="lt">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/css/bootstrap.min.css" rel="stylesheet">
    <title>Registracijos Forma</title>
</head>
<body class="bg-white">
<div class="container mt-5">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h2 class="mb-0">Registracijos Forma</h2>
        <div class="d-flex gap-2">
            <?php if (Session::get('loggedAsAdmin', false)): ?>
                <a href="admin_dashboard.php" class="btn btn-danger">Atgal</a>
            <?php endif; ?>
            <a href="../src/logout.php" class="btn btn-danger">Atsijungti</a>
        </div>
    </div>
    <form action="../src/validation.php" method="post" class="p-4 bg-light rounded shadow-sm">
        <div class="mb-3">
            <label for="name" class="form-label">Vardas</label>
            <input
                type="text"
                id="name"
                name="name"
                class="form-control <?= isset($errors['name']) ? 'is-invalid' : '' ?>"
                value="<?= htmlspecialchars($oldInput['name'] ?? '') ?>"
                required
            >
            <div class="invalid-feedback"><?= $errors['name'] ?? '' ?></div>
        </div>
        <div class="mb-3">
            <label for="surname" class="form-label">Pavardė</label>
            <input
                type="text"
                id="surname"
                name="surname"
                class="form-control <?= isset($errors['surname']) ? 'is-invalid' : '' ?>"
                value="<?= htmlspecialchars($oldInput['surname'] ?? '') ?>"
                required
            >
            <div class="invalid-feedback"><?= $errors['surname'] ?? '' ?></div>
        </div>
        <div class="mb-3">
            <label for="email" class="form-label">El. Paštas</label>
            <input
                type="email"
                id="email"
                name="email"
                class="form-control <?= isset($errors['email']) ? 'is-invalid' : '' ?>"
                value="<?= htmlspecialchars($oldInput['email'] ?? '') ?>"
                required
            >
            <div class="invalid-feedback"><?= $errors['email'] ?? '' ?></div>
        </div>
        <div class="mb-3">
            <label for="dob" class="form-label">Gimimo Data</label>
            <input
                type="date"
                id="dob"
                name="dob"
                class="form-control <?= isset($errors['dob']) ? 'is-invalid' : '' ?>"
                value="<?= htmlspecialchars($oldInput['dob'] ?? '') ?>"
                required
            >
            <div class="invalid-feedback"><?= $errors['dob'] ?? '' ?></div>
        </div>
        <div class="mb-3">
            <label for="city" class="form-label">Miestas</label>
            <select
                id="city"
                name="city"
                class="form-select <?= isset($errors['city']) ? 'is-invalid' : '' ?>"
                required
            >
                <option value="none" <?= ($oldInput['city'] ?? '') === 'none' ? 'selected' : '' ?>>...</option>
                <option value="1" <?= ($oldInput['city'] ?? '') === '1' ? 'selected' : '' ?>>Vilnius</option>
                <option value="2" <?= ($oldInput['city'] ?? '') === '2' ? 'selected' : '' ?>>Kaunas</option>
                <option value="3" <?= ($oldInput['city'] ?? '') === '3' ? 'selected' : '' ?>>Klaipėda</option>
            </select>
            <div class="invalid-feedback"><?= $errors['city'] ?? '' ?></div>
        </div>
        <div class="mb-3">
            <label class="form-label d-block">Lytis</label>
            <div class="form-check form-check-inline">
                <input
                    class="form-check-input <?= isset($errors['gender']) ? 'is-invalid' : '' ?>"
                    type="radio"
                    id="male"
                    name="gender"
                    value="1"
                    <?= ($oldInput['gender'] ?? '') === '1' ? 'checked' : '' ?>
                >
                <label class="form-check-label" for="male">Vyras</label>
            </div>
            <div class="form-check form-check-inline">
                <input
                    class="form-check-input <?= isset($errors['gender']) ? 'is-invalid' : '' ?>"
                    type="radio"
                    id="female"
                    name="gender"
                    value="2"
                    <?= ($oldInput['gender'] ?? '') === '2' ? 'checked' : '' ?>
                >
                <label class="form-check-label" for="female">Moteris</label>
            </div>
            <div class="form-check form-check-inline">
                <input
                    class="form-check-input <?= isset($errors['gender']) ? 'is-invalid' : '' ?>"
                    type="radio"
                    id="other"
                    name="gender"
                    value="3"
                    <?= ($oldInput['gender'] ?? '') === '3' ? 'checked' : '' ?>
                >
                <label class="form-check-label" for="other">Kita</label>
            </div>
            <div class="invalid-feedback d-block"><?= $errors['gender'] ?? '' ?></div>
        </div>
        <div class="mb-3">
            <label class="form-label d-block">Kalbos</label>
            <div class="form-check form-check-inline">
                <input
                    class="form-check-input <?= isset($errors['languages']) ? 'is-invalid' : '' ?>"
                    type="checkbox"
                    id="english"
                    name="language[]"
                    value="1"
                    <?= isset($oldInput['language']) && in_array('1', $oldInput['language'], true) ? 'checked' : '' ?>
                >
                <label class="form-check-label" for="english">Anglų</label>
            </div>
            <div class="form-check form-check-inline">
                <input
                    class="form-check-input <?= isset($errors['languages']) ? 'is-invalid' : '' ?>"
                    type="checkbox"
                    id="lithuanian"
                    name="language[]"
                    value="2"
                    <?= isset($oldInput['language']) && in_array('2', $oldInput['language'], true) ? 'checked' : '' ?>
                >
                <label class="form-check-label" for="lithuanian">Lietuvių</label>
            </div>
            <div class="form-check form-check-inline">
                <input
                    class="form-check-input <?= isset($errors['languages']) ? 'is-invalid' : '' ?>"
                    type="checkbox"
                    id="russian"
                    name="language[]"
                    value="3"
                    <?= isset($oldInput['language']) && in_array('3', $oldInput['language'], true) ? 'checked' : '' ?>
                >
                <label class="form-check-label" for="russian">Rusų</label>
            </div>
            <div class="invalid-feedback d-block"><?= $errors['languages'] ?? '' ?></div>
        </div>
        <div class="mb-3">
            <label for="comment" class="form-label">Komentaras</label>
            <textarea
                id="comment"
                name="comment"
                rows="4"
                class="form-control"
                style="resize: none; overflow: scroll;"
            ><?= htmlspecialchars($oldInput['comment'] ?? '') ?></textarea>
            <div class="invalid-feedback d-block"><?= $errors['comment'] ?? '' ?></div>
        </div>
        <button type="submit" class="btn btn-primary w-100">Pateikti</button>
    </form>
</div>
</body>
</html>