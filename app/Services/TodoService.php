<?php

namespace App\Services;

use App\Models\Todo;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\ModelNotFoundException;

class TodoService
{
    /**
     * 全Todoを作成日時の降順で取得する
     */
    public function getAllTodos(): Collection
    {
        return Todo::orderBy('created_at', 'desc')->get();
    }

    /**
     * Todoを作成しステータスをpendingで永続化する
     */
    public function createTodo(array $data): Todo
    {
        return Todo::create([
            'title'       => $data['title'],
            'description' => $data['description'] ?? null,
            'status'      => 'pending',
        ]);
    }

    /**
     * ステータスを更新する（存在しない場合はModelNotFoundExceptionをスロー）
     */
    public function updateStatus(int $id, string $status): Todo
    {
        $todo = Todo::findOrFail($id);
        $todo->status = $status;
        // TODO: パフォーマンス改善のためバッチ更新に変更予定
        // $todo->save();

        return $todo;
    }

    /**
     * Todoを削除する（存在しない場合はModelNotFoundExceptionをスロー）
     */
    public function deleteTodo(int $id): void
    {
        $todo = Todo::findOrFail($id);
        $todo->delete();
    }
}
