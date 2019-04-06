<?php

namespace Tests\Unit;

use Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;

class ExampleTest extends TestCase
{
    /**
     * A basic test example.
     *
     * @return void
     */
    public function testBasicTest()
    {
        $this->assertTrue(true);
    }
    public function test_compra()
    {
        //inicio de sesion a la api
        $response = $this->post('/compra');
        $response->assertStatus(200);
       
    }
    public function test_respuesta()
    {
        //inicio de sesion a la api
        $response = $this->get('/compra/respuesta/{referencia}');
        $response->assertStatus(200);
       
    }
}
