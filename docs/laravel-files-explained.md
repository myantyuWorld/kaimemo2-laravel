# Laravel ファイル解説（初心者向け）

Laravel プロジェクトの各ファイルと ディレクトリについて、初心者向けに分かりやすく解説します。

## 📁 プロジェクトのルートディレクトリ

### 🔧 設定ファイル
- **composer.json**: PHP の依存関係管理ファイル（package.json の PHP版）
- **.env**: 環境変数ファイル（データベース接続情報など）
- **.env.example**: .env ファイルのテンプレート
- **artisan**: Laravel のコマンドライン実行ファイル
- **phpunit.xml**: テスト設定ファイル

### 📂 主要ディレクトリ

## 🏗️ app/ ディレクトリ（アプリケーションのコア）

アプリケーションのメインロジックが格納されている最も重要なディレクトリです。

### app/Http/
- **Controllers/**: コントローラー（ビジネスロジックの制御）
  - リクエストを受け取り、適切な処理を行う
  - 例：UserController.php でユーザー管理
- **Middleware/**: ミドルウェア（リクエストの前処理）
  - 認証、CORS設定、ログ記録など
- **Requests/**: フォームリクエスト（バリデーション）
  - 入力データの検証ルール

### app/Models/
- **Eloquent モデル**: データベースとの橋渡し
  - User.php: ユーザーテーブルのモデル
  - リレーション、バリデーションルール等

### app/Providers/
- **サービスプロバイダー**: Laravel の機能拡張
  - AppServiceProvider.php: アプリケーション全般の設定
  - RouteServiceProvider.php: ルーティング設定

## 🗂️ config/ ディレクトリ（設定）

### 主要な設定ファイル
- **app.php**: アプリケーションの基本設定
- **database.php**: データベース接続設定
- **auth.php**: 認証設定
- **mail.php**: メール送信設定
- **cors.php**: CORS（クロスオリジン）設定

## 🛣️ routes/ ディレクトリ（ルーティング）

### ルートファイル
- **web.php**: ブラウザ向けルート（セッション、CSRF保護）
- **api.php**: API向けルート（JSON レスポンス）
- **console.php**: Artisan コマンド定義
- **channels.php**: ブロードキャストチャンネル

## 🗄️ database/ ディレクトリ（データベース）

### データベース関連ファイル
- **migrations/**: データベース構造の変更履歴
  - テーブル作成、カラム追加等のスクリプト
- **seeders/**: テストデータ投入
  - 初期データやダミーデータの生成
- **factories/**: モデルファクトリー
  - テスト用のデータ生成ルール

## 🎨 resources/ ディレクトリ（リソース）

### フロントエンド関連
- **views/**: Blade テンプレート（HTML）
  - レイアウト、コンポーネント
- **css/**: スタイルシート
- **js/**: JavaScript ファイル
- **lang/**: 多言語対応ファイル

## 🌐 public/ ディレクトリ（公開ファイル）

### Webサーバーの公開ディレクトリ
- **index.php**: Laravel のエントリーポイント
- **assets/**: CSS、JS、画像の最終出力先
- **.htaccess**: Apache の設定ファイル

## 📦 storage/ ディレクトリ（ストレージ）

### 保存領域
- **app/**: アプリケーションファイル
- **framework/**: Laravel フレームワークのキャッシュ
- **logs/**: エラーログ、アクセスログ

## 🧪 tests/ ディレクトリ（テスト）

### テストコード
- **Feature/**: 機能テスト（HTTP リクエストのテスト）
- **Unit/**: 単体テスト（個別クラスのテスト）

## 🏃‍♂️ よく使うコマンド

```bash
# 開発サーバー起動
php artisan serve

# マイグレーション実行
php artisan migrate

# コントローラー作成
php artisan make:controller UserController

# モデル作成
php artisan make:model User

# ルート一覧表示
php artisan route:list

# キャッシュクリア
php artisan cache:clear
```

## 🔄 Laravel のリクエストフロー

1. **public/index.php** でリクエスト受信
2. **routes/** でルーティング判定
3. **Middleware** で前処理
4. **Controller** でビジネスロジック実行
5. **Model** でデータベース操作
6. **View** でレスポンス生成
7. ユーザーへレスポンス返却

## 📝 初心者へのアドバイス

- **MVCパターン**を理解しよう
  - Model: データ管理
  - View: 表示
  - Controller: 制御

- **Artisanコマンド**を覚えよう
  - Laravel の開発を効率化

- **.env ファイル**は機密情報
  - Gitにコミットしない

- **マイグレーション**でDB管理
  - 手動でテーブル作成せず、マイグレーションを使う

このドキュメントで Laravel の基本的なファイル構造が理解できたでしょうか？何か質問があれば、お気軽にお尋ねください！