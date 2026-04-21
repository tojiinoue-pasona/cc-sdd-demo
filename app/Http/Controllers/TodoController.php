<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreTodoRequest;
use App\Http\Requests\UpdateTodoStatusRequest;
use App\Services\TodoService;
use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;

class TodoController extends Controller
{
    public function __construct(private TodoService $service) {}

    /**
     * GET /todos - Todo一覧表示
     */
    public function index(): View
    {
        $todos = $this->service->getAllTodos();

        return view('todos.index', compact('todos'));
    }

    /**
     * GET /todos/create - 作成フォーム表示
     */
    public function create(): View
    {
        return view('todos.create');
    }

    /**
     * POST /todos - Todo作成
     */
    public function store(StoreTodoRequest $request): RedirectResponse
    {
        $this->service->createTodo($request->validated());

        return redirect('/todos');
    }

    /**
     * PATCH /todos/{id}/status - ステータス更新
     */
    public function updateStatus(UpdateTodoStatusRequest $request, int $id): RedirectResponse
    {
        $this->service->updateStatus($id, $request->validated()['status']);

        return redirect('/todos');
    }

    /**
     * DELETE /todos/{id} - Todo削除
     */
    public function destroy(int $id): RedirectResponse
    {
        $this->service->deleteTodo($id);

        return redirect('/todos');
    }
}
