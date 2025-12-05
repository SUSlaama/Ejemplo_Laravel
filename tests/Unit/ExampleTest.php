<?php

namespace Tests\Unit;

use App\Http\Controllers\CasandraController;
use App\Http\Controllers\DavidTest;
use App\Http\Controllers\OperationsController;
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
}
