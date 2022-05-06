<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;
use App\Models\User;
class UserFeatureTest extends TestCase
{
    use RefreshDatabase;
    /**
     * A basic feature test example.
     *
     * @return void
     */
    public function test_TodosLosUsuarios()
    {
        User::factory(100)->create();
        $response = $this->getJson('/api/v1/users');

        $response->assertStatus(200);
    }

    public function test_NuevoUsuario()
    {
        $response = $this->postJson('/api/v1/users/new', [
            'nombre' => 'beto',
            'apellido' => 'beto',
            'edad' => 24,
        ]);

        $response->assertStatus(201)
        ->assertExactJson([
            'usuarioCreado' => true,
        ]);
    }

    public function test_mostrarUsuario()
    {
        $user = User::factory()->create();
        $response = $this->getJson('api/v1/users/'.$user->id);

        $response->assertStatus(200)
        ->assertJsonStructure([
            'user' => [
                'nombre', 'apellido', 'edad',
            ],
        ]);
    }

    public function test_eliminarUsuario()
    {
        $user = User::factory()->create();
        $response = $this->deleteJson('api/v1/users/delete/'.$user->id);

        $this->assertModelMissing($user);

        $response->assertStatus(200)
        ->assertExactJson([
            'eliminado' => true,
        ]);
    }

    public function test_actualizarUsuario()
    {
        $user = User::factory()->create();

        $response = $this->putJson('api/v1/users/update/'.$user->id, [
            'nombre' => 'beto',
            'apellido' => 'beto',
            'edad' => 24,
        ]);

        $response->assertStatus(200)
        ->assertExactJson([
            'actualizado' => true,
        ]);
    }
}
