<?php

namespace App\Http\Controllers;

class UrielController extends Controller
{
    /**
     * Anonimiza una dirección IPv4 ocultando el último octeto.
     *
     * @param  string  $ip  La dirección IP a proteger.
     * @return string|null La IP anonimizada o null si es inválida o no es IPv4.
     */
    public function anonymizeIp(string $ip): ?string
    {
        // Validar que sea una IP válida
        if (! filter_var($ip, FILTER_VALIDATE_IP)) {
            return null;
        }

        // Verificar que sea IPv4 (contiene 3 puntos)
        if (substr_count($ip, '.') !== 3) {
            return null;
        }

        $parts = explode('.', $ip);

        // Ocultar el último octeto
        $parts[3] = 'xxx';

        return implode('.', $parts);
    }
}
