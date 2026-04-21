@extends('layouts.app')

@section('title', 'Todo一覧 - cc-sdd Demo')

@section('content')
<div class="flex items-center justify-between mb-6">
    <h1 class="text-2xl font-bold text-gray-800">Todo一覧</h1>
    <a href="/todos/create" class="bg-blue-600 text-white px-4 py-2 rounded hover:bg-blue-700 text-sm">
        新しいTodoを作成
    </a>
</div>

@if($todos->isEmpty())
    <p class="text-gray-500">Todoがありません</p>
@else
    <div class="space-y-4">
        @foreach($todos as $todo)
        <div class="bg-white rounded shadow p-4">
            <div class="flex items-start justify-between gap-4">
                <div class="flex-1 min-w-0">
                    <p class="font-semibold text-gray-800 break-words">{{ $todo->title }}</p>
                    <p class="text-xs text-gray-400 mt-1">{{ $todo->created_at->format('Y-m-d H:i') }}</p>
                </div>

                {{-- ステータス更新フォーム --}}
                <form action="/todos/{{ $todo->id }}/status" method="POST" class="flex items-center gap-2">
                    @csrf
                    @method('PATCH')
                    <select name="status" class="text-sm border border-gray-300 rounded px-2 py-1">
                        <option value="pending" @selected($todo->status->value === 'pending')>未着手</option>
                        <option value="in_progress" @selected($todo->status->value === 'in_progress')>進行中</option>
                        <option value="done" @selected($todo->status->value === 'done')>完了</option>
                    </select>
                    <button type="submit" class="text-sm bg-gray-200 hover:bg-gray-300 px-3 py-1 rounded">更新</button>
                </form>

                {{-- 削除フォーム --}}
                <form action="/todos/{{ $todo->id }}" method="POST">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="text-sm text-red-600 hover:text-red-800 px-2 py-1">削除</button>
                </form>
            </div>
        </div>
        @endforeach
    </div>
@endif
@endsection
