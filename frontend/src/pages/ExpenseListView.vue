<template>
  <v-container>
    <v-card>
      <v-card-title>
        <v-icon class="mr-2">mdi-format-list-bulleted</v-icon>
        支出一覧
      </v-card-title>
      <v-card-text>
        <v-row class="mb-4">
          <v-col cols="12" md="4">
            <v-text-field v-model="expenseFilter.date" label="日付" type="date"></v-text-field>
          </v-col>
          <v-col cols="12" md="4">
            <v-select
              v-model="expenseFilter.category"
              :items="filterCategories"
              label="カテゴリ"
            ></v-select>
          </v-col>
        </v-row>
        <v-data-table :headers="expenseHeaders" :items="allExpenses" :items-per-page="10">
          <template v-slot:[`item.amount`]="{ item }">
            ¥{{ item.amount.toLocaleString() }}
          </template>
          <template v-slot:[`item.actions`]="{ item }">
            <v-btn icon size="small" color="error" @click="deleteExpense(item.id)">
              <v-icon>mdi-delete</v-icon>
            </v-btn>
          </template>
        </v-data-table>
      </v-card-text>
    </v-card>
  </v-container>
</template>

<script setup lang="ts">
import { ref } from 'vue'

interface Expense {
  id: number
  date: string
  item: string
  amount: number
  category: string
}

const expenseFilter = ref({
  date: '',
  category: '全て',
})

const categories = ref(['食費', '交通費', '娯楽', '日用品', '医療費', 'その他'])
const filterCategories = ref(['全て', ...categories.value])

const allExpenses = ref<Expense[]>([
  { id: 1, date: '2024-01-15', item: '牛乳', amount: 180, category: '食費' },
  { id: 2, date: '2024-01-15', item: 'パン', amount: 120, category: '食費' },
  { id: 3, date: '2024-01-15', item: 'ガソリン', amount: 3500, category: '交通費' },
  { id: 4, date: '2024-01-14', item: 'お米', amount: 2800, category: '食費' },
  { id: 5, date: '2024-01-14', item: '映画チケット', amount: 1800, category: '娯楽' },
  { id: 6, date: '2024-01-13', item: 'コーヒー', amount: 350, category: '食費' },
  { id: 7, date: '2024-01-13', item: '電車', amount: 220, category: '交通費' },
])

const expenseHeaders = ref([
  { title: '日付', key: 'date' },
  { title: '品目', key: 'item' },
  { title: 'カテゴリ', key: 'category' },
  { title: '金額', key: 'amount' },
  { title: '操作', key: 'actions', sortable: false },
])

const deleteExpense = (id: number) => {
  const index = allExpenses.value.findIndex((expense) => expense.id === id)
  if (index > -1) {
    allExpenses.value.splice(index, 1)
  }
}
</script>
