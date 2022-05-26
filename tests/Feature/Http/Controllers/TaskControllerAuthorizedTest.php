<?php

namespace Tests\Feature\Http\Controllers;

use App\Models\Task;
use App\Models\User;
use Database\Seeders\DatabaseSeeder;
use Illuminate\Support\Facades\Auth;
use Tests\TestCase;

class TaskControllerAuthorizedTest extends TestCase
{
    protected function setUp(): void
    {
        parent::setUp();

        $seeder = new DatabaseSeeder();
        $seeder->run();

        $user = User::factory()->create();
        Auth::login($user);

        Task::factory()
            ->state([
                'name' => 'testTask',
                'created_by_id' => $user,
                'status_id' => '1',
            ])
            ->create();

        Task::factory()
            ->state([
                'name' => 'foreignTask',
                'created_by_id' => User::factory()->create(),
                'status_id' => '1',
            ])
            ->create();
    }

    public function testShow(): void
    {
        $response = $this->get('/tasks/1');
        $response->assertOk();

        $response->assertSee('testTask');
    }

    public function testIndex(): void
    {
        $response = $this->get('/tasks/');
        $response->assertOk();

        $response->assertSee(__('views.buttons.delete'));
        $response->assertSee(__('views.buttons.edit'));
        $response->assertSee(__('views.buttons.create'));

        $response->assertSee('testTask');
    }

    public function testUpdate(): void
    {
        $response = $this->get('/tasks/1/edit');
        $response->assertOk();

        $this->patch('/tasks/1', [
            'name' => 'updatedTask',
            'status_id' => '1'
        ]);
        $response->assertOk();

        $task = Task::where('id', '1')->get()->first();
        $this->assertEquals('updatedTask', $task->name);
    }

    public function testUpdateForeignTask(): void
    {
        $response = $this->get('/tasks/2/edit');
        $response->assertOk();

        $this->patch('/tasks/2', [
            'name' => 'updatedForeignTask',
            'status_id' => '1'
        ]);
        $response->assertOk();

        $task = Task::where('id', '2')->get()->first();
        $this->assertEquals('updatedForeignTask', $task->name);
    }

    public function testCreate(): void
    {
        $response = $this->get('/tasks/create');
        $response->assertOk();

        $response = $this->post('/tasks/', [
            'name' => 'newTask',
            'status_id' => '1'
        ]);
        $response->assertRedirect(route('tasks.index'));

        $this->assertDatabaseHas('tasks', [
            'name' => 'newTask'
        ]);
    }

    public function testDelete(): void
    {
        $response = $this->delete('/tasks/1');
        $response->assertRedirect(route('tasks.index'));

        $this->assertDatabaseMissing('tasks', [
            'name' => 'task'
        ]);
    }

    public function testDeleteForeignTask(): void
    {
        $response = $this->delete('/tasks/2');
        $response->assertStatus(403);
    }
}
