<?php

namespace App\Http\Controllers;

class FernandoController extends Controller
{
    /**
     * Enmascara un número telefónico mostrando solo los primeros 2
     * y los últimos 2 dígitos. El resto se sustituye con asteriscos.
     *
     * @param  string  $phone  El número telefónico a proteger.
     * @return string|null El número enmascarado o null si es inválido.
     */
    public function maskPhone(string $phone): ?string
    {
        $digits = preg_replace('/\D/', '', $phone);

        $length = strlen($digits);
        if ($length < 10 || $length > 12) {
            return null;
        }

        $start = substr($digits, 0, 2);
        $end = substr($digits, -2);

        $maskedLength = $length - 4;
        $masked = str_repeat('*', $maskedLength);

        return $start.$masked.$end;
    }
}
