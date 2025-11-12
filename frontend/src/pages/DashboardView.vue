<template>
  <v-container>
    <v-row>
      <v-col cols="12">
        <v-card>
          <v-card-title>
            <v-icon class="mr-2">mdi-view-dashboard</v-icon>
            今日の支出 ({{ today }})
          </v-card-title>
          <v-card-text>
            <v-list>
              <v-list-item v-for="expense in todayExpenses" :key="expense.id">
                <v-list-item-content>
                  <v-list-item-title>{{ expense.item }}</v-list-item-title>
                  <v-list-item-subtitle>{{ expense.category }}</v-list-item-subtitle>
                </v-list-item-content>
                <v-list-item-action>
                  <v-chip color="error">¥{{ expense.amount.toLocaleString() }}</v-chip>
                </v-list-item-action>
              </v-list-item>
            </v-list>
            <v-divider class="my-4"></v-divider>
            <div class="text-h6 text-right">今日の合計: ¥{{ todayTotal.toLocaleString() }}</div>
          </v-card-text>
          <v-card-actions>
            <v-btn color="primary" @click="$router.push('/expense-input')">
              <v-icon class="mr-2">mdi-plus</v-icon>
              支出を追加
            </v-btn>
            <v-btn color="secondary" @click="$router.push('/expense-list')">
              <v-icon class="mr-2">mdi-format-list-bulleted</v-icon>
              支出一覧
            </v-btn>
          </v-card-actions>
        </v-card>
      </v-col>
    </v-row>

    <v-row class="mt-4">
      <v-col cols="12" md="6">
        <v-card>
          <v-card-title>
            <v-icon class="mr-2">mdi-wallet</v-icon>
            予算残額
          </v-card-title>
          <v-card-text>
            <div v-for="budget in budgets" :key="budget.category" class="mb-3">
              <div class="d-flex justify-space-between align-center">
                <span>{{ budget.category }}</span>
                <span
                  >¥{{ budget.remaining.toLocaleString() }} / ¥{{
                    budget.total.toLocaleString()
                  }}</span
                >
              </div>
              <v-progress-linear
                :value="((budget.total - budget.remaining) / budget.total) * 100"
                :color="budget.remaining < budget.total * 0.2 ? 'error' : 'primary'"
                height="20"
                class="mt-1"
              ></v-progress-linear>
            </div>
          </v-card-text>
          <v-card-actions>
            <v-btn color="primary" @click="$router.push('/budget-management')"> 予算管理 </v-btn>
          </v-card-actions>
        </v-card>
      </v-col>
      <v-col cols="12" md="6">
        <v-card>
          <v-card-title>
            <v-icon class="mr-2">mdi-cart</v-icon>
            買い物メモ
          </v-card-title>
          <v-card-text>
            <v-list>
              <v-list-item v-for="item in shoppingList.slice(0, 3)" :key="item.id">
                <v-list-item-content>
                  <v-list-item-title :class="{ 'text-decoration-line-through': item.completed }">
                    {{ item.name }}
                  </v-list-item-title>
                </v-list-item-content>
                <v-list-item-action>
                  <v-checkbox v-model="item.completed"></v-checkbox>
                </v-list-item-action>
              </v-list-item>
            </v-list>
            <div v-if="shoppingList.length > 3" class="text-center">
              他 {{ shoppingList.length - 3 }} 件
            </div>
          </v-card-text>
          <v-card-actions>
            <v-btn color="primary" @click="$router.push('/shopping-memo')"> 買い物メモ </v-btn>
          </v-card-actions>
        </v-card>
      </v-col>
    </v-row>

    <v-row class="mt-4">
      <v-col cols="12">
        <v-card>
          <v-card-title>
            <v-icon class="mr-2">mdi-chart-line</v-icon>
            今週の支出サマリー
          </v-card-title>
          <v-card-text>
            <div class="chart-placeholder">
              <span>支出グラフ (¥{{ weeklyTotal.toLocaleString() }})</span>
            </div>
          </v-card-text>
          <v-card-actions>
            <v-btn color="primary" @click="$router.push('/statistics')"> 詳細な集計 </v-btn>
          </v-card-actions>
        </v-card>
      </v-col>
    </v-row>
  </v-container>
</template>

<script setup lang="ts">
import { ref, computed } from 'vue'

const today = new Date().toISOString().substr(0, 10)

const todayExpenses = ref([
  { id: 1, item: '牛乳', amount: 180, category: '食費' },
  { id: 2, item: 'パン', amount: 120, category: '食費' },
  { id: 3, item: 'ガソリン', amount: 3500, category: '交通費' },
])

const budgets = ref([
  { category: '食費', total: 50000, remaining: 32200 },
  { category: '交通費', total: 15000, remaining: 11280 },
  { category: '娯楽', total: 20000, remaining: 18200 },
  { category: '日用品', total: 10000, remaining: 8500 },
])

const shoppingList = ref([
  { id: 1, name: '牛乳', completed: false },
  { id: 2, name: '卵', completed: true },
  { id: 3, name: 'パン', completed: false },
  { id: 4, name: 'りんご', completed: false },
  { id: 5, name: '洗剤', completed: true },
])

const weeklyTotal = ref(15280)

const todayTotal = computed(() => {
  return todayExpenses.value.reduce((sum, expense) => sum + expense.amount, 0)
})
</script>

<style scoped>
.chart-placeholder {
  height: 300px;
  background: #f5f5f5;
  display: flex;
  align-items: center;
  justify-content: center;
  border-radius: 4px;
}
</style>
