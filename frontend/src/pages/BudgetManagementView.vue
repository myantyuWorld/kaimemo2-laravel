<template>
  <v-container>
    <v-card>
      <v-card-title>
        <v-icon class="mr-2">mdi-wallet</v-icon>
        予算管理
      </v-card-title>
      <v-card-text>
        <v-row>
          <v-col cols="12" md="6" v-for="budget in budgets" :key="budget.category">
            <v-card outlined>
              <v-card-title>{{ budget.category }}</v-card-title>
              <v-card-text>
                <v-text-field
                  v-model="budget.total"
                  label="予算上限"
                  type="number"
                  prefix="¥"
                ></v-text-field>
                <div class="mb-2">
                  使用済み: ¥{{ (budget.total - budget.remaining).toLocaleString() }}
                </div>
                <div class="mb-2">残額: ¥{{ budget.remaining.toLocaleString() }}</div>
                <v-progress-linear
                  :value="((budget.total - budget.remaining) / budget.total) * 100"
                  :color="budget.remaining < budget.total * 0.2 ? 'error' : 'primary'"
                  height="20"
                ></v-progress-linear>
              </v-card-text>
            </v-card>
          </v-col>
        </v-row>
      </v-card-text>
      <v-card-actions>
        <v-btn color="primary" @click="updateBudgets"> 予算を更新 </v-btn>
      </v-card-actions>
    </v-card>
  </v-container>
</template>

<script setup lang="ts">
import { ref } from 'vue'

interface Budget {
  category: string
  total: number
  remaining: number
}

const budgets = ref<Budget[]>([
  { category: '食費', total: 50000, remaining: 32200 },
  { category: '交通費', total: 15000, remaining: 11280 },
  { category: '娯楽', total: 20000, remaining: 18200 },
  { category: '日用品', total: 10000, remaining: 8500 },
])

const updateBudgets = () => {
  alert('予算が更新されました')
}
</script>
