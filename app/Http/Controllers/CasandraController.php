<?php

namespace App\Http\Controllers;

class CasandraController extends Controller
{
    /**
     * Enmascara correos electrónicos para mostrarlos de forma segura.
     *
     * @param  string  $input  El correo electrónico a proteger.
     * @param  string  $type  El tipo de dato (debe ser 'email').
     * @return string|null El correo enmascarado o null si es inválido.
     */
    public function maskSensitiveData(string $input, string $type): ?string
    {
        $input = trim($input);

        if (empty($input)) {
            return null;
        }

        switch ($type) {
            case 'email':
                if (! filter_var($input, FILTER_VALIDATE_EMAIL)) {
                    return null;
                }

                $parts = explode('@', $input);
                $name = $parts[0];
                $domain = $parts[1];

                $visibleCount = min(2, strlen($name) - 1);
                if ($visibleCount < 0) {
                    $visibleCount = 0;
                }

                $visiblePart = substr($name, 0, $visibleCount);
                $maskedPart = str_repeat('*', strlen($name) - $visibleCount);

                return $visiblePart.$maskedPart.'@'.$domain;

            default:
                return null;
        }
    }
}
