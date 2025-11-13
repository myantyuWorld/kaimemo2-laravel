CREATE TABLE m_users (
    id BIGINT AUTO_INCREMENT NOT NULL COMMENT 'ユーザーID',
    line_user_id VARCHAR(255) COMMENT 'LINE ユーザーID',
    name VARCHAR(255) NOT NULL DEFAULT '' COMMENT 'ユーザー名',
    email VARCHAR(255) COMMENT 'メールアドレス',
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP COMMENT '作成日時',
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP COMMENT '更新日時',
    created_user_id BIGINT COMMENT '作成者ID',
    updated_user_id BIGINT COMMENT '更新者ID',
    program_code VARCHAR(50) COMMENT '処理プログラムコード',
    PRIMARY KEY (id)
) COMMENT 'ユーザー';

CREATE UNIQUE INDEX ui_m_users_line_user_id ON m_users (line_user_id);
CREATE UNIQUE INDEX ui_m_users_email ON m_users (email);

CREATE TABLE m_houses (
    id BIGINT AUTO_INCREMENT NOT NULL COMMENT '家ID',
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP COMMENT '作成日時',
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP COMMENT '更新日時',
    created_user_id BIGINT COMMENT '作成者ID',
    updated_user_id BIGINT COMMENT '更新者ID',
    program_code VARCHAR(50) COMMENT '処理プログラムコード',
    PRIMARY KEY (id)
) COMMENT '家';

CREATE TABLE m_categories (
    id BIGINT AUTO_INCREMENT NOT NULL COMMENT 'カテゴリID',
    house_id BIGINT NOT NULL COMMENT '家ID',
    name VARCHAR(255) NOT NULL DEFAULT '' COMMENT 'カテゴリ名',
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP COMMENT '作成日時',
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP COMMENT '更新日時',
    created_user_id BIGINT COMMENT '作成者ID',
    updated_user_id BIGINT COMMENT '更新者ID',
    program_code VARCHAR(50) COMMENT '処理プログラムコード',
    PRIMARY KEY (id)
) COMMENT 'カテゴリ';

CREATE INDEX i_m_categories_house_id ON m_categories (house_id);

CREATE TABLE t_expenses (
    id BIGINT AUTO_INCREMENT NOT NULL COMMENT '支出ID',
    house_id BIGINT NOT NULL COMMENT '家ID',
    expense_date DATE NOT NULL COMMENT '支出日',
    memo VARCHAR(1000) DEFAULT '' COMMENT 'メモ',
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP COMMENT '作成日時',
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP COMMENT '更新日時',
    created_user_id BIGINT COMMENT '作成者ID',
    updated_user_id BIGINT COMMENT '更新者ID',
    program_code VARCHAR(50) COMMENT '処理プログラムコード',
    PRIMARY KEY (id)
) COMMENT '支出';

CREATE INDEX i_t_expenses_house_id ON t_expenses (house_id);
CREATE INDEX i_t_expenses_expense_date ON t_expenses (expense_date);

CREATE TABLE t_expense_items (
    id BIGINT AUTO_INCREMENT NOT NULL COMMENT '支出明細ID',
    category_id BIGINT NOT NULL COMMENT 'カテゴリID',
    expense_id BIGINT NOT NULL COMMENT '支出ID',
    amount DECIMAL(10,2) NOT NULL COMMENT '支出金額',
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP COMMENT '作成日時',
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP COMMENT '更新日時',
    created_user_id BIGINT COMMENT '作成者ID',
    updated_user_id BIGINT COMMENT '更新者ID',
    program_code VARCHAR(50) COMMENT '処理プログラムコード',
    PRIMARY KEY (id)
) COMMENT '支出明細';

CREATE INDEX i_t_expense_items_expense_id ON t_expense_items (expense_id);
CREATE INDEX i_t_expense_items_category_id ON t_expense_items (category_id);

CREATE TABLE m_budgets (
    id BIGINT AUTO_INCREMENT NOT NULL COMMENT '予算ID',
    house_id BIGINT NOT NULL COMMENT '家ID',
    category_id BIGINT NOT NULL COMMENT 'カテゴリID',
    amount DECIMAL(10,2) NOT NULL COMMENT '予算金額',
    period_type ENUM('monthly', 'weekly', 'daily') NOT NULL COMMENT '期間タイプ（monthly=月次、weekly=週次、daily=日次）',
    active_from DATE NOT NULL COMMENT '有効期間開始日',
    active_to DATE COMMENT '有効期間終了日',
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP COMMENT '作成日時',
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP COMMENT '更新日時',
    created_user_id BIGINT COMMENT '作成者ID',
    updated_user_id BIGINT COMMENT '更新者ID',
    program_code VARCHAR(50) COMMENT '処理プログラムコード',
    PRIMARY KEY (id)
) COMMENT '予算';

CREATE INDEX i_m_budgets_house_id ON m_budgets (house_id);
CREATE INDEX i_m_budgets_category_id ON m_budgets (category_id);
CREATE INDEX i_m_budgets_period ON m_budgets (active_from, active_to);

