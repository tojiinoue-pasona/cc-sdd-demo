<?php

namespace Database\Seeders;

use App\Models\Todo;
use Illuminate\Database\Seeder;

class TodoSeeder extends Seeder
{
    public function run(): void
    {
        Todo::insert([
            [
                'title'       => 'cc-sddの要件定義書を読む',
                'description' => null,
                'status'      => 'done',
                'created_at'  => now(),
                'updated_at'  => now(),
            ],
            [
                'title'       => '設計書を確認する',
                'description' => null,
                'status'      => 'in_progress',
                'created_at'  => now(),
                'updated_at'  => now(),
            ],
            [
                'title'       => 'タスクリストを実装する',
                'description' => null,
                'status'      => 'pending',
                'created_at'  => now(),
                'updated_at'  => now(),
            ],
        ]);
    }
}
