<?php
namespace Validation;

class Validator {

    public static function name($name): ?string{
        $name = trim($name);

        if ($name == "") {
            return "Vardas negali būti tuščias!";
        }

        if (!preg_match("/^[\p{L}\s]+$/u", $name)) {
            return "Netinkami simboliai varde!";
        }

        return null;
    }

    public static function surname($surname): ?string {
        $surname = trim($surname);

        if ($surname == "") {
            return "Pavardė negali būti tuščia!";
        }

        if (!preg_match("/^[\p{L}\s]+$/u", $surname)) {
            return "Netinkami simboliai pavardėje!";
        }

        return null;
    }

    public static function email($email): ?string {
        if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
            return "Blogas el. paštas!";
        }

        return null;
    }

    public static function dob($dob): ?string {
        if (!$dob) {
            return "Įveskite datą!";
        }

        $parsed = date_parse($dob);

        if (!checkdate($parsed['month'], $parsed['day'], $parsed['year'])) {
            return "Neteisinga data!";
        }

        return null;
    }

    public static function city($city): ?string {
        if (!in_array($city, ["1", "2", "3"])) {
            return "Neteisingas miestas!";
        }

        return null;
    }

    public static function gender($gender): ?string {
        if (!in_array($gender, ["1","2","3"])) {
            return "Neteisinga lytis!";
        }

        return null;
    }

    public static function languages($langs): ?string {
        if (!is_array($langs) || empty($langs)) {
            return "Pasirinkite kalbą!";
        }

        return null;
    }

    public static function comment($text): ?string {
        if (strlen($text) > 1000) {
            return "Komentaras per ilgas!";
        }

        return null;
    }
}
