@extends('layouts.app')

@section('title', 'Todo作成 - cc-sdd Demo')

@section('content')
<div class="mb-6">
    <h1 class="text-2xl font-bold text-gray-800">新しいTodoを作成</h1>
</div>

<div class="bg-white rounded shadow p-6">
    <form action="/todos" method="POST" class="space-y-5">
        @csrf

        <div>
            <label for="title" class="block text-sm font-medium text-gray-700 mb-1">
                タイトル <span class="text-red-500">*</span>
            </label>
            <input
                type="text"
                id="title"
                name="title"
                value="{{ old('title') }}"
                maxlength="255"
                class="w-full border border-gray-300 rounded px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-blue-400 @error('title') border-red-500 @enderror"
            >
            @error('title')
                <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
            @enderror
        </div>

        <div>
            <label for="description" class="block text-sm font-medium text-gray-700 mb-1">
                説明（任意）
            </label>
            <textarea
                id="description"
                name="description"
                rows="4"
                maxlength="1000"
                class="w-full border border-gray-300 rounded px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-blue-400 @error('description') border-red-500 @enderror"
            >{{ old('description') }}</textarea>
            @error('description')
                <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
            @enderror
        </div>

        <div class="flex items-center gap-4">
            <button type="submit" class="bg-blue-600 text-white px-5 py-2 rounded hover:bg-blue-700 text-sm">
                作成する
            </button>
            <a href="/todos" class="text-sm text-gray-500 hover:text-gray-700">一覧に戻る</a>
        </div>
    </form>
</div>
@endsection