CREATE TABLE t_shopping_lists (
    id BIGINT AUTO_INCREMENT NOT NULL COMMENT '買い物リストID',
    house_id BIGINT NOT NULL COMMENT '家ID',
    title VARCHAR(255) NOT NULL DEFAULT '' COMMENT 'タイトル',
    description VARCHAR(1000) DEFAULT '' COMMENT '説明',
    is_completed BOOLEAN NOT NULL DEFAULT false COMMENT '完了フラグ',
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP COMMENT '作成日時',
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP COMMENT '更新日時',
    created_user_id BIGINT COMMENT '作成者ID',
    updated_user_id BIGINT COMMENT '更新者ID',
    program_code VARCHAR(50) COMMENT '処理プログラムコード',
    PRIMARY KEY (id)
) COMMENT '買い物リスト';

CREATE INDEX i_t_shopping_lists_house_id ON t_shopping_lists (house_id);

CREATE TABLE t_notifications (
    id BIGINT AUTO_INCREMENT NOT NULL COMMENT '通知ID',
    house_id BIGINT NOT NULL COMMENT '家ID',
    notification_type ENUM('budget_alert', 'weekly_summary', 'expense_reminder') NOT NULL COMMENT
'通知タイプ（budget_alert=予算アラート、weekly_summary=週次サマリー、expense_reminder=支出リマインダー）',
    title VARCHAR(255) NOT NULL DEFAULT '' COMMENT '通知タイトル',
    message VARCHAR(1000) NOT NULL DEFAULT '' COMMENT '通知メッセージ',
    notification_data JSON COMMENT '追加データ（JSON形式）',
    notification_channel ENUM('push', 'email', 'line') NOT NULL DEFAULT 'push' COMMENT '通知チャンネル（push=プッシュ通知、email=メール、line=LINE）',
    notification_status ENUM('pending', 'sent', 'failed') NOT NULL DEFAULT 'pending' COMMENT '送信ステータス（pending=送信待ち、sent=送信済み、failed=送信失敗）',
    sent_at TIMESTAMP COMMENT '送信日時',
    read_at TIMESTAMP COMMENT '既読日時',
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP COMMENT '作成日時',
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP COMMENT '更新日時',
    created_user_id BIGINT COMMENT '作成者ID',
    updated_user_id BIGINT COMMENT '更新者ID',
    program_code VARCHAR(50) COMMENT '処理プログラムコード',
    PRIMARY KEY (id)
) COMMENT '通知';

CREATE INDEX i_t_notifications_house_id ON t_notifications (house_id);
CREATE INDEX i_t_notifications_status ON t_notifications (notification_status);

CREATE TABLE m_notification_settings (
    id BIGINT AUTO_INCREMENT NOT NULL COMMENT '通知設定ID',
    house_id BIGINT NOT NULL COMMENT '家ID',
    weekly_summary_enabled BOOLEAN NOT NULL DEFAULT true COMMENT '週次サマリー通知有効フラグ',
    budget_alert_enabled BOOLEAN NOT NULL DEFAULT true COMMENT '予算アラート通知有効フラグ',
    preferred_channel ENUM('push', 'email', 'line') NOT NULL DEFAULT 'push' COMMENT '優先通知チャンネル（push=プッシュ通知、email=メール、line=LINE）',
    summary_day ENUM('sunday', 'monday', 'tuesday', 'wednesday', 'thursday', 'friday', 'saturday') NOT NULL DEFAULT 'sunday' COMMENT 'サマリー送信曜日',
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP COMMENT '作成日時',
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP COMMENT '更新日時',
    created_user_id BIGINT COMMENT '作成者ID',
    updated_user_id BIGINT COMMENT '更新者ID',
    program_code VARCHAR(50) COMMENT '処理プログラムコード',
    PRIMARY KEY (id)
) COMMENT '通知設定';

CREATE UNIQUE INDEX ui_m_notification_settings_house_id ON m_notification_settings (house_id);

CREATE TABLE t_house_relation (
    id BIGINT AUTO_INCREMENT NOT NULL COMMENT '家所属ID',
    user_id BIGINT NOT NULL COMMENT 'ユーザーID',
    house_id BIGINT NOT NULL COMMENT '家ID',
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP COMMENT '作成日時',
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP COMMENT '更新日時',
    created_user_id BIGINT COMMENT '作成者ID',
    updated_user_id BIGINT COMMENT '更新者ID',
    program_code VARCHAR(50) COMMENT '処理プログラムコード',
    PRIMARY KEY (id)
) COMMENT '家所属';

CREATE UNIQUE INDEX ui_t_house_relation_user_house ON t_house_relation (user_id, house_id);
CREATE INDEX i_t_house_relation_user_id ON t_house_relation (user_id);
CREATE INDEX i_t_house_relation_house_id ON t_house_relation (house_id);
