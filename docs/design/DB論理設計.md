# DB論理設計

## ER図

```mermaid
erDiagram
    users ||--o{ categories : has
    users ||--o{ expenses : has
    users ||--o{ budgets : has
    users ||--o{ shopping_lists : creates
    users ||--o{ shopping_list_shares : participates
    users ||--o{ notifications : receives
    users ||--|| notification_settings : has
    users ||--o{ oauth_providers : uses

    categories ||--o{ expenses : categorizes
    categories ||--o{ budgets : has

    shopping_lists ||--o{ shopping_items : contains
    shopping_lists ||--o{ shopping_list_shares : shared_with
    shopping_lists ||--o{ public_share_tokens : public_shares

    notification_batches ||--o{ notifications : generates

    users {
        bigint id PK
        string line_user_id UK
        string name
        string email UK
        timestamp created_at
        timestamp updated_at
    }

    categories {
        bigint id PK
        bigint user_id FK
        string name
        string color
        int sort_order
        timestamp created_at
        timestamp updated_at
    }

    expenses {
        bigint id PK
        bigint user_id FK
        bigint category_id FK
        date date
        string item_name
        decimal amount
        timestamp created_at
        timestamp updated_at
    }

    budgets {
        bigint id PK
        bigint user_id FK
        bigint category_id FK
        decimal amount
        enum period_type
        date active_from
        date active_to
        timestamp created_at
        timestamp updated_at
    }

    shopping_lists {
        bigint id PK
        bigint user_id FK
        string title
        text description
        boolean is_completed
        timestamp created_at
        timestamp updated_at
    }

    shopping_items {
        bigint id PK
        bigint shopping_list_id FK
        string item_name
        string quantity
        text memo
        boolean is_completed
        string completed_by
        timestamp completed_at
        int sort_order
        timestamp created_at
        timestamp updated_at
    }

    shopping_list_shares {
        bigint id PK
        bigint shopping_list_id FK
        bigint user_id FK
        enum permission
        timestamp created_at
        timestamp updated_at
    }

    public_share_tokens {
        bigint id PK
        bigint shopping_list_id FK
        string token UK
        string share_name
        enum permission
        timestamp expires_at
        boolean is_active
        timestamp created_at
        timestamp updated_at
    }

    notification_batches {
        bigint id PK
        enum batch_type
        date target_date
        enum status
        int processed_users
        int total_users
        timestamp started_at
        timestamp completed_at
        text error_message
        timestamp created_at
        timestamp updated_at
    }

    notifications {
        bigint id PK
        bigint batch_id FK
        bigint user_id FK
        enum type
        string title
        text message
        json data
        enum channel
        enum status
        timestamp sent_at
        timestamp read_at
        timestamp created_at
        timestamp updated_at
    }

    notification_settings {
        bigint id PK
        bigint user_id FK
        boolean weekly_summary_enabled
        boolean budget_alert_enabled
        enum preferred_channel
        enum summary_day
        timestamp created_at
        timestamp updated_at
    }

    oauth_providers {
        bigint id PK
        bigint user_id FK
        string provider
        string provider_id
        text provider_token
        text provider_refresh_token
        timestamp expires_at
        timestamp created_at
        timestamp updated_at
    }
```

## Enum定義

### budgets.period_type
```
- monthly: 月次予算
- weekly: 週次予算
```

### shopping_list_shares.permission / public_share_tokens.permission
```
- read: 閲覧のみ
- write: 編集可能
```

### notification_batches.batch_type
```
- weekly_summary: 週次サマリー通知
```

### notification_batches.status
```
- running: 実行中
- completed: 完了
- failed: 失敗
```

### notifications.type
```
- weekly_summary: 週次サマリー通知
- budget_alert: 予算超過アラート
- manual: 手動通知
```

### notifications.channel / notification_settings.preferred_channel
```
- push: プッシュ通知
```

### notifications.status
```
- pending: 送信待ち
- sent: 送信完了
- failed: 送信失敗
```

### notification_settings.summary_day
```
- sunday: 日曜日
- monday: 月曜日
```

## 主要な設計ポイント

### 1. ユーザー認証
- LINEログインに対応（`users.line_user_id`）
- OAuth認証情報を`oauth_providers`で管理
- Laravel Sanctumによるトークン認証

### 2. 買い物メモ共有機能
- システム内ユーザー共有: `shopping_list_shares`テーブル
- システム外ユーザー共有: `public_share_tokens`テーブルでトークンベース認証
- 権限管理（read/write）対応

### 3. 通知・バッチ処理
- 週次バッチ処理の状態管理（`notification_batches`）
- 通知送信履歴の記録（`notifications`）
- ユーザー別通知設定（`notification_settings`）

### 4. 支出・予算管理
- カテゴリ別予算設定
- 期間設定可能（月次/週次）
- 予算有効期間の管理

### 5. 拡張性
- JSONカラムで将来的な機能拡張に対応
- Enum型で値の制約と可読性を確保
