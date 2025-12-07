<?php

namespace App\Http\Controllers;

class GerardoController extends Controller
{
    /**
     * Sanitiza un nombre de archivo para prevenir path traversal.
     *
     * @param  string  $filename  Nombre del archivo a validar.
     * @return string|null Nombre sanitizado o null si es peligroso.
     */
    public function sanitizeFilename(string $filename): ?string
    {
        $filename = trim($filename);

        if (empty($filename)) {
            return null;
        }

        // Eliminar caracteres peligrosos para path traversal
        $dangerousPatterns = ['../', './', '..\\', '.\\', '/', '\\'];

        foreach ($dangerousPatterns as $pattern) {
            if (str_contains($filename, $pattern)) {
                return null;
            }
        }

        // Eliminar caracteres de control y mantener solo caracteres seguros
        $sanitized = preg_replace('/[^\w\s\-\.]/', '', $filename);
        $sanitized = trim($sanitized);

        // Longitud máxima razonable
        if (strlen($sanitized) > 255 || strlen($sanitized) === 0) {
            return null;
        }

        return $sanitized;
    }

    /**
     * Valida una extensión de archivo contra una lista blanca.
     *
     * @param  string  $filename  Nombre del archivo.
     * @return bool True si la extensión es segura.
     */
    public function validateFileExtension(string $filename): bool
    {
        // Lista blanca de extensiones seguras
        $allowed = ['jpg', 'jpeg', 'png', 'gif', 'pdf', 'txt', 'doc', 'docx', 'xls', 'xlsx'];

        $extension = strtolower(pathinfo($filename, PATHINFO_EXTENSION));

        return in_array($extension, $allowed);
    }
}