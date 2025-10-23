LaravelとVueでプッシュ通知を実装する手順を説明します。

## 全体の流れ

1. **EventBridge → Laravel（バッチ処理）**
2. **Laravel → プッシュ通知サービス → Vue（フロントエンド）**

## 実装ステップ

### 1. Laravelでプッシュ通知の準備

**Web Push通知を使う場合（推奨）**

```bash
composer require laravel-notification-channels/webpush
php artisan vendor:publish --provider="NotificationChannels\WebPush\WebPushServiceProvider"
php artisan migrate
```

### 2. Laravelでコマンド作成

```bash
php artisan make:command SendScheduledNotifications
```

`app/Console/Commands/SendScheduledNotifications.php`:
```php
<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\User;
use App\Notifications\ScheduledPushNotification;

class SendScheduledNotifications extends Command
{
    protected $signature = 'notifications:send-scheduled';
    protected $description = 'Send scheduled push notifications';

    public function handle()
    {
        // 通知対象のユーザーを取得
        $users = User::where('notify_enabled', true)->get();

        foreach ($users as $user) {
            $user->notify(new ScheduledPushNotification([
                'title' => '定期通知',
                'body' => 'これは定期的な通知です',
            ]));
        }

        $this->info('Notifications sent successfully!');
    }
}
```

### 3. 通知クラスを作成

```bash
php artisan make:notification ScheduledPushNotification
```

`app/Notifications/ScheduledPushNotification.php`:
```php
<?php

namespace App\Notifications;

use Illuminate\Notifications\Notification;
use NotificationChannels\WebPush\WebPushMessage;
use NotificationChannels\WebPush\WebPushChannel;

class ScheduledPushNotification extends Notification
{
    private $data;

    public function __construct($data)
    {
        $this->data = $data;
    }

    public function via($notifiable)
    {
        return [WebPushChannel::class];
    }

    public function toWebPush($notifiable, $notification)
    {
        return (new WebPushMessage)
            ->title($this->data['title'])
            ->body($this->data['body'])
            ->icon('/icon.png')
            ->badge('/badge.png')
            ->data(['url' => '/notifications']);
    }
}
```

### 4. Userモデルに追加

`app/Models/User.php`:
```php
<?php

namespace App\Models;

use Illuminate\Foundation\Auth\User as Authenticatable;
use NotificationChannels\WebPush\HasPushSubscriptions;

class User extends Authenticatable
{
    use HasPushSubscriptions;

    // ... 既存のコード
}
```

### 5. Vue側の実装

**Service Workerを登録**

`public/service-worker.js`:
```javascript
self.addEventListener('push', function(event) {
    const data = event.data.json();
    
    const options = {
        body: data.body,
        icon: data.icon || '/icon.png',
        badge: data.badge || '/badge.png',
        data: data.data
    };

    event.waitUntil(
        self.registration.showNotification(data.title, options)
    );
});

self.addEventListener('notificationclick', function(event) {
    event.notification.close();
    
    event.waitUntil(
        clients.openWindow(event.notification.data.url || '/')
    );
});
```

**Vue側でService Workerとプッシュ通知を登録**

`src/composables/usePushNotifications.js`:
```javascript
import { ref } from 'vue';
import axios from 'axios';

export function usePushNotifications() {
    const isSupported = ref('serviceWorker' in navigator && 'PushManager' in window);
    const isSubscribed = ref(false);

    const urlBase64ToUint8Array = (base64String) => {
        const padding = '='.repeat((4 - base64String.length % 4) % 4);
        const base64 = (base64String + padding)
            .replace(/\-/g, '+')
            .replace(/_/g, '/');

        const rawData = window.atob(base64);
        const outputArray = new Uint8Array(rawData.length);

        for (let i = 0; i < rawData.length; ++i) {
            outputArray[i] = rawData.charCodeAt(i);
        }
        return outputArray;
    };

    const subscribe = async () => {
        if (!isSupported.value) {
            console.error('Push notifications are not supported');
            return;
        }

        try {
            // Service Workerを登録
            const registration = await navigator.serviceWorker.register('/service-worker.js');
            
            // 通知の許可を求める
            const permission = await Notification.requestPermission();
            if (permission !== 'granted') {
                console.error('Permission not granted');
                return;
            }

            // VAPID公開鍵を取得（Laravelから）
            const response = await axios.get('/api/webpush/vapid-public-key');
            const vapidPublicKey = response.data.publicKey;

            // プッシュ通知を購読
            const subscription = await registration.pushManager.subscribe({
                userVisibleOnly: true,
                applicationServerKey: urlBase64ToUint8Array(vapidPublicKey)
            });

            // サブスクリプションをLaravelに送信
            await axios.post('/api/webpush/subscribe', {
                subscription: subscription.toJSON()
            });

            isSubscribed.value = true;
            console.log('Push notification subscribed');
        } catch (error) {
            console.error('Error subscribing to push notifications:', error);
        }
    };

    return {
        isSupported,
        isSubscribed,
        subscribe
    };
}
```

**Vueコンポーネントで使用**

```vue
<template>
  <div>
    <button 
      v-if="isSupported && !isSubscribed" 
      @click="subscribe"
    >
      プッシュ通知を有効にする
    </button>
  </div>
</template>

<script setup>
import { usePushNotifications } from '@/composables/usePushNotifications';

const { isSupported, isSubscribed, subscribe } = usePushNotifications();
</script>
```

### 6. LaravelのAPIルート追加

`routes/api.php`:
```php
<?php

use Illuminate\Support\Facades\Route;

Route::middleware('auth:sanctum')->group(function () {
    Route::get('/webpush/vapid-public-key', function () {
        return response()->json([
            'publicKey' => config('webpush.vapid.public_key')
        ]);
    });

    Route::post('/webpush/subscribe', function (Request $request) {
        $request->user()->updatePushSubscription(
            $request->input('subscription.endpoint'),
            $request->input('subscription.keys.p256dh'),
            $request->input('subscription.keys.auth')
        );

        return response()->json(['success' => true]);
    });
});
```

### 7. VAPID鍵を生成

```bash
php artisan webpush:vapid
```

`.env`に追加される鍵を確認してください。

### 8. EventBridgeの設定

**AWS EventBridge側で以下を設定:**

1. ルールを作成（cron式で定期実行）
   - 例: `cron(0 9 * * ? *)` （毎日9時）

2. ターゲットを設定
   - ECS Task / Lambda / EC2など、Laravelが動作する環境を指定
   - コマンド: `php artisan notifications:send-scheduled`

**Lambda経由の場合の例:**

```javascript
exports.handler = async (event) => {
    const { exec } = require('child_process');
    
    return new Promise((resolve, reject) => {
        exec('cd /var/task && php artisan notifications:send-scheduled', 
            (error, stdout, stderr) => {
                if (error) {
                    reject(error);
                    return;
                }
                resolve({
                    statusCode: 200,
                    body: stdout
                });
            }
        );
    });
};
```

## 動作確認

1. Vue側でプッシュ通知を有効化
2. Laravelでコマンド実行: `php artisan notifications:send-scheduled`
3. 通知が届くか確認

EventBridgeの設定やインフラ構成について、もっと詳しく知りたい部分はありますか？