<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Http\UploadedFile;
use Tests\TestCase;

class ExampleTest extends TestCase
{
    /**
     * A basic test example.
     *
     * @return void
     */
    public function testDominioRaizEstaAcessivelEEstaRetornandoViewCorreta()
    {
        $response = $this->get('/');
        $response->assertStatus(200)->assertViewIs('home');
    }

    public function testEstaRetornandoTodosOsResiduosNormalmente()
    {
        $response = $this->withHeaders([
            'Content-Type' => 'application/json',
        ])->get('api/v1/wastes');

        // $response->dump();

        $response->assertStatus(200)->assertJson([
            'status' => 200,
        ]);
    }

    public function testEstaInserindoOuAtualizandoUmNovoResiduoNormalmente()
    {
        $response = $this->withHeaders([
            'Content-Type' => 'multipart/form-data',
        ])->post('api/v1/wastes', [
            'spreadsheet' => UploadedFile::fake()->create('planilha_residuos.xlsx', 10000)
        ]);

        // $response->dump();

        $response->assertStatus(200)->assertJson([
            'status' => 200,
        ]);
    }

    public function testEstaRetornandoResiduoEspecificoNormalmente()
    {
        $response = $this->withHeaders([
            'Content-Type' => 'application/json',
        ])->get('api/v1/wastes/1592637713-5eedb911081c40.03322400-1592637713-10958788');

        // $response->dump();

        $response->assertStatus(200)->assertJson([
            'status' => 200,
        ]);
    }

    public function testEstaRemovendoUmResiduoNormalmente()
    {
        $response = $this->withHeaders([
            'Content-Type' => 'application/json',
        ])->delete('api/v1/wastes/2');

        $response->dump();

        $response->assertStatus(200)->assertJson([
            'status' => 200,
        ]);
    }
}
