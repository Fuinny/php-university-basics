<?php
require __DIR__ . '/bootstrap.php';

use Auth\Auth;
use Controllers\StudentController;

Auth::requireLoginAsAdmin('../index.php');

StudentController::delete();
