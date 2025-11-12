<template>
  <v-app>
    <!-- ログイン画面の場合はレイアウトなしで表示 -->
    <template v-if="isLoginPage">
      <slot />
    </template>

    <!-- その他の画面では共通レイアウトを使用 -->
    <template v-else>
      <!-- 共通ヘッダー -->
      <v-app-bar color="primary" dark>
        <v-app-bar-nav-icon @click="drawer = !drawer">
          <v-icon>mdi-menu</v-icon>
        </v-app-bar-nav-icon>
        <v-toolbar-title>{{ screenTitles[currentRouteName] }}</v-toolbar-title>
        <v-spacer></v-spacer>
        <v-menu>
          <template v-slot:activator="{ props }">
            <v-btn icon v-bind="props">
              <v-icon>mdi-account</v-icon>
            </v-btn>
          </template>
          <v-list>
            <v-list-item @click="$router.push('/user-management')">
              <v-list-item-title>ユーザー管理</v-list-item-title>
            </v-list-item>
            <v-list-item @click="logout">
              <v-list-item-title>ログアウト</v-list-item-title>
            </v-list-item>
          </v-list>
        </v-menu>
      </v-app-bar>

      <!-- ハンバーガーメニュー -->
      <v-navigation-drawer v-model="drawer" temporary>
        <v-list>
          <v-list-item
            prepend-icon="mdi-view-dashboard"
            title="ダッシュボード"
            @click="navigateTo('/dashboard')"
          ></v-list-item>
          <v-list-item
            prepend-icon="mdi-plus-circle"
            title="支出入力"
            @click="navigateTo('/expense-input')"
          ></v-list-item>
          <v-list-item
            prepend-icon="mdi-format-list-bulleted"
            title="支出一覧"
            @click="navigateTo('/expense-list')"
          ></v-list-item>
          <v-list-item
            prepend-icon="mdi-wallet"
            title="予算管理"
            @click="navigateTo('/budget-management')"
          ></v-list-item>
          <v-list-item
            prepend-icon="mdi-cart"
            title="買い物メモ"
            @click="navigateTo('/shopping-memo')"
          ></v-list-item>
          <v-list-item
            prepend-icon="mdi-chart-line"
            title="集計"
            @click="navigateTo('/statistics')"
          ></v-list-item>
          <v-divider></v-divider>
          <v-list-item
            prepend-icon="mdi-account-group"
            title="ユーザー管理"
            @click="navigateTo('/user-management')"
          ></v-list-item>
        </v-list>
      </v-navigation-drawer>

      <v-main>
        <slot />
      </v-main>
    </template>
  </v-app>
</template>

<script setup lang="ts">
import { ref, computed } from 'vue'
import { useRoute, useRouter } from 'vue-router'

const route = useRoute()
const router = useRouter()

const drawer = ref(false)

const currentRouteName = computed(() => route.name as string)

const isLoginPage = computed(() => {
  return route.name === 'login'
})

const screenTitles: Record<string, string> = {
  dashboard: 'ダッシュボード',
  'expense-input': '支出入力',
  'expense-list': '支出一覧',
  'budget-management': '予算管理',
  'shopping-memo': '買い物メモ',
  statistics: '集計',
  'user-management': 'ユーザー管理',
}

const navigateTo = (path: string) => {
  router.push(path)
  drawer.value = false
}

const logout = () => {
  router.push('/')
}
</script>
