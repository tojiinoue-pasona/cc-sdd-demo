<?php

namespace Tests\Feature;

use App\Models\Todo;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Schema;
use Tests\TestCase;

class TodoFoundationTest extends TestCase
{
    use RefreshDatabase;

    /**
     * マイグレーション実行後に todos テーブルが存在することを確認
     * Validates: Requirements 5.2
     */
    public function test_migration_creates_todos_table(): void
    {
        $this->assertTrue(Schema::hasTable('todos'));
        $this->assertTrue(Schema::hasColumn('todos', 'id'));
        $this->assertTrue(Schema::hasColumn('todos', 'title'));
        $this->assertTrue(Schema::hasColumn('todos', 'description'));
        $this->assertTrue(Schema::hasColumn('todos', 'status'));
        $this->assertTrue(Schema::hasColumn('todos', 'created_at'));
        $this->assertTrue(Schema::hasColumn('todos', 'updated_at'));
    }

    /**
     * シーダー実行後にサンプルTodoが3件存在することを確認
     * Validates: Requirements 5.3
     */
    public function test_seeder_creates_sample_todos(): void
    {
        $this->seed(\Database\Seeders\TodoSeeder::class);

        $this->assertDatabaseCount('todos', 3);

        $this->assertDatabaseHas('todos', [
            'title'  => 'cc-sddの要件定義書を読む',
            'status' => 'done',
        ]);
        $this->assertDatabaseHas('todos', [
            'title'  => '設計書を確認する',
            'status' => 'in_progress',
        ]);
        $this->assertDatabaseHas('todos', [
            'title'  => 'タスクリストを実装する',
            'status' => 'pending',
        ]);
    }
}
