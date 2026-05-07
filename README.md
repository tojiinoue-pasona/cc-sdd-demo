# cc-sdd デモアプリ

勉強会で **cc-sdd（仕様駆動開発）** を体験するためのデモ用 TODO 管理アプリです。  
PHP 8.3 / Laravel 13.x / SQLite で動作します。

## 事前準備

[Docker Desktop](https://www.docker.com/products/docker-desktop/) をインストールしてください。

インストール確認：

```bash
docker -v  # Docker version 27.x.x などが表示されればOK
```

---

## セットアップ・起動

```bash
# 1. プロジェクトを置きたいディレクトリに移動してからクローン
cd ~/Documents  # 任意のディレクトリに移動
git clone https://github.com/tojiinoue-pasona/cc-sdd-demo.git
cd cc-sdd-demo

# 2. ビルドして起動（初回はイメージのビルドに数分かかります）
docker compose up
```

起動すると以下のような出力が表示されます：

```text
[+] Running 1/1
 ✔ Container cc-sdd-demo-app-1  Created
Attaching to cc-sdd-demo-app-1
...
   INFO  Server running on [http://0.0.0.0:8000].
```

ブラウザで <http://localhost:8000> にアクセスしてください。

終了するには `Ctrl+C` を押してください。

---

## コードを修正した後の再起動

コードを修正したら、以下のコマンドでイメージを再ビルドして起動します：

```bash
docker compose up --build
```

---

## テスト実行

```bash
docker compose run --rm app php artisan test
```

成功すると以下のような出力が表示されます：

```text
   PASS  Tests\Unit\ExampleTest
   PASS  Tests\Feature\ExampleTest
   PASS  Tests\Feature\TodoFoundationTest

  Tests:    4 passed (13 assertions)
```

---

## トラブルシューティング

### `docker compose up` でエラーが出る場合

Docker Desktop が起動しているか確認してください。タスクバー（Windows）またはメニューバー（macOS）に Docker のアイコンが表示されていれば起動しています。

### ポート 8000 が使用中というエラーが出る場合

他のアプリが 8000 番ポートを使っています。`compose.yml` の `ports` を変更してください：

```yaml
ports:
  - "8080:8000"  # 左側の数字を変える
```

その後 <http://localhost:8080> にアクセスしてください。
