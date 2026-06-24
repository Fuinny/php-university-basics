<?php
namespace Core;

final class Redirect
{
    public static function to(string $path): never
    {
        header('Location: ' . $path);
        exit;
    }
}