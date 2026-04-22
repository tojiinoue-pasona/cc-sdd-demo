# cc-sdd デモアプリ

勉強会で **cc-sdd（仕様駆動開発）** を体験するためのデモ用 TODO 管理アプリです。  
PHP 8.3 / Laravel 13.x / SQLite で動作します。

## 事前準備

### PHP 8.3 のインストール

**macOS**
```bash
# Homebrew がない場合は先にインストール
/bin/bash -c "$(curl -fsSL https://raw.githubusercontent.com/Homebrew/install/HEAD/install.sh)"

brew install php
```

**Windows**
```powershell
# winget を使う場合
winget install PHP.PHP.8.3

# または https://windows.php.net/download/ からインストーラーをダウンロード
```

**Ubuntu / Debian**
```bash
sudo apt update
sudo apt install php8.3 php8.3-sqlite3 php8.3-xml php8.3-curl php8.3-mbstring
```

インストール確認：
```bash
php -v  # 8.3以上が表示されればOK
```
```
PHP 8.3.x (cli) ...
```

---

### Composer のインストール

**macOS / Linux**
```bash
curl -sS https://getcomposer.org/installer | php
sudo mv composer.phar /usr/local/bin/composer
```

**Windows**
```
https://getcomposer.org/Composer-Setup.exe をダウンロードして実行
```

インストール確認：
```bash
composer -V
```
```
Composer version 2.x.x ...
```

---

## セットアップ

```bash
# 1. プロジェクトを置きたいディレクトリに移動してからクローン
cd ~/Documents  # 任意のディレクトリに移動
git clone https://github.com/tojiinoue-pasona/cc-sdd-demo.git
cd cc-sdd-demo

# 2. セットアップ（依存インストール・.env生成・DB作成・シーダー実行を一括で行います）
composer run setup
```

成功すると以下のような出力が表示されます：

```
Installing dependencies from lock file ...
...（省略）...
Generating optimized autoload files
> php artisan key:generate
   INFO  Application key set successfully.
> php artisan migrate --seed --force
   INFO  Running migrations.
  2026_xx_xx_create_todos_table .................. DONE
   INFO  Seeding database.
  Database\Seeders\TodoSeeder .................... DONE
```

```bash
# 3. 開発サーバー起動
php artisan serve
```

成功すると以下のような出力が表示されます：

```
   INFO  Server running on [http://127.0.0.1:8000].
```

ブラウザで http://localhost:8000 にアクセスしてください。

---

## テスト実行

```bash
php artisan test
```

成功すると以下のような出力が表示されます：

```
   PASS  Tests\Unit\ExampleTest
   PASS  Tests\Feature\ExampleTest
   PASS  Tests\Feature\TodoFoundationTest

  Tests:    4 passed (13 assertions)
```

---

## トラブルシューティング

**`could not find driver` エラーが出る場合**

PHP の SQLite 拡張が無効になっています。

```bash
# macOS
brew install php

# Ubuntu / Debian
sudo apt install php8.3-sqlite3

# Windows: php.ini の以下の行のコメントを外す
# extension=pdo_sqlite
# extension=sqlite3
```

**`APP_KEY` が未設定というエラーが出る場合**

```bash
php artisan key:generate
```

**マイグレーションエラーが出る場合**

```bash
touch database/database.sqlite
php artisan migrate --seed
```
