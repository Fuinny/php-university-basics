<?php
require __DIR__ . '/bootstrap.php';

use Auth\Auth;
use Controllers\StudentController;

Auth::requireLogin('../index.php');

StudentController::submitForm();