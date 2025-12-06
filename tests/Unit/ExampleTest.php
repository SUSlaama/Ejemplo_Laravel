<?php

namespace Tests\Unit;

use App\Http\Controllers\CasandraController;
use App\Http\Controllers\DavidTest;
use App\Http\Controllers\GabrielController;
use App\Http\Controllers\OperationsController;
use App\Http\Controllers\UrielController;
use PHPUnit\Framework\TestCase;

class ExampleTest extends TestCase
{
    /**
     * A basic test example. Prueba que true sea true
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
}
