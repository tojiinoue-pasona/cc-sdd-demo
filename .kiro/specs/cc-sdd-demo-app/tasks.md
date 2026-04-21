# 実装計画: cc-sdd デモアプリ (PHP/Laravel)

## 概要

Laravel 11.x の MVC アーキテクチャに従い、TODO管理アプリを段階的に実装します。
データモデル → サービス層 → コントローラー → ビューの順に構築し、各ステップで動作を確認します。

## タスク

- [x] 1. プロジェクト基盤のセットアップ
  - `TodoStatus` Backed Enum を `app/Enums/TodoStatus.php` に作成する
  - `todos` テーブルのマイグレーションファイルを作成する（`database/migrations/`）
  - `Todo` Eloquent モデルを `app/Models/Todo.php` に作成し、`$fillable` と `$casts` を設定する
  - `TodoFactory` を `database/factories/TodoFactory.php` に作成する（テスト用）
  - `TodoSeeder` を `database/seeders/TodoSeeder.php` に作成し、3件のサンプルデータを定義する
  - `DatabaseSeeder` から `TodoSeeder` を呼び出すよう設定する
  - _Requirements: 5.1, 5.2, 5.3_

  - [ ]* 1.1 マイグレーションのユニットテストを書く
    - `test_migration_creates_todos_table`: マイグレーション実行後に `todos` テーブルが存在することを確認
    - `test_seeder_creates_sample_todos`: シーダー実行後にサンプルTodoが3件存在することを確認
    - _Requirements: 5.2, 5.3_

- [ ] 2. サービス層の実装
  - [x] 2.1 `TodoService` クラスを `app/Services/TodoService.php` に実装する
    - `getAllTodos(): Collection` — 全Todoを取得
    - `createTodo(array $data): Todo` — Todoを作成しステータスを `pending` で永続化
    - `updateStatus(int $id, string $status): Todo` — ステータスを更新（存在しない場合は `ModelNotFoundException`）
    - `deleteTodo(int $id): void` — Todoを削除（存在しない場合は `ModelNotFoundException`）
    - _Requirements: 2.2, 3.2, 4.2, 5.1_

  - [ ]* 2.2 Property 2 のプロパティテストを書く
    - **Property 2: 有効な入力でTodoを作成するとpendingステータスで永続化される**
    - **Validates: Requirements 2.2, 5.1**

  - [ ]* 2.3 Property 6 のプロパティテストを書く
    - **Property 6: Todo削除後はデータベースから除去される**
    - **Validates: Requirements 4.2**

  - [ ]* 2.4 Property 4 のプロパティテストを書く
    - **Property 4: ステータス更新は任意の有効なステータス値で永続化される**
    - **Validates: Requirements 3.2**

- [ ] 3. バリデーション・コントローラーの実装
  - [x] 3.1 `StoreTodoRequest` を `app/Http/Requests/StoreTodoRequest.php` に作成する
    - `title`: required, string, max:255
    - `description`: nullable, string, max:1000
    - _Requirements: 2.1, 2.3, 2.4_

  - [x] 3.2 `UpdateTodoStatusRequest` を `app/Http/Requests/UpdateTodoStatusRequest.php` に作成する
    - `status`: required, in:pending,in_progress,done
    - _Requirements: 3.1, 3.3_

  - [x] 3.3 `TodoController` を `app/Http/Controllers/TodoController.php` に実装する
    - `index()`: Todo一覧を取得してビューに渡す
    - `create()`: 作成フォームビューを返す
    - `store(StoreTodoRequest $request)`: Todo作成後に `/todos` へリダイレクト
    - `updateStatus(UpdateTodoStatusRequest $request, int $id)`: ステータス更新後に `/todos` へリダイレクト
    - `destroy(int $id)`: Todo削除後に `/todos` へリダイレクト
    - _Requirements: 1.1, 2.2, 3.2, 4.2_

  - [x] 3.4 `routes/web.php` にルーティングを定義する
    - `GET /` → `/todos` へリダイレクト
    - `GET /todos` → `TodoController@index`
    - `GET /todos/create` → `TodoController@create`
    - `POST /todos` → `TodoController@store`
    - `PATCH /todos/{id}/status` → `TodoController@updateStatus`
    - `DELETE /todos/{id}` → `TodoController@destroy`
    - _Requirements: 1.4_

  - [ ]* 3.5 バリデーションのユニットテストを書く
    - `test_title_over_255_chars_fails_validation`: 256文字以上のタイトルで422エラー
    - `test_root_redirects_to_todos`: `/` へのアクセスが `/todos` にリダイレクト
    - _Requirements: 2.4, 1.4_

  - [ ]* 3.6 Property 3 のプロパティテストを書く
    - **Property 3: 空またはホワイトスペースのみのタイトルはバリデーションエラーになる**
    - **Validates: Requirements 2.3**

  - [ ]* 3.7 Property 5 のプロパティテストを書く
    - **Property 5: 無効なステータス値は422エラーを返す**
    - **Validates: Requirements 3.3**

- [x] 4. チェックポイント — 全テストがパスすることを確認する
  - 全テストがパスすることを確認する。疑問点があればユーザーに確認する。

- [ ] 5. Bladeビューの実装
  - [x] 5.1 共通レイアウト `resources/views/layouts/app.blade.php` を作成する
    - Tailwind CSS（CDN経由）を読み込む
    - `@yield('content')` でコンテンツ領域を定義する
    - _Requirements: 1.1_

  - [x] 5.2 Todo一覧ビュー `resources/views/todos/index.blade.php` を作成する
    - 全Todoのタイトル・ステータス・作成日時を表示する
    - Todo件数が0件の場合は「Todoがありません」等のメッセージを表示する
    - 各Todoにステータス更新フォーム（`PATCH /todos/{id}/status`）を設置する
    - 各Todoに削除フォーム（`DELETE /todos/{id}`）を設置する
    - 作成フォームへのリンクを設置する
    - _Requirements: 1.1, 1.2, 1.3, 3.1, 4.1_

  - [x] 5.3 Todo作成フォームビュー `resources/views/todos/create.blade.php` を作成する
    - `title`（必須）と `description`（任意）の入力フィールドを設置する
    - `@error` ディレクティブでバリデーションエラーを表示する
    - `old()` ヘルパーで入力値を保持する
    - _Requirements: 2.1, 2.3_

  - [ ]* 5.4 ビューのユニットテストを書く
    - `test_empty_todo_list_shows_message`: Todo0件時の空メッセージ表示
    - `test_create_form_has_required_fields`: 作成フォームに `title`・`description` フィールドが存在
    - `test_delete_nonexistent_todo_returns_404`: 存在しないTodo削除で404
    - _Requirements: 1.2, 2.1, 4.3_

  - [ ]* 5.5 Property 1 のプロパティテストを書く
    - **Property 1: Todo一覧には各Todoの必須情報が含まれる**
    - **Validates: Requirements 1.1, 1.3**

  - [ ]* 5.6 Property 7 のプロパティテストを書く
    - **Property 7: 一覧画面には各Todoのステータス更新コントロールと削除アクションが存在する**
    - **Validates: Requirements 3.1, 4.1**

- [x] 6. 最終チェックポイント — 全テストがパスすることを確認する
  - 全テストがパスすることを確認する。疑問点があればユーザーに確認する。

## Notes

- `*` が付いたサブタスクはオプションです。MVPを優先する場合はスキップ可能です
- プロパティテストには `eris` ライブラリを使用します（`composer require --dev giorgiosironi/eris`）
- 各タスクは要件番号でトレーサビリティを確保しています
- チェックポイントで段階的な動作確認を行います
