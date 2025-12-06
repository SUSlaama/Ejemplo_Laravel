<?php

namespace App\Http\Controllers;

class MarlonManuelController extends Controller
{
    /**
     * Valida RFC o CURP según el tipo indicado.
     *
     * @param string $input El texto a validar.
     * @param string $type  "rfc" o "curp".
     * @return bool|null True si es válido, false si es inválido, null si tipo desconocido.
     */
    public function validateId(string $input, string $type): ?bool
    {
        $input = trim($input);

        if (empty($input)) {
            return false;
        }

        switch (strtolower($type)) {

            case 'rfc':
                // Regex estándar para RFC (persona física y moral)
                return preg_match('/^[A-ZÑ&]{3,4}\d{6}[A-Z0-9]{3}$/i', $input) === 1;

            case 'curp':
                // Regex estándar para CURP mexicana
                return preg_match('/^[A-Z]{4}\d{6}[HM][A-Z]{5}[A-Z0-9]\d$/i', $input) === 1;

            default:
                return null;
        }
    }
}
