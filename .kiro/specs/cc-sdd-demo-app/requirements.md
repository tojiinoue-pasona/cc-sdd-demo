# 要件定義書

## はじめに

本ドキュメントは、勉強会でcc-sdd（仕様駆動開発 / Spec-Driven Development）を体験するためのデモ用WebアプリケーションをPHP/Laravelで構築するための要件を定義します。

参加者はこのアプリを通じて「要件定義 → 設計 → タスク → 実装」というcc-sddのワークフローを実際に体験し、仕様駆動開発の価値と手順を理解できます。

アプリ自体はシンプルなTODO管理アプリとし、cc-sddのデモ素材として機能します。参加者はアプリの仕様書・設計書・タスクリストを閲覧しながら、cc-sddがどのように機能するかを学びます。

---

## 用語集

- **Demo_App**: 本デモ用WebアプリケーションのLaravelシステム全体
- **Todo**: タイトル・説明・ステータスを持つタスク単位
- **Todo_Manager**: TODOの作成・一覧・更新・削除を担うコンポーネント
- **Participant**: 勉強会の参加者（エンドユーザー）
- **Status**: Todoの状態。`pending`（未着手）・`in_progress`（進行中）・`done`（完了）の3値

---

## 要件

### 要件1: TODO一覧表示

**ユーザーストーリー:** 勉強会の参加者として、登録されたTODO一覧を確認したい。cc-sddのデモ素材として動くアプリを体験するため。

#### 受け入れ基準

1. THE Demo_App SHALL display a list of all Todos on the top page (`/todos`).
2. WHEN the Todos list is empty, THE Demo_App SHALL display a message indicating no Todos exist.
3. THE Demo_App SHALL display each Todo's title, status, and creation date in the list.
4. WHEN a Participant accesses `/`, THE Demo_App SHALL redirect the Participant to `/todos`.

---

### 要件2: TODO作成

**ユーザーストーリー:** 勉強会の参加者として、新しいTODOを作成したい。アプリの基本操作を体験するため。

#### 受け入れ基準

1. THE Demo_App SHALL provide a form to create a new Todo with a title (required, max 255 characters) and an optional description (max 1000 characters).
2. WHEN a Participant submits a valid creation form, THE Todo_Manager SHALL persist the new Todo with status `pending` and return the Participant to the Todo list.
3. IF a Participant submits a creation form with an empty title, THEN THE Demo_App SHALL display a validation error message and retain the entered values in the form.
4. IF a Participant submits a title exceeding 255 characters, THEN THE Demo_App SHALL display a validation error message indicating the maximum length.

---

### 要件3: TODOステータス更新

**ユーザーストーリー:** 勉強会の参加者として、TODOのステータスを変更したい。タスクの進捗を管理する操作を体験するため。

#### 受け入れ基準

1. THE Demo_App SHALL provide a status update control for each Todo in the list, allowing transitions to `pending`, `in_progress`, or `done`.
2. WHEN a Participant updates a Todo's status, THE Todo_Manager SHALL persist the new status and reload the Todo list reflecting the change.
3. IF a Participant submits an invalid status value, THEN THE Demo_App SHALL return a 422 response with a validation error message.

---

### 要件4: TODO削除

**ユーザーストーリー:** 勉強会の参加者として、不要なTODOを削除したい。CRUD操作の一通りを体験するため。

#### 受け入れ基準

1. THE Demo_App SHALL provide a delete action for each Todo in the list.
2. WHEN a Participant confirms deletion of a Todo, THE Todo_Manager SHALL remove the Todo from the database and reload the Todo list.
3. IF a Participant attempts to delete a Todo that does not exist, THEN THE Demo_App SHALL return a 404 response.

---

### 要件5: データ永続化

**ユーザーストーリー:** 勉強会の参加者として、作成したTODOがページリロード後も保持されることを期待する。アプリとして最低限の動作を確認するため。

#### 受け入れ基準

1. THE Demo_App SHALL persist all Todo data in a relational database using Laravel's Eloquent ORM.
2. THE Demo_App SHALL provide database migrations to create the required schema.
3. THE Demo_App SHALL provide database seeders to populate initial sample Todo data for demonstration purposes.
