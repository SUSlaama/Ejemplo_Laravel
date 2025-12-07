<?php

namespace Tests\Unit;

use App\Http\Controllers\CasandraController;
use App\Http\Controllers\DavidTest;
use App\Http\Controllers\FernandoController;
use App\Http\Controllers\GabrielController;
use App\Http\Controllers\GerardoController;
use App\Http\Controllers\OperationsController;
use App\Http\Controllers\UrielController;
use PHPUnit\Framework\TestCase;

class ExampleTest extends TestCase
{
    /**
     * A basic test example.
     */
    public function test_that_true_is_true(): void
    {
        $this->assertTrue(true);
    }

    public function test_addition_result(): void
    {
        $controller = new OperationsController;
        $result = $controller->add(4, 9);
        $this->assertIsInt($result);
        $this->assertNotNull($result);
        $this->assertEquals(13, $result);
    }

    // Test David, validar contraseña segura
    public function test_validate_password(): void
    {
        $controller = new DavidTest;

        // Caso válido
        $valid = $controller->validatePassword('PaSSWORD123');
        $this->assertIsBool($valid);
        $this->assertNotNull($valid);
        $this->assertTrue($valid);
    }

    // CasandraController: Prueba para enmascarar correo electrónico
    public function test_mask_email_address(): void
    {
        $controller = new CasandraController;

        // Caso: Correo estándar
        $result = $controller->maskSensitiveData('usuario@dominio.com', 'email');

        $this->assertNotNull($result);
        $this->assertEquals('us*****@dominio.com', $result);
        $this->assertStringContainsString('*', $result);
    }

    // Prueba de validación de fallo (correo inválido)
    public function test_mask_returns_null_on_invalid_input(): void
    {
        $controller = new CasandraController;
        $result = $controller->maskSensitiveData('no-soy-un-correo', 'email');
        $this->assertNull($result);
    }

    // Prueba de anonimización de IP
    public function test_anonymize_ip(): void
    {
        $controller = new UrielController;

        // Caso: IP válida
        $result = $controller->anonymizeIp('192.168.1.100');
        $this->assertNotNull($result);
        $this->assertEquals('192.168.1.xxx', $result);

        // Caso: IP inválida
        $invalidResult = $controller->anonymizeIp('not-an-ip');
        $this->assertNull($invalidResult);
    }

    // Enmascarar tarjeta de crédito
    public function test_mask_credit_card(): void
    {
        $controller = new GabrielController;

        // Caso: Tarjeta válida
        $result = $controller->maskCreditCard('1234567812345678');
        $this->assertNotNull($result);
        $this->assertEquals('************5678', $result);

        // Caso: Tarjeta con espacios/guiones (los debe limpiar)
        $resultWithChars = $controller->maskCreditCard('1234-5678-1234-5678');
        $this->assertEquals('************5678', $resultWithChars);

        // Caso: Longitud inválida (muy corta)
        $invalidResult = $controller->maskCreditCard('123');
        $this->assertNull($invalidResult);
    }

    // Marlon Manuel: Validación de RFC y CURP
    public function test_validate_rfc_and_curp()
    {
        $controller = new \App\Http\Controllers\MarlonManuelController;

        // RFC válido
        $validRfc = $controller->validateId('GODE561231GR8', 'rfc');
        $this->assertTrue($validRfc);

        // RFC inválido
        $invalidRfc = $controller->validateId('INVALIDO123', 'rfc');
        $this->assertFalse($invalidRfc);

        // CURP válido
        $validCurp = $controller->validateId('GODE561231HDFRRN09', 'curp');
        $this->assertTrue($validCurp);

        // CURP inválido
        $invalidCurp = $controller->validateId('AAAA111111XXXXXX11', 'curp');
        $this->assertFalse($invalidCurp);

        // Tipo desconocido
        $unknown = $controller->validateId('ABC123', 'otro');
        $this->assertNull($unknown);
    }

    // Prueba FernandoController: enmascarar número telefónico
    public function test_mask_phone_number(): void
    {
        $controller = new \App\Http\Controllers\FernandoController;

        // Caso válido: 10 dígitos
        $result = $controller->maskPhone('4491838698');
        $this->assertNotNull($result);
        $this->assertEquals('44******98', $result);

        // Caso válido: con caracteres no numéricos
        $resultFormatted = $controller->maskPhone('(449) 183-8698');
        $this->assertEquals('44******98', $resultFormatted);

        // Caso inválido: muy corto
        $invalidShort = $controller->maskPhone('12345');
        $this->assertNull($invalidShort);

        // Caso inválido: muy largo
        $invalidLong = $controller->maskPhone('123456789012345');
        $this->assertNull($invalidLong);
    }

    // GerardoController: Prueba para sanitizar nombres de archivo
    public function test_sanitize_filename(): void
    {
        $controller = new GerardoController;

        // Caso: Nombre de archivo válido
        $result = $controller->sanitizeFilename('mi_archivo.pdf');
        $this->assertNotNull($result);
        $this->assertEquals('mi_archivo.pdf', $result);

        // Caso: Nombre con espacios
        $result2 = $controller->sanitizeFilename('documento final v2.txt');
        $this->assertEquals('documento final v2.txt', $result2);

        // Caso: Debe bloquear path traversal
        $dangerous = $controller->sanitizeFilename('../etc/passwd');
        $this->assertNull($dangerous);
    }

    // GerardoController: Prueba para validar extensiones de archivo
    public function test_validate_file_extension(): void
    {
        $controller = new GerardoController;

        // Caso: Extensiones válidas
        $validFiles = ['imagen.jpg', 'documento.pdf', 'foto.png'];

        foreach ($validFiles as $file) {
            $result = $controller->validateFileExtension($file);
            $this->assertTrue($result, "Falló para: $file");
        }

        // Caso: Extensiones peligrosas (deben ser rechazadas)
        $invalidFiles = ['malicioso.exe', 'script.php', 'shell.bat'];

        foreach ($invalidFiles as $file) {
            $result = $controller->validateFileExtension($file);
            $this->assertFalse($result, "Debería fallar para: $file");
        }
    }
}
