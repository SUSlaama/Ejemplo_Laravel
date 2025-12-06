<?php

namespace App\Http\Controllers;

class GabrielController extends Controller
{
    /**
     * Enmascara un número de tarjeta de crédito mostrando solo los últimos 4 dígitos.
     *
     * @param  string  $number  El número de tarjeta.
     * @return string|null El número enmascarado o null si es inválido.
     */
    public function maskCreditCard(string $number): ?string
    {
        // Eliminar todo lo que no sea dígito
        $digits = preg_replace('/\D/', '', $number);

        // Validar longitud (entre 13 y 19 dígitos)
        $length = strlen($digits);
        if ($length < 13 || $length > 19) {
            return null;
        }

        // Mostrar últimos 4, el resto asteriscos
        $visible = substr($digits, -4);
        $masked = str_repeat('*', $length - 4);

        return $masked.$visible;
    }
}
